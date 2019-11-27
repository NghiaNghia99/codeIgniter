<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($_SESSION['payment_error_404'])): ?>
    <?php if ($_SESSION['payment_error_404'] == 'orderCID'): ?>
    <div class="section-404-payment-error">
      <div class="container">
        <div class="section-404-payment-error-content">
          <a href="<?= base_url('auth/conference/active-cid') ?>" class="redirect-back-item">
            <span class="icon-arrow-left"></span>
            Back to Conference Management
          </a>
          <div class="payment-error-content">
            <div class="payment-error-content-img">
              <img src="<?= base_url('/assets/images/img-warning-error.png') ?>" alt="">
            </div>
            <div class="payment-error-content-text">
              <div>Payment Error</div>
              <div>Payment was unsuccessful</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php elseif ($_SESSION['payment_error_404'] == 'registerConference'): ?>
    <div class="section-404-payment-error">
      <div class="container">
        <div class="section-404-payment-error-content">
          <a href="<?= base_url('auth/conference/attended') ?>" class="redirect-back-item">
            <span class="icon-arrow-left"></span>
            Back to Conference Management
          </a>
          <div class="payment-error-content">
            <div class="payment-error-content-img">
              <img src="<?= base_url('/assets/images/img-warning-error.png') ?>" alt="">
            </div>
            <div class="payment-error-content-text">
              <div>Payment Error</div>
              <div>Payment was unsuccessful</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php elseif ($_SESSION['payment_error_404'] == 'orderPID'): ?>
    <div class="section-404-payment-error">
      <div class="container">
        <div class="section-404-payment-error-content">
          <a href="<?= base_url('auth/project') ?>" class="redirect-back-item">
            <span class="icon-arrow-left"></span>
            Back to Project List
          </a>
          <div class="payment-error-content">
            <div class="payment-error-content-img">
              <img src="<?= base_url('/assets/images/img-warning-error.png') ?>" alt="">
            </div>
            <div class="payment-error-content-text">
              <div>Payment Error</div>
              <div>Payment was unsuccessful</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="section-404-payment-error">
      <div class="container">
        <div class="section-404-payment-error-content">
          <a href="<?= base_url() ?>" class="redirect-back-item">
            <span class="icon-arrow-left"></span>
            Back to Homepage
          </a>
          <div class="session-404-content">
            <div class="session-404-content-img">
              <img src="<?= base_url('/assets/images/img-error.png') ?>" alt="">
            </div>
            <div class="session-404-content-text">404 NOT FOUND</div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; endif; ?>
