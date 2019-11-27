<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 07-May-19
 * Time: 10:41
 */
?>
<div class="section-post-page content-wrapper">
  <div class="top-content">
    <div class="title-section">
      Video Content
    </div>
    <div class="sm-menu-tab">
      <ul class="menu-post-detail">
        <a class="menu-view" href="<?= base_url('auth/content/video/' . $post['id']) ?>">
          Video
        </a>
        <a class="menu-edit" href="<?= base_url('auth/content/video/edit/' . $post['id']) ?>">
          Edit
        </a>
        <a class="menu-request-doi active" href="<?= base_url('auth/content/video/request-doi/' . $post['id']) ?>">
          Request DOI
        </a>
        <a class="menu-link-to-conference" href="<?= base_url('auth/content/video/link-to-conference/' . $post['id']) ?>">
          Link to conference
        </a>
      </ul>
      <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
      <button class="btn btn-popup delete-menu btn-delete-video">
        Delete Video
      </button>
    </div>
  </div>
  <div class="block-white tab-menu-content request-doi-tab-content">
    <div class="post-page-info">
      <div class="title">
        <?= $post['title'] ?>
      </div>
      <div class="extra-small-title">SMN - DOI service</div>
      <?php
      if (empty($post['doi'])) {
          echo '<p>A digital object identifier (DOI) is a character string (a "digital identifier") used to uniquely identify an object such as an electronic document. Metadata about the object is stored in association with the DOI name and this metadata may include a location, such as a URL, where the object can be found. The DOI for a document remains fixed over the lifetime of the document, whereas its location and other metadata may change. Referring to an online document by its DOI provides more stable linking than simply referring to it by its URL. (DataCite)</p>';
          echo '<a class="btn-custom btn-bg green btn-request" href="' . base_url('auth/content/request-doi/' . $post['id']) . '">Request DOI</a>';
      } else {
          echo '<p>Your DOI was registered successfully.</p>';
          echo '<p>The DOI of this document is: <b>' . $post['doi'] . '</b></p>';
      }
      ?>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete video
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title">
            <?= $post['title'] ?>
        </div>
        <div class="modal-description">
        </div>
      </div>
      <div class="sm-modal-footer d-none">
        <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
        <button class="btn-custom btn-bg green btn-delete btn-delete-video-confirm" data-dismiss="modal">Delete video</button>
      </div>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deleteStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete video
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="modal-description">
        </div>
      </div>
    </div>
  </div>
</div>

