<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 13-May-19
 * Time: 18:18
 */

$relativeDir = base_url('/uploads/userfiles/' . $conference['userID'] . '/conferences/' . $conference['id']);

if (!empty($conference['filenameBanner_original'])) {
    $ext_ = pathinfo($conference['filenameBanner_original']);
    $ext = $ext_['extension'];
    $banner_file = $relativeDir . '/ConferenceBanner.' . $ext . '?' . time();
} else {
    $banner_file = base_url('/assets/images/img-conference.png');
}
?>
<div class="section-post-page section-manage-contribution">
  <div class="block-white tab-menu-content">
    <div class="img-conference">
      <img src="<?= $banner_file ?>" alt="image"/>
    </div>
    <div class="post-page-info">
      <div class="title">
          <?= $conference['confTitle'] ?>
      </div>
      <div class="title-form">
        Uploaded contributions
      </div>
      <p>
        This table shows all contents, which have been connected to your conference by the respective author. Before the connection is shown to the public you have to approve, that this content is really part of your conference. You can also assign a session to a content. The change of session on every content object will be updated immediately.
      </p>
      <p>
        To open a content element, please click on the title. It will be opened in a new tab / window.
      </p>
    </div>
   
    <div class="sm-table-item">
      <div class="table-filter">
        <?php if (!empty($elements)) echo $elements; ?>
      </div>
    </div>
<!--    <div class="gr-button-bototm">-->
<!--      <div class="btn-custom btn-bg green btn-save ml-auto">-->
<!--        <a>Save</a>-->
<!--      </div>-->
<!--    </div>-->
  </div>
</div>
<!-- Modal -->
<div class="modal sm-modal modal-delete" id="modalDeleteElement" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="modal-header sm-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <input type="hidden" id="elementID">
        <div class="title" id="titleModalDeleteElement">
        </div>
      </div>
      <div class="sm-modal-footer">
        <div class="gr-button d-flex">
          <div class="btn-custom btn-border green" data-dismiss="modal">
            <a>
              CANCEL
            </a>
          </div>
          <div class="btn-custom btn-bg green">
            <a class="add-spinner" id="btnSubmitDeleteElement">
              OK
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>