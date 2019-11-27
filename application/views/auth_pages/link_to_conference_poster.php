<div class="section-post-page content-wrapper">
	<div class="top-content">
    <div class="title-section">
      Poster content
    </div>
    <div class="sm-menu-tab">
      <ul class="menu-post-detail">
        <a class="menu-view" href="<?= base_url('auth/content/poster/' . $post['id']) ?>">
          Poster
        </a>
        <a class="menu-edit" href="<?= base_url('auth/content/poster/edit/' . $post['id']) ?>">
          Edit
        </a>
        <a class="menu-request-doi" href="<?= base_url('auth/content/poster/request-doi/' . $post['id']) ?>">
          Request DOI
        </a>
        <a class="menu-link-to-conference active" href="<?= base_url('auth/content/poster/link-to-conference/' . $post['id']) ?>">
          Link to conference
        </a>
      </ul>
      <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
      <button class="btn btn-popup delete-menu btn-delete-poster">
        Delete Poster
      </button>
    </div>
  </div>
  <div class="block-white tab-menu-content link-to-conference-tab-content">
    <div class="post-page-info">
      <div class="title">
          <?= $post['posterTitle'] ?>
      </div>
      <div>
        <div class="form-item">
          <input type="hidden" name="postID" id="postID" value="<?= $post['id'] ?>">
          <input type="hidden" name="postType" id="postType" value="<?= $_SESSION['post_type_link_to_conference'] ?>">
          <label class="form-label label-custom">Please enter the CID of the conference, you want to add
            this <?= $_SESSION['post_type_link_to_conference'] ?>
            to<span class="req">*</span>
          </label>
          <input type="hidden" id="get_all_cid" value="<?= implode('|,|', $cid); ?>">
          <input type="text" class="input input-custom get-all-cid" id="get_cid" data-provide="typeahead" name="cid"
                 placeholder="CID" autocomplete="off" value="<?php echo set_value('cid') ?>">
          <div class="error"><?php echo form_error('cid') ?></div>
        </div>
        <div class="form-item session-link-to-conference d-none">
          <label class="form-label label-custom">Now please choose the session<span
              class="req">*</span>
          </label>
          <select id="get_session_cid" name="session" class="input-custom select-custom-choose-session">
          </select>
        </div>
        <div class="share-public-option session-link-to-conference d-none">
          <div class="form-item check-terms-item fs-14 checkbox-custom">
            <input id="sharePublic" type="radio" class="input" name="sharePublic" checked>
            <label></label>
            <div class="check-terms-item-text">Share Public</div>
          </div>
          <div class="form-item check-terms-item fs-14 checkbox-custom">
            <input id="closeAccess" type="radio" class="input" name="sharePublic">
            <label></label>
            <div class="check-terms-item-text">Restricted Access</div>
          </div>
        </div>
        <div class="note-share-public session-link-to-conference d-none">
          In case the conference has only restricted access, if you do not choose "Share public" option, the content object will only be visible to conference participants. Therefore, we want to encourage to allow for "Share public".
        </div>
        <button class="btn-custom btn-bg green btn-next" id="btn_next_link_to_conference">Next</button>
        <button class="add-spinner btn-custom btn-bg green btn-next d-none" id="btn_add_link_to_conference">Add</button>
      </div>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete poster
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title">
            <?= $post['posterTitle'] ?>
        </div>
        <div class="modal-description">
        </div>
      </div>
      <div class="sm-modal-footer d-none">
        <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
        <button class="btn-custom btn-bg green btn-delete btn-delete-poster-confirm" data-dismiss="modal">Delete poster</button>
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
          Delete poster
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