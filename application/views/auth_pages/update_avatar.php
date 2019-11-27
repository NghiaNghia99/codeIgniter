<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 03-May-19
 * Time: 09:56
 */

$avatar_jpg = 'uploads/userfiles/' . $user->id . '/' . $file_name;
if (file_exists($avatar_jpg)) {
    $avatar = $avatar_jpg . '?' . time();
} else {
    $avatar = 'assets/images/img-avatar-default.png';
}
?>
<?php if (empty($_SESSION['waitForApprove'])): ?>
  <div class="section-update-avatar block-white-p40-100">
    <div>
      <div class="img-item">
        <img src="<?= base_url() . $avatar ?>" id="avatar_profile" alt="Avatar"/>
      </div>
      <form method="post" action="<?= base_url('auth/profile/change-avatar/change') ?>" enctype="multipart/form-data">
        <div class="btn-choose-file">
          <label for="input_avatar_profile">Choose File</label>
          <input type="file" name="avatar" id="input_avatar_profile"/>
        </div>
        <div id="avatar_upload_info"></div>
        <input type="submit" id="btn_upload_avatar" class="add-spinner btn-custom btn-bg green text-center"
               value="Upload"/>
          <?php if ($this->session->flashdata('upload_avatar_msg')) :
              if ($this->session->flashdata('upload_avatar_msg') == 'Profile photo has been uploaded successfully!'):
                  ?>
                <div class="success error-fw-bold mt-3"
                     id="upload_avatar_msg"><?= $this->session->flashdata('upload_avatar_msg') ?></div>
              <?php else: ?>
                <div class="error error-fw-bold mt-3"
                     id="upload_avatar_msg"><?= $this->session->flashdata('upload_avatar_msg') ?></div>
              <?php endif; endif; ?>
      </form>
    </div>
  </div>
<?php else: ?>
  <div class="block-white-p40-100">
    You have registered with an email address that does not seem to belong to an institution, university or company.
    Until we approve your address, you may not upload any content due to quality and securtiy measures. If you have any
    further questions, please contact us.
  </div>
<?php endif; ?>
