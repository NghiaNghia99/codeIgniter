<!-- <?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 07-May-19
 * Time: 11:07
 */
?>
<?php if ($post_type == 'video'): ?>
  <div>
    <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/' . $post['id']) ?>">Video</a>
    <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/edit/' . $post['id']) ?>">Edit</a>
    <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/request-doi/' . $post['id']) ?>">Request
      DOI</a>
    <a class="btn" style="cursor: pointer" href="<?= base_url('') ?>">Link to conference</a>
    <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/delete/' . $post['id']) ?>">Delete
      video</a>
  </div>
<?php endif; ?>
<h3><?= $post['title'] ?></h3>
<h5>SMN - DOI service</h5>
<p>Your DOI was registered successfully.</p>
<p>The DOI of this document is: <b><?= $post['doi'] ?></b></p>
 -->