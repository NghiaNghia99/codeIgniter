<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 15-May-19
 * Time: 17:02
 */

$relativeDir = base_url('/uploads/userfiles/' . $conference['userID'] . '/conferences/' . $conference['id']);

if (!empty($conference['filenameBanner_original'])) {
    $ext_ = pathinfo($conference['filenameBanner_original']);
    $ext = $ext_['extension'];
    $banner_file = $relativeDir . '/ConferenceBanner.' . $ext  . '?' . time();
} else {
    $banner_file = base_url('/assets/images/img-conference.png');
}
if (!empty($conference['filenamePoster_original'])) {
    $poster_file = $relativeDir . '/ConferencePoster.pdf';
}
if (!empty($conference['filenameProgramme_original'])) {
    $programme_file = $relativeDir . '/ConferenceProgramme.pdf';
}
if (!empty($conference['filenameAbstractBook_original'])) {
    $abstractBook_file = $relativeDir . '/ConferenceAbstractBook.pdf';
}
if (!empty($conference['filenameConfPhoto_original'])) {
    $ext_ = pathinfo($conference['filenameConfPhoto_original']);
    $ext = $ext_['extension'];
    $conferencePhoto_file = $relativeDir . '/ConferencePictureParticipants.' . $ext. '?' . time();
}else {
    $conferencePhoto_file = base_url('/assets/images/img-image.png');
}

?>
<div class="section-edit-conference">
  <div class="top-content">
    <div class="sm-menu-tab">
      <ul class="menu-edit-detail">
        <a class="basic-menu" href="<?= base_url('auth/conference/managed/conference-edit/basic-information/' . $conference['id']) ?>">
          Basic information
        </a>
        <a class="optional-menu" href="<?= base_url('auth/conference/managed/conference-edit/optional-information/' . $conference['id']) ?>">
          Optional information
        </a>
        <a class="file-upload-menu active">
          File upload
        </a>
      </ul>
    </div>
  </div>
  <div class="block-white tab-menu-content edit-info-tab-content file-upload-tab-content">
    <input type="hidden" id="get_id_conference" value="<?= $conference['id'] ?>">
    <input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">
    <div class="img-conference">
      <img src="<?= $banner_file ?>" alt="image"/>
    </div>
    <div class="title">
        <?= $conference['confTitle'] ?>
    </div>
    <div class="title-form">
      Edit important conference/workshop information
    </div>
    <div class="list-module-upload edit-info-container">
      <form class="upload-module form-upload-file">
        <div class="img-item-upload img-item">
          <img src="<?= $banner_file ?>" alt="">
        </div>
        <div class="content-item-upload">
          <div class="title small-title">
            Conference banner
              <?php if (!empty($conference['filenameBanner_original'])) : ?>
                <span class="brand status uploaded">
              Uploaded
            </span>
              <?php else : ?>
                <span class="brand status unuploaded">
              Unuploaded
            </span>
              <?php endif; ?>
          </div>
          <p>
            Please upload a representive banner of your conference. If possible the width is optimized to 800px (height
            can be arbitrary. Suggestion: 200px). Supported file formats are jpeg, png, and gif.
          </p>
            <?php if (!empty($conference['filenameBanner_original'])) : ?>
              <p class="mt-3">File name: <span class="limitTextFileName d-none"><?= $conference['filenameBanner_original'] ?></span></p>
            <?php endif; ?>
          <div class="file-upload-content upload-area">
            <div class="btn-custom btn-border btn-gray btn-upload-file">
              <label for="filenameBanner_original">Choose File</label>
              <input type="file" id="filenameBanner_original" name="filenameBanner_original" class="edit-conference-upload-file"/>
            </div>
            <div class="detail-item-upload d-flex">
              <div class="form-item input-group upload-info d-none">
                <input type="text" class="input input-custom file-name" disabled/>
                <div class="input-group-append">
                  <span class="icon-cancel input-group-text btn-remove-upload"></span>
                </div>
                <div class="error"></div>
              </div>
              <input class="btn-custom btn-bg green btn-upload d-none btn-submit-upload-file" type="submit"
                     value="Upload"/>
            </div>
          </div>
        </div>
      </form>
      <form class="upload-module form-upload-file">
        <div class="img-item-upload">
          <img src="<?= base_url('/assets/images/img-pdf.png') ?>" alt="">
        </div>
        <div class="content-item-upload">
          <div class="title small-title">
            Conference poster
              <?php if (!empty($conference['filenamePoster_original'])) : ?>
                <span class="brand status uploaded">
              Uploaded
            </span>
              <?php else : ?>
                <span class="brand status unuploaded">
              Unuploaded
            </span>
              <?php endif; ?>
          </div>
          <p>
            Please upload your conference poster in pdf file format. The thumbnail for your conference will be created
            from this file.
          </p>
            <?php if (!empty($conference['filenamePoster_original'])) : ?>
              <p class="mt-3">File name: <span class="limitTextFileNam"><?= $conference['filenamePoster_original'] ?></span></p>
            <?php endif; ?>
          <div class="file-upload-content upload-area">
            <div class="btn-custom btn-border btn-gray btn-upload-file">
              <label for="filenamePoster_original">Choose File</label>
              <input type="file" id="filenamePoster_original" name="filenamePoster_original" class="edit-conference-upload-file"/>
            </div>
            <div class="detail-item-upload d-flex">
              <div class="form-item input-group upload-info d-none">
                <input type="text" class="input input-custom file-name" disabled/>
                <div class="input-group-append">
                  <span class="icon-cancel input-group-text btn-remove-upload"></span>
                </div>
                <div class="error"></div>
              </div>
              <input class="btn-custom btn-bg green btn-upload d-none btn-submit-upload-file" type="submit"
                     value="Upload"/>
            </div>
          </div>
        </div>
      </form>
      <form class="upload-module form-upload-file">
        <div class="img-item-upload">
          <img src="<?= base_url('/assets/images/img-pdf.png') ?>" alt="">
        </div>
        <div class="content-item-upload">
          <div class="title small-title">
            Conference programme
              <?php if (!empty($conference['filenameProgramme_original'])) : ?>
                <span class="brand status uploaded">
              Uploaded
            </span>
              <?php else : ?>
                <span class="brand status unuploaded">
              Unuploaded
            </span>
              <?php endif; ?>
          </div>
          <p>
            If you have your conference programme in pdf file format, you can upload it here. The programme will then be
            available for download.
          </p>
            <?php if (!empty($conference['filenameProgramme_original'])) : ?>
              <p class="mt-3">File name: <span class="limitTextFileName"><?= $conference['filenameProgramme_original'] ?></span></p>
            <?php endif; ?>
          <div class="file-upload-content upload-area">
            <div class="btn-custom btn-border btn-gray btn-upload-file">
              <label for="filenameProgramme_original">Choose File</label>
              <input type="file" id="filenameProgramme_original" name="filenameProgramme_original" class="edit-conference-upload-file"/>
            </div>
            <div class="detail-item-upload d-flex">
              <div class="form-item input-group upload-info d-none">
                <input type="text" class="input input-custom file-name" disabled/>
                <div class="input-group-append">
                  <span class="icon-cancel input-group-text btn-remove-upload"></span>
                </div>
                <div class="error"></div>
              </div>
              <input class="btn-custom btn-bg green btn-upload d-none btn-submit-upload-file" type="submit"
                     value="Upload"/>
            </div>
          </div>
        </div>
      </form>
      <form class="upload-module form-upload-file">
        <div class="img-item-upload">
          <img src="<?= base_url('/assets/images/img-pdf.png') ?>" alt="">
        </div>
        <div class="content-item-upload">
          <div class="title small-title">
            Conference abstract book
              <?php if (!empty($conference['filenameAbstractBook_original'])) : ?>
                <span class="brand status uploaded">
              Uploaded
            </span>
              <?php else : ?>
                <span class="brand status unuploaded">
              Unuploaded
            </span>
              <?php endif; ?>
          </div>
          <p>
            Please upload you conference abstract book in pdf file format. It will then be available for download.
          </p>
            <?php if (!empty($conference['filenameAbstractBook_original'])) : ?>
              <p class="mt-3">File name: <span class="limitTextFileName"><?= $conference['filenameAbstractBook_original'] ?></span></p>
            <?php endif; ?>
          <div class="file-upload-content upload-area">
            <div class="btn-custom btn-border btn-gray btn-upload-file">
              <label for="filenameAbstractBook_original">Choose File</label>
              <input type="file" id="filenameAbstractBook_original" name="filenameAbstractBook_original" class="edit-conference-upload-file"/>
            </div>
            <div class="detail-item-upload d-flex">
              <div class="form-item input-group upload-info d-none">
                <input type="text" class="input input-custom file-name" disabled/>
                <div class="input-group-append">
                  <span class="icon-cancel input-group-text btn-remove-upload"></span>
                </div>
                <div class="error"></div>
              </div>
              <input class="btn-custom btn-bg green btn-upload d-none btn-submit-upload-file" type="submit"
                     value="Upload"/>
            </div>
          </div>
        </div>
      </form>
      <form class="upload-module form-upload-file">
        <div class="img-item-upload img-item">
          <img src="<?= $conferencePhoto_file ?>" alt="">
        </div>
        <div class="content-item-upload">
          <div class="title small-title">
            Conference photo
              <?php if (!empty($conference['filenameConfPhoto_original'])) : ?>
                <span class="brand status uploaded">
              Uploaded
            </span>
              <?php else : ?>
                <span class="brand status unuploaded">
              Unuploaded
            </span>
              <?php endif; ?>
          </div>
          <p>
            Upload your conference photo either in png or jpeg file format.
          </p>
            <?php if (!empty($conference['filenameConfPhoto_original'])) : ?>
              <p class="mt-3">File name: <span class="limitTextFileName"><?= $conference['filenameConfPhoto_original'] ?></span></p>
            <?php endif; ?>
          <div class="file-upload-content upload-area">
            <div class="btn-custom btn-border btn-gray btn-upload-file">
              <label for="filenameConfPhoto_original">Choose File</label>
              <input type="file" id="filenameConfPhoto_original" name="filenameConfPhoto_original" class="edit-conference-upload-file"/>
            </div>
            <div class="detail-item-upload d-flex">
              <div class="form-item input-group upload-info d-none">
                <input type="text" class="input input-custom file-name" disabled/>
                <div class="input-group-append">
                  <span class="icon-cancel input-group-text btn-remove-upload"></span>
                </div>
                <div class="error"></div>
              </div>
              <input class="btn-custom btn-bg green btn-upload d-none btn-submit-upload-file" type="submit"
                     value="Upload"/>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
