<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 14-May-19
 * Time: 16:50
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
<div class="section-edit-conference">
  <div class="top-content">
    <div class="sm-menu-tab">
      <ul class="menu-edit-detail">
        <a class="basic-menu" href="<?= base_url('auth/conference/managed/conference-edit/basic-information/' . $conference['id']) ?>">
          Basic information
        </a>
        <a class="optional-menu active">
          Optional information
        </a>
        <a class="file-upload-menu" href="<?= base_url('auth/conference/managed/conference-edit/file-upload/' . $conference['id']) ?>">
          File upload
        </a>
      </ul>
    </div>
  </div>
  <div class="block-white tab-menu-content edit-info-tab-content optional-tab-content">
    <input type="hidden" id="get_id_conference" value="<?= $conference['id'] ?>">
    <input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">
    <div class="img-conference">
      <img src="<?= $banner_file ?>" alt="image" />
    </div>
    <div class="title">
        <?= $conference['confTitle'] ?>
    </div>
    <div class="title-form">
      Edit important conference/workshop information
    </div>
    <form class="edit-info-container">
      <div class="form-item">
        <label class="form-label label-custom">Conference programme</label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editProgramme" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-programme"
               aria-expanded="true" aria-controls="collapse-programme">
              <?php if (!empty($conference['programme'])) {
                  echo $conference['programme'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-programme" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="programme" class="textarea-custom">
                  <?php echo set_value('programme', $conference['programme']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="programme" data-object="programme"
                 data-button="editProgramme"
                 data-placeholder="Conference programme">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Local organizing committee (LOC)
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editLOC" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-LOC"
               aria-expanded="true" aria-controls="collapse-LOC">
              <?php if (!empty($conference['LOC'])) {
                  echo $conference['LOC'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-LOC" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="LOC" class="textarea-custom">
                  <?php echo set_value('LOC', $conference['LOC']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="LOC" data-object="LOC"
                 data-button="editLOC"
                 data-placeholder="Local organizing committee (LOC)">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Scientific organizing committee (SOC)
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editSOC" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-SOC"
               aria-expanded="true" aria-controls="collapse-SOC">
              <?php if (!empty($conference['SOC'])) {
                  echo $conference['SOC'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-SOC" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="SOC" class="textarea-custom">
                  <?php echo set_value('SOC', $conference['SOC']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="SOC" data-object="SOC"
                 data-button="editSOC"
                 data-placeholder="Scientific organizing committee (SOC)">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Invited speakers
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editKeynoteSpeakers" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-keynoteSpeakers"
               aria-expanded="true" aria-controls="collapse-keynoteSpeakers">
              <?php if (!empty($conference['keynoteSpeakers'])) {
                  echo $conference['keynoteSpeakers'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-keynoteSpeakers" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="keynoteSpeakers" class="textarea-custom">
                  <?php echo set_value('keynoteSpeakers', $conference['keynoteSpeakers']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="keynoteSpeakers" data-object="keynoteSpeakers"
                 data-button="editKeynoteSpeakers"
                 data-placeholder="Invited speakers">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Venue
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editVenue" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-venue"
               aria-expanded="true" aria-controls="collapse-venue">
              <?php if (!empty($conference['venue'])) {
                  echo $conference['venue'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-venue" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="venue" class="textarea-custom">
                  <?php echo set_value('venue', $conference['venue']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="venue" data-object="venue"
                 data-button="editVenue"
                 data-placeholder="Venue">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Important dates
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editImportantDates" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-importantDates"
               aria-expanded="true" aria-controls="collapse-importantDates">
              <?php if (!empty($conference['importantDates'])) {
                  echo $conference['importantDates'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-importantDates" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="importantDates" class="textarea-custom">
                  <?php echo set_value('importantDates', $conference['importantDates']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="importantDates" data-object="importantDates"
                 data-button="editImportantDates"
                 data-placeholder="Important dates">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Registration and payment information
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editRegistrationPayment" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-registrationPayment"
               aria-expanded="true" aria-controls="collapse-registrationPayment">
              <?php if (!empty($conference['registrationPayment'])) {
                  echo $conference['registrationPayment'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-registrationPayment" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="registrationPayment" class="textarea-custom">
                  <?php echo set_value('registrationPayment', $conference['registrationPayment']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="registrationPayment" data-object="registrationPayment"
                 data-button="editRegistrationPayment"
                 data-placeholder="Registration and payment information">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Hotel information
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editHotelInfos" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-hotelInfos"
               aria-expanded="true" aria-controls="collapse-hotelInfos">
              <?php if (!empty($conference['hotelInfos'])) {
                  echo $conference['hotelInfos'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-hotelInfos" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="hotelInfos" class="textarea-custom">
                  <?php echo set_value('hotelInfos', $conference['hotelInfos']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="hotelInfos" data-object="hotelInfos"
                 data-button="editHotelInfos"
                 data-placeholder="Hotel information">Save</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Travel information
        </label>
        <div class="accordion accordion-conference editor-collapse">
          <div id="editTravelInformation" class="btn btn-accordion"
               data-toggle="collapse"
               data-target="#collapse-travelInformation"
               aria-expanded="true" aria-controls="collapse-travelInformation">
              <?php if (!empty($conference['travelInformation'])) {
                  echo $conference['travelInformation'];
              } else {
                  echo 'Empty';
              } ?>
          </div>
          <div id="collapse-travelInformation" class="collapse session-accordion-content">
            <div class="error text-left mb-2"></div>
            <textarea id="travelInformation" class="textarea-custom">
                  <?php echo set_value('travelInformation', $conference['travelInformation']) ?>
                </textarea>
            <div class="btn-custom btn-bg green btn-save-edit">
              <a class="btn-save-content" data-name="travelInformation" data-object="travelInformation"
                 data-button="editTravelInformation"
                 data-placeholder="Travel information">Save</a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>