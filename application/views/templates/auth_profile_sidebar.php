<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 25-Apr-19
 * Time: 16:01
 */
?>
<div class="profile-sidebar desktop-item">
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Profile</div>
    <a class="profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Show profile') echo ' active-custom';?>" href="<?= base_url('auth/profile') ?>">Show profile</a>
    <a class="profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Profile information') echo ' active-custom';?>" href="<?= base_url('auth/profile/update-profile') ?>">Profile information</a>
    <a class="profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Add/Change picture') echo ' active-custom';?>" href="<?= base_url('auth/profile/change-avatar') ?>">Add/Change picture</a>
  </div>
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Password</div>
    <a class="profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Change password') echo ' active-custom';?>" href="<?= base_url('auth/profile/change-password') ?>">Change password</a>
  </div>
</div>
<div class="profile-sidebar mobile-item">
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Profile</div>
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_profile_sidebar']) && $active_profile_sidebar != 'Change password') : ?>
          <button class="btn dropdown-toggle active-custom limitTextMenu" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $active_profile_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButton">
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Show profile') echo ' active-custom';?>" href="<?= base_url('auth/profile') ?>">Show profile</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Profile information') echo ' active-custom';?>" href="<?= base_url('auth/profile/update-profile') ?>">Profile information</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Add/Change picture') echo ' active-custom';?>" href="<?= base_url('auth/profile/change-avatar') ?>">Add/Change picture</a>
      </div>
    </div>
  </div>
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Password</div>
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_profile_sidebar']) && $active_profile_sidebar == 'Change password') : ?>
          <button class="btn dropdown-toggle active-custom" type="button" id="dropdownMenuProfileButtonChangePassword" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $active_profile_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButtonChangePassword" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButtonChangePassword">
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_profile_sidebar == 'Change password') echo ' active-custom';?>" href="<?= base_url('auth/profile/change-password') ?>">Change password</a>
      </div>
    </div>
  </div>
</div>

