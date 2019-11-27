<div class="section-project section-project-document section-project-document-detail">
  <div class="project-layout-list-sort">
    <div class="prev-page">
      <span class="icon icon-arrow-down"></span><?= $title ?>
    </div>
  </div>
  <hr>
  <div class="project-layout-documents-detail">
    <div class="block-document-detail">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12 col-md-10 order-2 order-md-1">
            <div class="document-detail-title">
              <!--                Documentation - 06/26/2019-->
                <?php
                $date = date_create($createdAt);
                echo date_format($date, "m/d/Y"); ?>
            </div>
            <div class="document-detail-description">
                <?= $description ?>
            </div>
            <br>
          </div>
          <div class="col-12 col-md-2 order-1 order-md-2 text-right">
            <div class="btn-list-sort">
              <a class="btn btn-custom btn-bg btn-icon btn-edit"
                 href="<?= base_url('auth/project/' . $identifier . '/document-edit/' . $documentID) ?>"><span
                  class="icon-edit"></span></a>
            </div>
            <div class="btn-list-sort">
              <a class="btn btn-custom btn-bg btn-icon btn-delete btn-delete-document" data-identifier="<?= $identifier ?>" data-id="<?= $documentID ?>"><span class="icon-delete"></span></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-item">
              <label class="form-label label-custom">
                File
              </label>
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
            </div>
          </div>
        </div>
      </div> <!-- block-document-detail -->
    </div>
  </div>
</div>
<div class="modal sm-modal modal-delete" id="modalDeleteDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="modal-header sm-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <input type="hidden" id="documentID">
        <input type="hidden" id="identifier">
        <div class="title">Do you want to delete this document?</div>
      </div>
      <div class="sm-modal-footer">
        <div class="gr-button d-flex">
          <div class="btn-custom btn-border green" data-dismiss="modal">
            <a>
              CANCEL
            </a>
          </div>
          <div class="btn-custom btn-bg green">
            <a class="add-spinner" id="btnSubmitDeleteDocument">
              OK
            </a>
          </div>
        </div>
      </div>
    </div>
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