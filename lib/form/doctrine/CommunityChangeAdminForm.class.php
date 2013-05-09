<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityChangeAdminForm
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     tatsuya ichikawa <ichikawa@tejimaya.com>
 */
class CommunityChangeAdminForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'communityAdmin' => new sfWidgetFormInputText(),
    ));
    $this->widgetSchema->setLabels(array(
      'communityAdmin' => sfContext::getInstance()->getI18N()->__('%Community% Administrator'),
    ));
    $this->setValidators(array(
      'communityAdmin' => new sfValidatorRegex(array('pattern' => '/^[0-9]+$/')),
    ));
  }
}
