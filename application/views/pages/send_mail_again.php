<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 10:59
 */
?>
<div class="section-error layout-page-custom-1 setHeightContent">
  <div class="title big-font-normal">Your status of activation</div>
  <div class="block-white-custom">
    <p>Shortly you should receive an activation email for your account.<br/>
      If you do not receive the activation mail, please check your spam folder or contact our team for support.</p>
    <p>No mail?<br/>
      The mail was sent to <span class="email-item"><?= $user->email ?></span>
    </p>
    <div class="btn-custom btn-bg green btn-login"><a href="<?= base_url('login') ?>">Back to Login</a></div>
  </div>
</div>
