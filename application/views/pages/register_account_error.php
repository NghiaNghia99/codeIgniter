<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 10:59
 */
?>
<div class="section-error layout-page-custom-1 setHeightContent">
  <div class="title big-font-normal">Notification</div>
  <div class="block-white-custom">
    <p>
      Your account was registered successfully but is not activated yet. An activation e-mail was sent to you.<br>If you
      cannot find this e-mail, please check your spam folder, or click on the button below to resend this e-mail.
    </p>
    <div class="add-spinner btn-custom btn-bg green"><a
        href="<?= base_url('register/active-account/send-again/' . $sid) ?>">Send Activation Link again</a></div>
  </div>
</div>
