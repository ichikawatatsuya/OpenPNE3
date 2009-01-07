<?php

/**
 * Copyright (C) 2005-2009 OpenPNE Project
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class opGenerateModuleTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('plugin', sfCommandArgument::REQUIRED, 'The OpenPNE plugin name'),
      new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
      new sfCommandArgument('module', sfCommandArgument::REQUIRED, 'The module name'),
    ));

    $this->namespace = 'opGenerate';
    $this->name = 'module';
    $this->briefDescription = 'Generates a new module for OpenPNE plugin';
    $this->detailedDescription = <<<EOF
The [opGenerate:module|INFO] task creates the basic directory structure
for a new module in an existing OpenPNE plugin application:

  [./symfony opGenerate:module opSamplePlugin pc_frontend sample|INFO]

The task can also change the author name found in the [actions.class.php|COMMENT]
if you have configured it in [config/properties.ini|COMMENT] or
[%sf_plugins_dir%/config/properties.ini|COMMENT]:

  [[symfony]|NONE]
    name=OpenPNE
    author=Your Name <youremail@example.com>

You can customize the default skeleton used by the task by creating a
[/lib/task/skeleton/module|COMMENT] directory.

If a module with the same name already exists in the application,
it throws a [sfCommandException|COMMENT].
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $plugin = $arguments['plugin'];
    $app    = $arguments['application'];
    $module = $arguments['module'];

    $pluginsDir = sfConfig::get('sf_plugins_dir').'/'.$plugin;

    // Validate the module name
    if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $module))
    {
      throw new sfCommandException(sprintf('The module name "%s" is invalid.', $module));
    }

    $moduleDir = $pluginsDir.'/apps/'.$app.'/modules/'.$module;

    if (is_dir($moduleDir))
    {
      throw new sfCommandException(sprintf('The module "%s" already exists in the "%s" application.in the "%s" plugin', 
                                                                    $moduleDir, $app, $plugin));
    }

    $properties = parse_ini_file(sfConfig::get('sf_config_dir').'/properties.ini', true);
    if (is_readable($pluginsDir.'/config/properties.ini'))
    {
      $pluginProperties = parse_ini_file($pluginsDir.'/config/properties.ini', true);
      $properties = array_merge($properties, $pluginProperties);
    }

    $constants = array(
      'PROJECT_NAME' => isset($properties['symfony']['name']) ? $properties['symfony']['name'] : 'symfony',
      'APP_NAME'     => $app,
      'MODULE_NAME'  => $module,
      'AUTHOR_NAME'  => isset($properties['symfony']['author']) ? $properties['symfony']['author'] : 'Your name here',
    );

    $skeletonDir = dirname(__FILE__).'/skeleton/module';

    // create basic application structure
    $finder = sfFinder::type('any')->discard('.sf');
    $this->getFilesystem()->mirror($skeletonDir.'/module', $moduleDir, $finder);

    // customize php and yml files
    $finder = sfFinder::type('file')->name('*.php', '*.yml');
    $this->getFilesystem()->replaceTokens($finder->in($moduleDir), '##', '##', $constants);
  }
}
