<div class="section-project section-project-document section-project-document-add">
  <div class="project-layout-list-sort">
    <div class="d-flex">
      <div class="p-2 mr-auto">
        <a class="layout-list-status">New document</a>
      </div>
    </div>
  </div>
  <hr>
  <div class="project-layout-content project-layout-add-document">
    <form class="form-submit-document" method="post" enctype="multipart/form-data">
      <div class="form-item">
        <label class="form-label label-custom">
          Category
        </label>
        <input type="text" class="input-custom" value="Documentation" disabled>
      </div> <!-- form-item -->
      <div class="form-item">
        <label class="form-label label-custom">
          Title
          <span class="req">*</span>
        </label>
        <input class="input-custom input-document-title" name="title" value="<?php echo set_value('title') ?>">
        <div class="error"><?php echo form_error('title') ?></div>
      </div> <!-- form-item -->
      <div class="form-item">
        <label class="form-label label-custom">
          Description
        </label>
        <textarea name="description_document"></textarea>
      </div>
      <div class="form-item form-item-attachment">
        <label class="form-label label-custom">
          File
        </label>
        <input type="hidden" class="usernameLogin" value="<?= $username ?>">
        <div class="block-file block-file-list">
<!--            <div class="block-file-info d-flex align-items-center justify-content-start">-->
<!--              <div class="block-file-info-name">-->
<!--                  <div class="name-item">-->
<!--                    JJM App Architetture.pdf-->
<!--                  </div>-->
<!--                  <button type="button" class="close icon-cancel"></button>-->
<!--              </div>-->
<!--              <div class="block-file-info-author-time-publishing">-->
<!--                <span>Trang Bui</span> <span>a few seconds ago</span>-->
<!--              </div>-->
<!--            </div>-->
        </div>
      </div>
      <div class="form-item block-file-upload">
        <div class="file-upload-content upload-area">
          <div class="btn-custom btn-border btn-gray btn-upload-file">
            <label for="input_upload_attachment">Choose File</label>
            <input type="file" name="file" id="input_upload_attachment">
          </div>
          <p class="last-text upload-area-text">
            Drop your file here.
          </p>
        </div>
      </div>
      <div class="btn-toolbar">
        <div class="btn-group mr-2">
          <button type="button" class="btn-custom no-child btn-bg green btn-create btn-submit-document">
            Create
          </button>
        </div>
        <div class="btn-group">
          <div class="btn-custom btn-bg gray btn-cancel">
            <a href="<?= base_url('auth/project/'. $identifier .'/documents') ?>">Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>