<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-Apr-19
 * Time: 11:44
 */
?>
<div class="section-login setHeightContent">
  <div class="title big-font-normal">Login</div>
  <form method="post" class="form-login">
    <div class="block-white">
      <div class="form-item">
        <label class="form-label label-custom">Email<span class="req">*</span></label>
        <input type="text" class="input input-custom" name="email" placeholder="Email"
               value="<?php echo set_value('email') ?>">
        <div class="error error-login"><?php echo form_error('email') ?></div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">Password<span class="req">*</span></label>
        <input type="password" class="input input-custom" name="password" placeholder="Password"
               value="<?php echo set_value('password') ?>">
        <div class="error error-login"><?php echo form_error('password') ?></div>
      </div>
    </div>
    <div class="forgot-password-item">
      <a class="link" href="<?= base_url('forgot-password') ?>">Forgot password?</a>
    </div>
    <div class="group-button d-flex">
      <input type="submit" class="add-spinner btn-custom btn-bg green" value="Login" name='login'>
      <div class="btn-custom btn-bg gray"><a href="<?= base_url('register') ?>">Register</a></div>
    </div>
    <div class="error error-fw-bold error-submit-login mt-3"><?php echo form_error('login') ?></div>
  </form>
</div>