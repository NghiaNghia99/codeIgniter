<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 08-May-19
 * Time: 18:08
 */
?>

<div class="section-post-page section-order-cid-now">
  <div class="block-white tab-menu-content">
    <div class="order-cid-content">
      <div class="show-info-item-mr-8 info-title">
        <span class="icon-cid"></span>
        <a><?= $cid['cid'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>First name</div>
        <a><?= $cid['contactFirstName'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Last name</div>
        <a><?= $cid['contactLastName'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Email</div>
        <a><?= $cid['contactEMail'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Affiliation</div>
        <a><?= $cid['billingAffiliation'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Billing street</div>
        <a><?= $cid['billingStreet'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Billing street Nr</div>
        <a><?= $cid['billingStreetNr'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Billing city</div>
        <a><?= $cid['billingCity'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Billing postal code</div>
        <a><?= $cid['billingPostalCode'] ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Billing state</div>
        <a><?php if (!empty($cid['billingState'])) {
                echo $cid['billingState'];
            } else {
                echo 'Empty';
            } ?></a>
      </div>
      <div class="show-info-item-mr-8">
        <div>Billing country</div>
        <a><?= $cid['billingCountry'] ?></a>
      </div>
    </div>
<!--    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">-->
<!--      <input type="hidden" name="cmd" value="_xclick">-->
<!--      <input type="hidden" name="business" value="hung.tran-facilitator@beesightsoft.com">-->
<!--      <input type="hidden" name="item_name" value="--><?//= $cid['cid'] ?><!--">-->
<!--      <input type="hidden" name="user" value="--><?//= $cid['idOfContactSMN'] ?><!--">-->
<!--      <input type="hidden" name="currency_code" value="EUR">-->
<!--      <input type="hidden" name="amount" value="1">-->
<!--      <input type="hidden" name="address_override" value="1">-->
<!--      <input type="hidden" name="notify_url" value="--><?//= base_url('auth/conference/confirm-pay-cid') ?><!--">-->
<!--      <input type='hidden' name='return' value="--><?//= base_url('auth/conference/confirm-pay-cid') ?><!--"/>-->
<!--      <input type="submit" name="submit" value="Buy now" class="btn-custom btn-bg green btn-buy">-->
<!--      <div class="btn-custom btn-bg green btn-buy">-->
<!--        <a href="--><?//= base_url('auth/conference/confirm-pay-cid/change-payment-status') ?><!--">Buy now</a>-->
<!--      </div>-->
<!--    </form>-->
    <form class="paypal paypal_form" action="<?= base_url('auth/conference/pay-cid/checkout') ?>" method="post">
      <input type="hidden" class="getCID" name="item_number" value="<?= $cid['cid'] ?>" />
      <input type="button" class="add-spinner btn-custom btn-bg green btn-buy btnBuyNowOrderCID" value="Pay now"/>
    </form>
  </div>
</div>