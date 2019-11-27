<?php
$relativeDir = base_url('/uploads/userfiles/' . $conference['userID'] . '/conferences/' . $conference['id']);

if (!empty($conference['filenameBanner_original'])) {
    $ext_ = pathinfo($conference['filenameBanner_original']);
    $ext = $ext_['extension'];
    $banner_file = $relativeDir . '/ConferenceBanner.' . $ext . '?' . time();
} else {
    $banner_file = base_url('/assets/images/img-conference.png');
}
?>
<div class="section-detail-conference">
  <div class="block-white">
    <div class="block-conference-content">
      <ul class="nav nav-tabs conference-tab-menu top-menu registration-menu" role="tablist">
        <li class="nav-item">
          <a class="nav-link <?php if (!$this->session->tempdata('abstract_tool_tab')) echo 'active'; ?>" id="abstract-tab" data-toggle="tab" href="#abstract" role="tab"
             aria-controls="abstract" aria-selected="true">Abstract list</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($this->session->tempdata('abstract_tool_tab')) echo 'active'; ?>" id="registration-tool-tab" data-toggle="tab" href="#registration-tool" role="tab"
             aria-controls="registration-tool" aria-selected="true">Abstract tool</a>
        </li>
      </ul>
      <div class="tab-content conference-tab-content registration-conference-tab-content" id="myTabContent">
        <div class="tab-pane conference-tab-pane abstract-tab-content  <?php if (!$this->session->tempdata('abstract_tool_tab')) echo 'active'; ?>" id="abstract" role="tabpanel"
             aria-labelledby="abstract-tab">
          <input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">
          <div class="img-conference">
            <img src="<?= $banner_file ?>">
          </div>
          <div class="tab-content-detail">
            <div class="title">
              <?= $conference['confTitle'] ?>
            </div>
            <div class="sub-title">
              Submitted abstracts
            </div>
            <p>
              Click on name to get more details about abstract.
            </p>
            <div class="sm-table-item">
              <div class="table-filter">
                  <?php if (!empty($abstractList)) echo $abstractList; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane conference-tab-pane registration-tool-tab-content <?php if ($this->session->tempdata('abstract_tool_tab')) echo 'active'; ?>" id="registration-tool" role="tabpanel"
             aria-labelledby="registration-tool-tab">
          <div class="img-conference">
            <img src="<?= $banner_file ?>">
          </div>
          <div class="tab-content-detail">
            <div class="title">
              <?= $conference['confTitle'] ?>
            </div>
            <div class="sub-title">
              Setup conference/workshop abstract submission tool
            </div>
            <?php
            $now = time();
            if (!empty($abstractTool->abstractSubmissionStart) && !empty($abstractTool->abstractSubmissionEnd)) :
                if ((int)$abstractTool->abstractSubmissionStart < $now && $now < (int)$abstractTool->abstractSubmissionEnd) :
                    ?>
                  <div class="block-status abstract-submit opening">
                    <div class="title small-title">
                      Abstract submission status
                    </div>
                    <div class="gr-icon-text">
                      <span class="icon-calendar"></span>
                        <?= date('d.m.Y', $abstractTool->abstractSubmissionStart) ?> - <?= date('d.m.Y',
                          $abstractTool->abstractSubmissionEnd) ?>
                    </div>
                    <div class="brand status opening">
                      Opening
                    </div>
                  </div>
                <?php else: ?>
                  <div class="block-status abstract-submit closed">
                    <div class="title small-title">
                      Abstract submission status
                    </div>
                    <div class="gr-icon-text">
                      <span class="icon-calendar"></span>
                        <?= date('d.m.Y', $abstractTool->abstractSubmissionStart) ?> - <?= date('d.m.Y',
                          $abstractTool->abstractSubmissionEnd) ?>
                    </div>
                    <div class="brand status closed">
                      Closed
                    </div>
                  </div>
                <?php endif; else: ?>
              <div class="block-status abstract-submit">
                <div class="title small-title">
                  Abstract submission status
                </div>
                <div class="gr-icon-text">You have not set up an abstract submission form, yet</div>
              </div>
            <?php endif; ?>
            <div class="list-registration-item">
              <div class="row">
                <div class="col-md-6">
                  <div class="registration-item abstract-item">
                    <div class="title small-title">
                      Setup abstract submission form
                    </div>
                    <p>
                      If you wish to use our conference/workshop abstract submission tool, please set up the mandatory
                      information here. You may provide basic information at the top of the abstract submission form.
                    </p>
                    <p>
                      Also, you can get the dates when the registration period starts and ends.
                    </p>
                    <p>
                      At the moment we can only accept abstracts in text.
                    </p>
                    <div class="btn-custom btn-border green" data-toggle="modal" data-target="#setup-abstract">
                      <a>
                        Setup
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="registration-item abstract-item">
                    <div class="title small-title">
                      Abstract submission form
                    </div>
                    <p>
                      Check your registration form here.
                    </p>
                    <div class="btn-custom btn-border green" data-toggle="modal" data-target="#registration-form">
                      <a>
                        Check
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal setup-->
<div class="modal sm-modal setup-registration-modal" id="setup-abstract" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title">
          Setup abstract submission for CID: <?= $conference['CID'] ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title small-title">
          Headline notes for the abstract submission:
        </div>
        <div class="form-item">
          <label class="label-custom">
            Notes appearing at the top of the abstract submission form
            <span class="req">*</span>
          </label>
          <textarea  name="abstractSubmissionText" id="abstractSubmissionText" class="textarea-custom"><?php if (!empty($abstractTool->abstractSubmissionText)) echo $abstractTool->abstractSubmissionText ?></textarea>
          <div class="error"></div>
        </div>
        <div class="title small-title">
          Set up the time frame for the abstract submission period:
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-item input-group datetime-picker">
              <label class="label-custom">
                Start of abstract submission period:
                <span class="req">*</span>
              </label>
              <input class="input-custom input-medium datepicker"
                     placeholder="Start of abstract period" data-date-format="dd.mm.yyyy" readonly id="startDate"
                     value="<?php if (!empty($abstractTool->abstractSubmissionStart)) echo date('d.m.Y',
                       $abstractTool->abstractSubmissionStart) ?>">
              <div class="error"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item input-group datetime-picker">
              <label class="label-custom">
                Deadline for abstract submission:
                <span class="req">*</span>
              </label>
              <input class="input-custom input-medium datepicker"
                     placeholder="Deadline for abstract" data-date-format="dd.mm.yyyy" readonly id="endDate"
                     value="<?php if (!empty($abstractTool->abstractSubmissionEnd)) echo date('d.m.Y',
                       $abstractTool->abstractSubmissionEnd) ?>">
              <div class="error"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="sm-modal-footer">
        <div class="btn-custom btn-bg dark-green btn-close" data-dismiss="modal">
        <a>Close</a>
        </div>
        <div class="btn-custom btn-bg green btn-close">
          <a id="btn_submit_abstract_tool">Save</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Abstract form -->
<div class="modal sm-modal abstract-form-modal" id="registration-form" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Abstract submission for CID: <?= $conference['confTitle'] ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="form-item">
          <label class="label-custom">
            Please select, If you submit a talk or a poster
            <span class="req">*</span>
          </label>
          <div class="gr-checkbox-inline d-flex">
            <div class="form-item check-terms-item checkbox-register">
              <input type="radio" class="input" name="check_terms" value="1">
              <label></label>
              <div class="check-terms-item-text">Talk</div>
              <div class="error"></div>
            </div>
            <div class="form-item check-terms-item checkbox-register">
              <input type="radio" class="input" name="check_terms" value="1">
              <label></label>
              <div class="check-terms-item-text">Poster</div>
              <div class="error"></div>
            </div>
          </div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Title
            <span class="req">*</span>
          </label>
          <input type="text" class="input-custom" placeholder="Abstract title"/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Author

          </label>
          <input type="text" class="input-custom" readonly/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Co Author

          </label>
          <input type="text" class="input-custom" placeholder="Co Author"/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Affiliations

          </label>
          <input type="text" class="input-custom" placeholder="Affiliations"/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            State
          </label>
          <input type="text" class="input-custom" placeholder="State"/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Abstract text
            <span class="req">*</span>
          </label>
          <textarea class="input-custom textarea-custom" placeholder="Abstract text"></textarea>
          <div class="text-after">
            You mau use TeX commands!
          </div>
          <div class="error"></div>
        </div>
        <div class="btn-custom btn-bg dark-green mobile-item" data-dismiss="modal" aria-label="Close">Close</div>
      </div>
    </div>
  </div>
</div>
<!-- Modal information -->
<div class="modal sm-modal information-modal" id="abstract-information-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
</div>

<!-- Modal enter reason of reject conference-->
<div class="modal sm-modal modal-reject" id="reject_abstract" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title">
          Rejection
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title">
          Please provide why you are rejecting the abstract
        </div>
        <input type="hidden" id="get_id_abstract">
        <div class="form-item">
          <label class="label-custom">
            Detail
            <span class="req">*</span>
          </label>
          <textarea name="reasonRejectAbstract" id="reasonRejectAbstract" class="textarea-custom"></textarea>
          <div class="error"></div>
        </div>
      </div>
      <div class="sm-modal-footer">
        <div class="btn-custom btn-bg green">
          <a id="btn_submit_reject_abstract">Submit</a>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal sm-modal modal-reject" id="edit_abstract" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title">
          Edit Abstract
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <input type="hidden" id="id_abstract">
        <div class="form-item form-item-edit-abstract">
          <label class="form-label label-custom">First name</label>
          <input type="text" class="input input-custom" id="first_name_abstract" value="" disabled>
        </div>
        <div class="form-item form-item-edit-abstract">
          <label class="form-label label-custom">Last name</label>
          <input type="text" class="input input-custom" id="last_name_abstract" value="" disabled>
        </div>
        <div class="form-item form-item-edit-abstract">
          <label class="form-label label-custom">Title</label>
          <input type="text" class="input input-custom" id="title_abstract" value="" disabled>
        </div>
        <div class="form-item form-item-edit-abstract">
          <label class="form-label label-custom">Type</label>
          <select class="input-custom select-custom-none-search select-type-abstract" id="type_abstract">
            <option value="poster" id="type_poster_abstract">Poster</option>
            <option value="talk" id="type_talk_abstract">Talk</option>
          </select>
        </div>
      </div>
      <div class="sm-modal-footer sm-modal-footer-edit-abstract">
        <div class="btn-custom btn-bg green">
          <a class="add-spinner" id="btn_submit_edit_abstract">Submit</a>
        </div>
      </div>
    </div>
  </div>
</div>