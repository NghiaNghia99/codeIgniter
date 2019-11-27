<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 25-Apr-19
 * Time: 11:24
 */
?>
<div class="section-register setHeightContent">
    <div class="container">
        <div class="title big-font-normal">Your status of registration</div>
        <div class="block-white">
            <?php if (!isset($_SESSION['login'])) : ?>
                <p>Thank you for your registration at ScienceMedia.</p>
                <p>Shortly you should receive an activation email for your account.<br/>
                    If you do not receive the activation mail, please check your spam folder or contact our team for support.</p>
                <p>No mail?<br/>
                    The mail was sent to <span class="email-item"><?= $user->email ?></span>
                </p>
                <div class="group-button desktop-item d-flex">
                    <div class="add-spinner btn-custom btn-bg gray"><a href="<?= base_url('register/check-email/'.$user->sid) ?>">Resend</a></div>
                    <div class="btn-custom btn-bg gray"><a href="<?= base_url('register/change-mail-register') ?>">Change email address</a></div>
                    <div class="btn-custom btn-bg green"><a href="<?= base_url('login') ?>">Back to Login</a></div>
                </div>
                <div class="group-button mobile-item">
                    <div class="d-flex justify-content-between">
                        <div class="btn-custom btn-bg gray"><a href="<?= base_url('register/change-mail-register') ?>">Change email address</a></div>
                        <div class="add-spinner btn-custom btn-bg gray"><a href="<?= base_url('register/check-email/'.$user->sid) ?>">Resend</a></div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <div class="btn-custom btn-bg green"><a href="<?= base_url('login') ?>">Back to Login</a></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
