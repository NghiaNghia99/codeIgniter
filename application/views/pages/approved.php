<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="section-404-payment-error">
  <div class="container">
    <div class="section-404-payment-error-content">
      <a href="<?= base_url() ?>" class="redirect-back-item">
        <span class="icon-arrow-left"></span>
        Back to Homepage
      </a>
      <div class="session-404-content">
        <?php if ($status == 'success'): ?>
        <div class="session-404-content-img">
          <img src="<?= base_url('/assets/images/img-avatar-default.png') ?>" alt="">
        </div>
        <div class="session-404-content-text"><?= $message ?></div>
        <?php else: ?>
        <div class="session-404-content-img">
          <img src="<?= base_url('/assets/images/img-error.png') ?>" alt="">
        </div>
        <div class="session-404-content-text"><?= $message ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
