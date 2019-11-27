<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 07-May-19
 * Time: 15:43
 */
?>
<div class="profile-sidebar conference-sidebar desktop-item">
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Conferences</div>
    <a class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Attended conferences') {
        echo ' active-custom';
    } ?>" href="<?= base_url('auth/conference/attended') ?>">Attended conferences</a>
    <a class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Managed conferences') {
        echo ' active-custom';
    } ?>" href="<?= base_url('auth/conference/managed') ?>">Managed conferences</a>
  </div>
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Conference Setup</div>
    <a class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Info CID service') {
        echo ' active-custom';
    } ?>" href="<?= base_url('auth/conference/info-cid') ?>">Info CID service</a>
    <a class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Order CID') {
        echo ' active-custom';
    } ?>" href="<?= base_url('auth/conference/order-cid') ?>">Order CID</a>
    <a
      class="profile-sidebar-item-content block-white active-cid-item <?php if ($active_conference_sidebar == 'Active CID') {
          echo ' active-custom';
      } ?>" href="<?= base_url('auth/conference/active-cid') ?>">Active CID</a>
  </div>
    <?php if (isset($_SESSION['conferenceInfo']) && $_SESSION['conferenceInfo']['type'] == 'managed') : ?>
      <div class="profile-sidebar-item">
        <div class="profile-sidebar-item-title">Manage conference</div>
        <a
          class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Conference web preview') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/conference-page/' . $_SESSION['conferenceInfo']['id']) ?>">Conference
          web preview</a>
          <?php if ($_SESSION['permission']->editConference == 1): ?>
            <a
              class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Edit conferences page') {
                  echo ' active-custom';
              } ?>"
              href="<?= base_url('auth/conference/managed/conference-edit/basic-information/' . $_SESSION['conferenceInfo']['id']) ?>">Edit
              conferences page</a>
          <?php endif; ?>
          <?php if ($_SESSION['permission']->editRegistration == 1): ?>
            <a class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Registration') {
                echo ' active-custom';
            } ?>"
               href="<?= base_url('auth/conference/register/registration-conference/' . $_SESSION['conferenceInfo']['id']) ?>">Registration</a>
          <?php endif; ?>
          <?php if ($_SESSION['permission']->editAbstracts == 1): ?>
            <a class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Abstracts') {
                echo ' active-custom';
            } ?>" href="<?= base_url('auth/conference/abstract-conference/' . $_SESSION['conferenceInfo']['id']) ?>">Abstracts</a>
          <?php endif; ?>
          <?php if ($_SESSION['permission']->editRestrict == 1): ?>
            <a
              class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Restricted Access') {
                  echo ' active-custom';
              } ?>" href="<?= base_url('auth/conference/restricted-access/' . $_SESSION['conferenceInfo']['id']) ?>">Restricted
              Access</a>
          <?php endif; ?>
          <?php if ($_SESSION['permission']->editContributions == 1): ?>
            <a
              class="profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Manage contributions') {
                  echo ' active-custom';
              } ?>"
              href="<?= base_url('auth/conference/managed/manage-contribution/' . $_SESSION['conferenceInfo']['id']) ?>">Manage
              contributions</a>
          <?php endif; ?>
      </div>
    <?php endif; ?>
</div>
<div class="profile-sidebar mobile-item">
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Conferences</div>
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_conference_sidebar']) && ($active_conference_sidebar == 'Attended conferences' || $active_conference_sidebar == 'Managed conferences')) : ?>
          <button class="btn dropdown-toggle active-custom limitTextMenu" type="button" id="dropdownMenuProfileButton"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $active_conference_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButton">
        <a
          class="dropdown-item profile-sidebar-item-content block-white limitTextMenu <?php if ($active_conference_sidebar == 'Attended conferences') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/attended') ?>">Attended conferences</a>
        <a
          class="dropdown-item profile-sidebar-item-content block-white limitTextMenu <?php if ($active_conference_sidebar == 'Managed conferences') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/managed') ?>">Managed conferences</a>
      </div>
    </div>
  </div>
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Conference Setup</div>
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_conference_sidebar']) && (
          $active_conference_sidebar == 'Info CID service' ||
          $active_conference_sidebar == 'Order CID' ||
          $active_conference_sidebar == 'Active CID')) : ?>
          <button class="btn dropdown-toggle active-custom limitTextMenu" type="button"
                  id="dropdownMenuProfileButtonChangePassword"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $active_conference_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButtonChangePassword"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButtonChangePassword">
        <a
          class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Info CID service') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/info-cid') ?>">Info CID service</a>
        <a
          class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Order CID') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/order-cid') ?>">Order CID</a>
        <a
          class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Active CID') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/active-cid') ?>">Active CID</a>
      </div>
    </div>
  </div>
  <?php if (isset($_SESSION['conferenceInfo']) && $_SESSION['conferenceInfo']['type'] == 'managed') : ?>
    <div class="profile-sidebar-item">
      <div class="profile-sidebar-item-title">Manage conference</div>
      <div class="dropdown dropdown-menu-custom">
          <?php
          if (isset($_SESSION['active_conference_sidebar']) &&
            ($active_conference_sidebar == 'Conference web preview' ||
              $active_conference_sidebar == 'Edit conferences page' ||
              $active_conference_sidebar == 'Registration' ||
              $active_conference_sidebar == 'Abstracts' ||
              $active_conference_sidebar == 'Restricted Access' ||
              $active_conference_sidebar == 'Manage contributions')) : ?>
            <button class="btn dropdown-toggle active-custom" type="button"
                    id="dropdownMenuProfileButtonChangePassword"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $active_conference_sidebar ?>
            </button>
          <?php else : ?>
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButtonChangePassword"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Choose
            </button>
          <?php endif; ?>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButtonChangePassword">
          <a class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Conference web preview') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/conference-page/' . $_SESSION['conferenceInfo']['id']) ?>">Conference web preview</a>
          <a class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Edit conferences page') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/managed/conference-edit/basic-information/' . $_SESSION['conferenceInfo']['id']) ?>">Edit conferences page</a>
          <a class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Registration') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/register/registration-conference/' . $_SESSION['conferenceInfo']['id']) ?>">Registration</a>
          <a class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Abstracts') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/abstract-conference/' . $_SESSION['conferenceInfo']['id']) ?>">Abstracts</a>
          <a class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Restricted Access') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/restricted-access/' . $_SESSION['conferenceInfo']['id']) ?>">Restricted Access</a>
          <a class="dropdown-item profile-sidebar-item-content block-white <?php if ($active_conference_sidebar == 'Manage contributions') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/conference/managed/manage-contribution/' . $_SESSION['conferenceInfo']['id']) ?>">Manage contributions</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
