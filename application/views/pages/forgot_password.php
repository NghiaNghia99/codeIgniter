<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 02-May-19
 * Time: 09:30
 */
?>
<div class="section-forgot-password setHeightContent">
  <div class="title big-font-normal">Forgot password?</div>
  <div class="block-white">
    <p>If you have forgotten your password, please provide your email address below. An email containing a link for resetting the password will be send to you shortly.</p>
    <form method="post">
      <div class="form-item">
        <label class="form-label label-custom">Email<span class="req">*</span></label>
        <input type="text" class="input input-custom" name="email" placeholder="Email" value="<?php echo set_value('email')?>">
        <div class="error"><?php echo form_error('email')?></div>
      </div>
      <div class="group-button d-flex">
        <div class="btn-custom btn-bg gray"><a href="<?= base_url('login') ?>">Cancel</a></div>
        <input type="submit" class="add-spinner btn-custom btn-bg green" value="Submit" name='submit'>
      </div>
    </form>
  </div>
</div>
