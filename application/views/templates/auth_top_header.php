<div class="top-header">
  <div class="top-header-content desktop-item">
    <div class="title small-title">Science Bench</div>
    <div class="w-100">
      <div class="top-header-content-list">
        <a class="top-header-content-item <?php if ($active_top_header == 'profile') echo 'active-custom';?>" href="<?= base_url('auth/profile') ?>">Profile</a>
        <a class="top-header-content-item <?php if ($active_top_header == 'content') echo 'active-custom';?>" href="<?= base_url('auth/content/videos') ?>">Content</a>
        <a class="top-header-content-item <?php if ($active_top_header == 'conference') echo 'active-custom';?>" href="<?= base_url('auth/conference/attended') ?>">Conferences</a>
        <a class="top-header-content-item <?php if ($active_top_header == 'postbox') echo 'active-custom';?>" href="<?= base_url('auth/invoice') ?>">Postbox</a>
        <a class="top-header-content-item <?php if ($active_top_header == 'project') echo 'active-custom';?>" href="<?= base_url('auth/project') ?>">Projects</a>
      </div>
    </div>
  </div>
  <div class="top-header-content mobile-item">
    <div class="title small-title">Science Bench</div>
    <div class="scroll-x">
      <div class="top-header-content-list">
        <a class="top-header-content-item menu-profile <?php if ($active_top_header == 'profile') echo 'active-custom';?>" href="<?= base_url('auth/profile') ?>">Profile</a>
        <a class="top-header-content-item menu-content <?php if ($active_top_header == 'content') echo 'active-custom';?>" href="<?= base_url('auth/content/videos') ?>">Content</a>
        <a class="top-header-content-item menu-conference <?php if ($active_top_header == 'conference') echo 'active-custom';?>" href="<?= base_url('auth/conference/attended') ?>">Conferences</a>
        <a class="top-header-content-item menu-postbox <?php if ($active_top_header == 'postbox') echo 'active-custom';?>" href="<?= base_url('auth/invoice') ?>">Postbox</a>
        <a class="top-header-content-item menu-project <?php if ($active_top_header == 'project') echo 'active-custom';?>" href="<?= base_url('auth/project') ?>">Projects</a>
      </div>
    </div>
  </div>
</div>