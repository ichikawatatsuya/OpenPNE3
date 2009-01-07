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

class opPluginInstallTask extends sfPluginInstallTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('name', sfCommandArgument::REQUIRED, 'The plugin name'),
    ));

    $this->addOptions(array(
      new sfCommandOption('stability', 's', sfCommandOption::PARAMETER_REQUIRED, 'The preferred stability (stable, beta, alpha)', null),
      new sfCommandOption('release', 'r', sfCommandOption::PARAMETER_REQUIRED, 'The preferred version', null),
      new sfCommandOption('channel', 'c', sfCommandOption::PARAMETER_REQUIRED, 'The PEAR channel name', 'plugins.openpne.jp'),
      new sfCommandOption('install_deps', 'd', sfCommandOption::PARAMETER_NONE, 'Whether to force installation of required dependencies', null),
      new sfCommandOption('force-license', null, sfCommandOption::PARAMETER_NONE, 'Whether to force installation even if the license is not MIT like'),
    ));

    $this->namespace        = 'opPlugin';
    $this->name             = 'install';
    $this->briefDescription = 'Installs the OpenPNE plugin';
    $this->detailedDescription = <<<EOF
The [plugin:install|INFO] task installs the OpenPNE plugin:
Call it with:

  [./symfony opPlugin:install opSamplePlugin|INFO]
EOF;
  }

  public function getPluginManager()
  {
    if (is_null($this->pluginManager))
    {
      $this->pluginManager = new opPluginManager($this->dispatcher);
    }

    return $this->pluginManager;
  }
}
