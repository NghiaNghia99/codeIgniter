<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 25-Apr-19
 * Time: 15:54
 */

$avatar_jpg = 'uploads/userfiles/' . $user[0]->id . '/profilePhoto.jpg';
if (file_exists($avatar_jpg)) {
    $avatar = $avatar_jpg . '?' . time();
} else {
    $avatar = 'assets/images/img-avatar-default.png';
}
?>
<div class="section-profile block-white">
  <a href="<?= base_url('auth/profile/change-avatar') ?>" class="avatar-item">
    <img src="<?= base_url($avatar); ?>" id="avatar_profile" alt="Avatar default"/>
  </a>
  <div class="block-content">
    <div class="block-content-info">
      <div class="block-content-info-title">
        <div class="title"><?= $user[0]->firstName . ' ' . $user[0]->lastName ?></div>
        <div class="affiliation-item"><?= $user[0]->affiliation ?></div>
      </div>
      <div class="show-info-item-mr-8">
        <div class="label">Position</div>
        <div class="info"><?php if (!empty($user[0]->position)) echo $user[0]->position; else echo 'Empty'; ?></div>
      </div>
      <div class="show-info-item-mr-8">
        <div class="label">Department</div>
        <div class="info"><?php if (!empty($user[0]->department)) echo $user[0]->department; else echo 'Empty'; ?></div>
      </div>
      <div class="show-info-item-mr-8 <?php if (!empty( $user[1][0]['name'])) echo 'display-block'; ?>">
        <div class="label">Field of research</div>
        <div class="info"><?php if (!empty($user[1][0]['name'])) echo $user[1][0]['name']; else echo 'Empty'; ?>
          (<?php if (!empty($user[1][1]['name'])) echo $user[1][1]['name']; else echo 'Empty'; ?>)
        </div>
      </div>
      <div class="show-info-item-mr-8">
        <div class="label">Email</div>
        <div class="info"><?= $user[0]->email ?></div>
      </div>
    </div>
    <div class="block-content-upload">
      <div class="desktop-item">
        <div>
          <a href="<?= base_url('auth/content/video/upload') ?>" class="img-item">
            <img src="<?= base_url('/assets/images/icons/icon-upload-video.png') ?>" alt="">
          </a>
          <a class="title-item" href="<?= base_url('auth/content/video/upload') ?>">Upload Video</a>
          <div class="desc-item">Up to 300MB</div>
        </div>
        <div>
          <a href="<?= base_url('auth/content/poster/upload') ?>" class="img-item">
            <img src="<?= base_url('/assets/images/icons/icon-upload-poster.png') ?>" alt="">
          </a>
          <a class="title-item" href="<?= base_url('auth/content/poster/upload') ?>">Upload Poster</a>
          <div class="desc-item">Up to 50MB</div>
        </div>
        <div>
          <a href="<?= base_url('auth/content/presentation/upload') ?>" class="img-item">
            <img src="<?= base_url('/assets/images/icons/icon-upload-presentation.png') ?>" alt="">
          </a>
          <a class="title-item" href="<?= base_url('auth/content/presentation/upload') ?>">Upload Presentation</a>
          <div class="desc-item">Up to 200MB</div>
        </div>
        <div>
          <a href="<?= base_url('auth/content/paper/upload') ?>" class="img-item">
            <img src="<?= base_url('/assets/images/icons/icon-upload-paper.png') ?>" alt="">
          </a>
          <a class="title-item" href="<?= base_url('auth/content/paper/upload') ?>">Upload Paper</a>
          <div class="desc-item">Up to 50MB</div>
        </div>
      </div>
      <div class="mobile-item">
        <div>
          <div>
            <div class="img-item">
              <a href="<?= base_url('auth/content/video/upload') ?>">
                <img src="<?= base_url('/assets/images/icons/icon-upload-video.png') ?>" alt="">
              </a>
            </div>
            <a class="title-item" href="<?= base_url('auth/content/video/upload') ?>">Upload Video</a>
            <div class="desc-item">Up to 300MB</div>
          </div>
          <div>
            <div class="img-item">
              <a href="<?= base_url('auth/content/poster/upload') ?>">
                <img src="<?= base_url('/assets/images/icons/icon-upload-poster.png') ?>" alt="">
              </a>
            </div>
            <a class="title-item" href="<?= base_url('auth/content/poster/upload') ?>">Upload Poster</a>
            <div class="desc-item">Up to 50MB</div>
          </div>
        </div>
        <div>
          <div>
            <div class="img-item">
              <a href="<?= base_url('auth/content/presentation/upload') ?>">
                <img src="<?= base_url('/assets/images/icons/icon-upload-presentation.png') ?>" alt="">
              </a>
            </div>
            <a class="title-item" href="<?= base_url('auth/content/presentation/upload') ?>">Upload Presentation</a>
            <div class="desc-item">Up to 200MB</div>
          </div>
          <div>
            <div class="img-item">
              <a href="<?= base_url('auth/content/paper/upload') ?>">
                <img src="<?= base_url('/assets/images/icons/icon-upload-paper.png') ?>" alt="">
              </a>
            </div>
            <a class="title-item" href="<?= base_url('auth/content/paper/upload') ?>">Upload Paper</a>
            <div class="desc-item">Up to 50MB</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
