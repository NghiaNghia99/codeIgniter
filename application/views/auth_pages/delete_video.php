<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 06-May-19
 * Time: 17:08
 */
?>
<div>
  <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/' . $post['id']) ?>">Video</a>
  <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/edit/' . $post['id']) ?>">Edit</a>
  <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/request-doi/' . $post['id']) ?>">Request
    DOI</a>
  <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/link-to-conference/' . $post['id']) ?>">Link
    to conference</a>
  <a class="btn" style="cursor: pointer" href="<?= base_url('auth/content/video/delete/' . $post['id']) ?>">Delete
    video</a>
</div>
<h3><?= $post['title'] ?></h3>
<p>If you delete this video, all entries to this content will be lost. The SMN ScienceMedia Network will not keep any
  records connected to the content, except for backup purposes.</p>
<a class="btn btn-danger" href="<?= base_url('auth/content/video/delete/confirm/' . $post['id']) ?>">Delete Video</a>

