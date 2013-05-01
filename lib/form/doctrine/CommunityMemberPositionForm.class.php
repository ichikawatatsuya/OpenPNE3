<?php

/**
 * CommunityMemberPosition form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommunityMemberPositionForm extends BaseCommunityMemberPositionForm
{
  public function configure()
  {
    unset($this['id'], $this['community_id'], $this['community_member_id'], $this['name'], $this['created_at'], $this['updated_at']);
    $this->setWidget('member_id', new sfWidgetFormInputText());
    $this->widgetSchema->setLabels(array(
      'member_id' => sfContext::getInstance()->getI18N()->__('%Community% Administrator')
    ));
    $this->setValidators(array(
      'member_id' => new sfValidatorRegex(array('pattern' => '/^[0-9]+$/')),
    ));
  }
}
