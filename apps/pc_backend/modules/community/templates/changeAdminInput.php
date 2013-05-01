<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('%Community% change administrator')) ?>

<p><?php echo __('Enter the administrator ID of the %Community% to change.') ?></p>

<?php $f = new BaseForm() ?>
<?php echo $f->renderFormTag(url_for('community/changeAdmin?id='.$community->getId())) ?>
<?php echo '<input type="hidden" name="'.$f->getCSRFFieldName().'" value="'.$f->getCSRFToken().'"/>' ?>
<table>
<?php echo $form ?>
  <tr>
    <td colspan="2">
      <input type="submit" value="<?php echo __('Send') ?>" />
    </td>
  </tr>
</table>
</form>
