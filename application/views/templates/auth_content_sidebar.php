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
    <div class="profile-sidebar-item-title">My Content</div>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Videos') echo ' active-custom';?>" href="<?= base_url('auth/content/videos') ?>">Videos</a>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Presentations') echo ' active-custom';?>" href="<?= base_url('auth/content/presentations') ?>">Presentations</a>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Posters') echo ' active-custom';?>" href="<?= base_url('auth/content/posters') ?>">Posters</a>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Papers') echo ' active-custom';?>" href="<?= base_url('auth/content/papers') ?>">Papers</a>
  </div>
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Upload Content</div>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Video') echo ' active-custom';?>" href="<?= base_url('auth/content/video/upload') ?>">Videos</a>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Presentation') echo ' active-custom';?>" href="<?= base_url('auth/content/presentation/upload') ?>">Presentations</a>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Poster') echo ' active-custom';?>" href="<?= base_url('auth/content/poster/upload') ?>">Posters</a>
    <a class="profile-sidebar-item-content <?php if ($active_content_sidebar == 'Paper') echo ' active-custom';?>" href="<?= base_url('auth/content/paper/upload') ?>">Papers</a>
  </div>
</div>
<div class="profile-sidebar mobile-item">
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">My Content</div>
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_content_sidebar']) && ($active_content_sidebar == 'Videos' || $active_content_sidebar == 'Presentations' || $active_content_sidebar == 'Posters' || $active_content_sidebar == 'Papers')) : ?>
          <button class="btn dropdown-toggle active-custom" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $active_content_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButton">
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Videos') echo ' active-custom';?>" href="<?= base_url('auth/content/videos') ?>">Videos</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Presentations') echo ' active-custom';?>" href="<?= base_url('auth/content/presentations') ?>">Presentations</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Posters') echo ' active-custom';?>" href="<?= base_url('auth/content/posters') ?>">Posters</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Papers') echo ' active-custom';?>" href="<?= base_url('auth/content/papers') ?>">Papers</a>
      </div>
    </div>
  </div>
  <div class="profile-sidebar-item">
    <div class="profile-sidebar-item-title">Upload Content</div>
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_content_sidebar']) && ($active_content_sidebar == 'Video' || $active_content_sidebar == 'Presentation' || $active_content_sidebar == 'Poster' || $active_content_sidebar == 'Paper')) : ?>
          <button class="btn dropdown-toggle active-custom" type="button" id="dropdownMenuProfileButtonChangePassword" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $active_content_sidebar ?>s
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButtonChangePassword" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButtonChangePassword">
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Video') echo ' active-custom';?>" href="<?= base_url('auth/content/video/upload') ?>">Videos</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Presentation') echo ' active-custom';?>" href="<?= base_url('auth/content/presentation/upload') ?>">Presentations</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Poster') echo ' active-custom';?>" href="<?= base_url('auth/content/poster/upload') ?>">Posters</a>
        <a class="dropdown-item profile-sidebar-item-content <?php if ($active_content_sidebar == 'Paper') echo ' active-custom';?>" href="<?= base_url('auth/content/paper/upload') ?>">Papers</a>
      </div>
    </div>
  </div>
</div>
