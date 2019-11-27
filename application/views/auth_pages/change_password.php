<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 03-May-19
 * Time: 14:45
 */
?>
<div class="section-change-password block-white-p40-100">
  <form method="post">
    <div class="form-small-title">Change Password</div>
    <p>Do you want to change your password?</p>
    <div class="form-item">
      <label class="form-label label-custom">Password<span class="req">*</span></label>
      <input type="password" class="input input-custom" id="password" name="password" placeholder="New Password"
             value="<?php echo set_value('password') ?>">
      <div class="error"><?php echo form_error('password') ?></div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">Repeat Password<span class="req">*</span></label>
      <input type="password" class="input input-custom" id="re_password" name="re_password"
             placeholder="Repeat password" value="<?php echo set_value('re_password') ?>">
      <div class="error"><?php echo form_error('re_password') ?></div>
    </div>
    <input type="submit" class="add-spinner btn-custom btn-bg green" value="Save changes" name='submit'>
      <?php if ($this->session->flashdata( 'change_password_msg' )) : ?>
          <div class="success error-fw-bold mt-3" id="change_password_msg"><?= $this->session->flashdata( 'change_password_msg' ) ?></div>
      <?php endif; ?>
  </form>
</div>

