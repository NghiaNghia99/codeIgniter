<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 03-May-19
 * Time: 15:21
 */
?>
<div class="section-object-list layout-list-sort">
  <div class="section-object-list-title">Share videos</div>
  <div class="section-object-list-content results">
    <nav>
      <div class="nav nav-tabs" id="nav-tab-video-list">
        <a class="nav-item nav-link tab-item" id="nav-video-list-tab" href="<?= base_url('auth/content/videos') ?>">Video list</a>
        <a class="nav-item nav-link tab-item active" id="nav-upload-queue-tab" href="<?= base_url('auth/content/videos/queue') ?>">Upload queue</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabVideoList">
      <div class="tab-pane fade show active" id="nav-upload-queue">
        <div class="sm-table-item">
          <?php if (!empty($posts)): ?>
          <table class="table table-custom table-upload-queue">
            <thead>
              <tr>
                <th>Title</th>
                <th>Date of upload</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($posts['results'] as $queue): ?>
              <tr>
                <td>
                  <?= $queue->title ?>
                </td>
                <td>
                  <?= date('d.m.Y', $queue->dateOfUpload) ?>
                </td>
                <td>
                  <?php if ($queue->status == 0): ?>
                  <button class="btn btn-custom btn-bg btn-uploaded label">Uploaded</button>
                  <?php elseif ($queue->status == 1): ?>
                  <button class="btn btn-custom btn-bg btn-converted label">Converted</button>
                  <?php else: ?>
                    <button class="btn btn-custom btn-bg btn-failed label">Failed</button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach;?>
            </tbody>
          </table>
          <div class="menu-pagination">
              <?= $posts['links'] ?>
          </div>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
