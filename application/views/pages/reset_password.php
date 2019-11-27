<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 02-May-19
 * Time: 09:30
 */
?>
<div class="section-reset-password setHeightContent">
  <div class="title big-font-normal">Hello <?= $user->firstName ?> <?= $user->lastName ?></div>
    <form method="post">
      <div class="block-white">
        <p>The verification of your email-address was successfull.<br>You may change your password now. </p>
        <div class="form-item">
          <label class="form-label label-custom">New Password:<span class="req">*</span></label>
          <input type="password" class="input input-custom" id="password" name="password" placeholder="Password" value="<?php echo set_value('password')?>">
          <div class="error"><?php echo form_error('password')?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">Repeat Password:<span class="req">*</span></label>
          <input type="password" class="input input-custom" id="re_password" name="re_password" placeholder="Repeat password" value="<?php echo set_value('re_password')?>">
          <div class="error"><?php echo form_error('re_password')?></div>
        </div>
        <div class="mobile-item">
          <div class="form-item">
            <label class="form-label label-custom label-custom-special">Required fields <span class="req">*</span></label>
          </div>
          <div class="group-button">
            <input type="submit" class="add-spinner btn-custom btn-bg green" value="Save Change" name='submit'>
            <div class="btn-custom btn-bg gray"><a href="<?= base_url() ?>">Cancel</a></div>
          </div>
        </div>
      </div>
      <div class="desktop-item">
        <div class="form-item">
          <label class="form-label label-custom label-custom-special">Required fields <span class="req">*</span></label>
        </div>
        <div class="group-button">
          <input type="submit" class="add-spinner btn-custom btn-bg green" value="Save Change" name='submit'>
          <div class="btn-custom btn-bg gray"><a href="<?= base_url() ?>">Cancel</a></div>
        </div>
      </div>
    </form>
</div>