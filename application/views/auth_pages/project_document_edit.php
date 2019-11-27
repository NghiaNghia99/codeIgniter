<div class="section-project section-project-document section-project-document-edit layout-list-sort">
  <div class="project-layout-list-sort">
    <div class="prev-page">
      <span class="icon icon-arrow-down"></span><?= $title ?>
    </div>
  </div>
  <hr>
  <div class="project-layout-content project-layout-document-edit">
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
        <input class="input-custom input-document-title" name="title" value="<?php echo set_value('title', $title) ?>">
        <div class="error"><?php echo form_error('title') ?></div>
      </div> <!-- form-item -->
      <div class="form-item">
        <label class="form-label label-custom">
          Description
        </label>
        <textarea name="description_document">
            <?php echo set_value('description_document', $description) ?>
          </textarea>
      </div>
      <div class="form-item form-item-attachment">
        <label class="form-label label-custom">
          File
        </label>
        <input type="hidden" class="usernameLogin" value="<?= $username ?>">
        <div class="block-file">
            <?php if (!empty($attachmentList)): foreach ($attachmentList as $key => $attachment): ?>
              <div class="block-file-info d-flex align-items-center justify-content-start">
                <div class="block-file-info-name">
                  <div class="name-item">
                    <a href="<?= base_url('auth/project/attachment/' . $attachment['id']) ?>" target="_blank"><?= $attachment['fileName'] ?></a>
                  </div>
                  <button type="button" class="close icon-cancel btn-delete-attachment" data-id="<?= $attachment['id'] ?>"></button>
                </div>
                <div class="block-file-info-author-time-publishing">
                  <span><?= $attachment['author'] ?></span>
                  <span title="<?php
                  $date = date_create($attachment['createdAt']);
                  echo date_format($date, "F j, h:i A"); ?>"><?= $attachment['countTime'] ?>
                          </span>
                </div>
              </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="block-file block-file-list"></div>
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
            Update
          </button>
        </div>
        <div class="btn-group">
          <div class="btn-custom btn-bg gray btn-cancel">
            <a href="<?= base_url('auth/project/'. $identifier .'/document-detail/' . $documentID) ?>">Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="modal sm-modal modal-delete" id="modalDeleteAttachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="modal-header sm-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <input type="hidden" id="attachmentID">
        <div class="title">Do you want to delete this attachment?</div>
      </div>
      <div class="sm-modal-footer">
        <div class="gr-button d-flex">
          <div class="btn-custom btn-border green" data-dismiss="modal">
            <a>
              CANCEL
            </a>
          </div>
          <div class="btn-custom btn-bg green">
            <a class="add-spinner" id="btnSubmitDeleteAttachment">
              OK
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>