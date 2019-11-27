<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 10:59
 */
?>
<div class="section-error layout-page-custom-1 setHeightContent">
  <div class="title big-font-normal">Error</div>
  <div class="block-white-custom">
    <p>Your account is not active.<br>Please click the activation link we have sent to you.</p>
    <div class="add-spinner btn-custom btn-bg green"><a href="<?= base_url('register/active-account/send-again/' . $sid) ?>">Send
        Activation Link again</a></div>
  </div>
</div>
