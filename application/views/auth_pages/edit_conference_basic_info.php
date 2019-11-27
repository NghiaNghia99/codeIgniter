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
    $conferencePhoto_file = $relativeDir . '/ConferencePictureParticipants.' . $ext . '?' . time();
}

?>
<div class="section-edit-conference">
  <div class="top-content">
    <div class="sm-menu-tab">
      <ul class="menu-edit-detail">
        <a class="basic-menu active">
          Basic information
        </a>
        <a class="optional-menu" href="<?= base_url('auth/conference/managed/conference-edit/optional-information/' . $conference['id']) ?>">
          Optional information
        </a>
        <a class="file-upload-menu" href="<?= base_url('auth/conference/managed/conference-edit/file-upload/' . $conference['id']) ?>">
          File upload
        </a>
      </ul>
    </div>
  </div>
  <div class="block-white tab-menu-content edit-info-tab-content">
    <div class="img-conference">
      <img src="<?= $banner_file ?>" alt="image"/>
    </div>
    <div class="title" id="confTitleEditBasic">
        <?php
        if (!empty($conference['confTitle'])) {
            echo $conference['confTitle'];
        } else {
            echo 'Empty';
        }
        ?>
    </div>
    <div class="title-form">
      Edit important conference/workshop information
      <input type="hidden" id="get_id_conference" value="<?= $conference['id'] ?>">
      <input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">
    </div>
    <form>
      <div class="attendance-fee">
        <div class="label-custom">
          Attendance fee
        </div>
        <p>
          If you plan to create a conference with a fee, please enter price and your PayPal account email here.
        </p>
        <div class="gr-check">
          <div class="form-item check-terms-item checkbox-register">
            <input type="radio" class="input" name="fee_status" id="free_conference"
                   value="0" <?php if ($conference['fee'] == 0) echo 'checked' ?>>
            <label></label>
            <div class="check-terms-item-text">Free</div>
          </div>
          <div class="form-item check-terms-item checkbox-register">
            <input type="radio" class="input fee-conference" name="fee_status"
                   value="1" <?php if ($conference['fee'] != 0) echo 'checked' ?>>
            <label></label>
            <div class="check-terms-item-text">Charge</div>
          </div>
        </div>
        <div class="row banking-info <?php if ($conference['fee'] == 0) echo 'd-none' ?>">
          <div class="col-md-6">
            <div class="form-item banking">
              <label class="form-label label-custom">
                Price
              </label>
              <input type="text" class="input input-custom edit-conference-beta edit-conference-price" name="fee"
                     placeholder="Price"
                     value="<?php if ($conference['fee'] > 0) {
                         echo number_format($conference['fee'], 2);
                     } ?>"/>
              <div class="error"><?php echo form_error('fee') ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Email Paypal
              </label>
              <input type="text" class="input input-custom edit-conference-beta" name="paypalEmail"
                     placeholder="Email Paypal"
                     value="<?php echo set_value('paypalEmail', $conference['paypalEmail']) ?>"/>
              <div class="error"><?php echo form_error('paypalEmail') ?></div>
            </div>
          </div>
        </div>
        <div class="success" id="free_conference_status"></div>
      </div>
      <?php if (!$checkStatusActive): ?>
      <div class="edit-conference-note-active">
        User needs to provide the dates the conference takes place and fill out the title, and the objectives to start the conference
      </div>
      <?php endif; ?>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item banking">
              <label class="form-label label-custom">
                Conference title
              </label>
              <input type="text" name="confTitle" placeholder="Conference title"
                     class="input input-custom edit-conference-beta"
                     value="<?php echo set_value('confTitle', $conference['confTitle']) ?>">
              <div class="error"><?php echo form_error('confTitle') ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Conference serie
              </label>
              <input type="text" name="confSeries" class="input input-custom edit-conference-beta"
                     placeholder="Conference series"
                     value="<?php echo set_value('confSeries', $conference['confSeries']) ?>">
              <div class="error"><?php echo form_error('confSeries') ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="form-item">
          <label class="form-label label-custom">
            Conference/ Workshop objectives
          </label>
          <div class="accordion accordion-conference editor-collapse">
            <div id="editAbstract" class="btn btn-accordion"
                 data-toggle="collapse"
                 data-target="#collapse-abstract"
                 aria-expanded="true" aria-controls="collapse-abstract">
                <?php if (!empty($conference['abstract'])) {
                    echo $conference['abstract'];
                } else {
                    echo 'Empty';
                } ?>
            </div>
            <div id="collapse-abstract" class="collapse session-accordion-content">
              <div class="error text-left mb-2"></div>
              <textarea id="abstract" class="textarea-custom">
                  <?php echo set_value('abstract', $conference['abstract']) ?>
                </textarea>
              <div class="btn-custom btn-bg green btn-save-edit">
                <a class="btn-save-content" data-name="abstract" data-object="abstract"
                   data-button="editAbstract"
                   data-placeholder="Conference/ Workshop objectives">Save</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item">
              <label class="label-custom">
                Organizing institutions
              </label>
              <div class="accordion accordion-conference editor-collapse">
                <div id="organizingInstitutions" class="btn btn-accordion" data-toggle="collapse"
                     data-target="#collapse-organizing"
                     aria-expanded="true" aria-controls="collapse-organizing">
                    <?php if (!empty($conference['organizingInstitutions'])) {
                        echo $conference['organizingInstitutions'];
                    } else {
                        echo 'Empty';
                    } ?>
                </div>
                <div id="collapse-organizing" class="collapse session-accordion-content">
                <div class="error text-left mb-2"></div>
                <textarea name="organizingInstitutions" id="organizing" class="textarea-custom">
                  <?php echo set_value('organizingInstitutions', $conference['organizingInstitutions']) ?>
                </textarea>
                  <div class="btn-custom btn-bg green btn-save-edit">
                    <a id="btn_save_organizing">Save</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item">
              <label class="label-custom">
                Conference location
              </label>
              <div class="accordion accordion-conference editor-collapse">
                <div id="confLocation" class="btn btn-accordion" data-toggle="collapse" data-target="#collapse-location"
                     aria-expanded="true" aria-controls="collapse-location">
                    <?php if (!empty($conference['confLocation'])) {
                        echo $conference['confLocation'];
                    } else {
                        echo 'Empty';
                    } ?>
                </div>
                <div id="collapse-location" class="collapse session-accordion-content">
                <div class="error text-left mb-2"></div>
                <textarea name="confLocation" id="location" class="textarea-custom">
                  <?php echo set_value('confLocation', $conference['confLocation']) ?>
                </textarea>
                  <div class="btn-custom btn-bg green btn-save-edit">
                    <a id="btn_save_location">Save</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Main category
              </label>
              <div class="input input-custom min-height-40 input-main-category">
                <span id="set_category"><?= $conference['category_name'] ?></span> (<span
                  id="set_sub_category"><?= $conference['subcategory_name'] ?></span>)
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Alternative category
              </label>
              <div class="input input-custom min-height-40 input-alt-category">
              <span id="set_alt_category"><?php if (!empty($conference['altCategory1'])) {
                      echo $alt_category['alt_category_name'];
                  } ?></span>
                <span id="set_alt_subcategory"><?php if (!empty($conference['altSubCategory1'])) {
                        echo ' (' . $alt_category['alt_subcategory_name'] . ')';
                    } ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Main field of research
              </label>
              <select id="category_conference" name="category" class="input-custom select-custom-none-search edit-category">
                  <?php foreach ($categories[0] as $category): ?>
                    <option
                      <?php if ($conference['category'] == $category['id']) {
                          echo 'selected';
                      } ?>
                      value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                  <?php endforeach; ?>
              </select>
              <div class="error"><?php echo form_error('category') ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Alternative field of research
              </label>
              <select id="alt_category_conference" name="altCategory1"
                      class="input-custom select-custom-none-search edit-alt-category">
                <option></option>
                  <?php foreach ($categories[0] as $category): ?>
                    <option
                      <?php if ($conference['altCategory1'] == $category['id']) {
                          echo 'selected';
                      } ?>
                      value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                  <?php endforeach; ?>
              </select>
              <div class="error"><?php echo form_error('alt_category') ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Main research topic
              </label>
              <input type="hidden" id="get_id_category" value="<?= $conference['category'] ?>">
              <input type="hidden" id="get_id_subcategory" value="<?= $conference['subcategory'] ?>">
              <select id="sub_category" name="subcategory"
                      class="input-custom select-custom-none-search edit-subcategory">
              </select>
              <div class="error"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item">
              <label class="form-label label-custom">
                Alternative research topic
              </label>
              <input type="hidden" id="get_id_alt_category" value="<?= $conference['altCategory1'] ?>">
              <input type="hidden" id="get_id_alt_subcategory" value="<?= $conference['altSubCategory1'] ?>">
              <select id="alt_sub_category" name="altSubCategory1"
                      class="input-custom select-custom-none-search edit-alt-subcategory">
                <option></option>
              </select>
              <div class="error"><?php echo form_error('alt_subcategory') ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item input-group datetime-picker">
              <label class="form-label label-custom ">
                Start date of conference/ workshop
              </label>
              <input class="input-custom input-medium datepicker edit-conference-beta" name="startDate"
                     placeholder="Start date of conference/ workshop" data-date-format="dd.mm.yyyy" id="startDate" readonly
                     value="<?php if (!empty($conference['startDate'])) echo date('d.m.Y', $conference['startDate']) ?>">
              <div class="error"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item input-group datetime-picker">
              <label class="form-label label-custom ">
                End date of conference/ workshop
              </label>
              <input class="input-custom input-medium datepicker edit-conference-beta" name="endDate"
                     placeholder="End date of conference/ Workshop" data-date-format="dd.mm.yyyy" id="endDate" readonly
                     value="<?php if (!empty($conference['endDate'])) echo date('d.m.Y', $conference['endDate']) ?>">
              <div class="error"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="edit-info-container">
        <div class="row">
          <div class="col-md-6">
            <div class="form-item">
              <label class="label-custom">
                Sessions
              </label>
              <div class="accordion accordion-conference">
                <div id="session_conference_list_name" class="btn btn-accordion" data-toggle="collapse"
                     data-target="#collapse-session" aria-expanded="true"
                     aria-controls="collapse-session">
                    <?php
                    if (count($sessions) > 0) {
                        foreach ($sessions as $session) {
                            echo '<p class="' . $session['ID'] . '">' . $session['name'] . '</p>';
                        }
                    }
                    ?>
                </div>
                <div id="collapse-session" class="collapse session-accordion-content">
                  <div class="title extra-small-title">
                    Session planner
                  </div>
                  <p>
                    Select a session to rename it
                  </p>
                  <p>
                    Click "Add" to create a new session.
                  </p>
                  <div id="session_conference_list">
                      <?php
                      if (count($sessions) > 0) : foreach ($sessions as $session) : ?>
                        <div class="form-item input-group">
                          <input type="text" class="input input-custom input-session-name" id="<?= $session['ID'] ?>"
                                 value="<?= $session['name'] ?>"/>
                          <div id="<?= $session['ID'] ?>" class="input-group-append">
                            <span class="icon-cancel input-group-text btn_remove_session"></span>
                          </div>
                          <div class="error"></div>
                        </div>
                      <?php endforeach; endif; ?>
                  </div>
                  <div class="gr-btn-bottom">
                    <div class="btn-custom btn-bg dark-green btn-add">
                      <a id="btn_add_session">
                        Add
                      </a>
                    </div>
                    <div class="btn-custom btn-bg green btn-done">
                      <a id="btn_submit_update_session">
                        Done
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="attendee-list">
        <div class="label-custom">
          Attendee list of the conference
        </div>
        <p>
          When you select the "Yes" option, the entire attendee list of the conference will appear in public and
          everyone can see it on the details page.
        </p>
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input edit-conference-beta" name="showParticipation"
                 value="1" <?php if ($conference['showParticipation'] != 0) echo 'checked' ?>>
          <label></label>
          <div class="check-terms-item-text">Yes</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input edit-conference-beta" name="showParticipation"
                 value="0" <?php if ($conference['showParticipation'] == 0) echo 'checked' ?>>
          <label></label>
          <div class="check-terms-item-text">No</div>
          <div class="error"></div>
        </div>
      </div>
      <?php if ($conference['userID'] == $userID): ?>
      <div class="invite-co-author">
        <div class="title small-title">
          Invite Co-Author
        </div>
        <p>
          You can not invite a co-editor with an email address that does not seem to belong to an institution,
          university or company (e.g: gmail, gmx, web.de, yahoo).
        </p>
        <p>
          *Note: You can send invitation to max 20 co-author at the same time.
        </p>
        <div class="gr-form-item">
          <div class="form-item">
            <label class="form-label label-custom">
             Add new co-authors's email
            </label>
            <input id="input_email_coauthor" type="text" class="input input-custom"/>
            <div class="error error-email-coauthor"></div>
          </div>
          <div class="form-item">
            <div class="label-custom">
              Allow
            </div>
            <button id="btn_set_permission_coauthor" type="button" class="btn btn-bg btn-show-modal placeholder">
              Select permission
              <i class="icon-angle-right"></i>
            </button>
          </div>
        </div>
        <div id="list_set_permission_coauthor">
        </div>
        <div id="btn_send_email_invite_coauthor" class="btn-custom btn-bg green btn-send d-none">
          <a class="add-spinner" id="btn_submit_permission_coauthor">Send email</a>
        </div>
          <?php if (!empty($coAuthors)) : ?>
            <div class="sm-table-item">
              <table class="table table-custom table-co-author">
                <thead>
                <tr>
                  <th>
                    Co-Author List
                  </th>
                  <th>
                    Allow
                  </th>
                  <th>
                    Status
                  </th>
                  <th>
                    Delete
                  </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($coAuthors as $coAuthor) :
                    $count = 0;
                    $firstPermission = '';
                    if ($coAuthor->editContributions) {
                        $count++;
                        $firstPermission = 'Manage contributi...';
                    }
                    if ($coAuthor->editRestrict) {
                        $count++;
                        $firstPermission = 'Restricted access...';
                    }
                    if ($coAuthor->editAbstracts) {
                        $count++;
                        $firstPermission = 'Abstracts';
                    }
                    if ($coAuthor->editRegistration) {
                        $count++;
                        $firstPermission = 'Registration';
                    }
                    if ($coAuthor->editConference) {
                        $count++;
                        $firstPermission = 'Edit conference p...';
                    }
                    ?>
                  <tr>
                    <td>
                      <div class="form-item">
                        <input type="text" class="input input-custom readonly-custom" readonly
                               value="<?= $coAuthor->email ?>"/>
                        <div class="error"></div>
                      </div>
                    </td>
                    <td>
                      <button data="<?= $coAuthor->id ?>" type="button"
                              class="btn btn-bg btn-show-modal btn-show-permission-co-author">
                          <?= $firstPermission ?>
                          <?php if ($count > 1) : ?>
                            <span class="number">+ <?php echo $count - 1; ?></span>
                          <?php endif; ?>
                        <i class="icon-angle-right"></i>
                      </button>
                    </td>
                    <td>
                  <span class="brand status <?php if ($coAuthor->status == 'Accept') {
                      echo 'approve';
                  } elseif ($coAuthor->status == 'Pending') {
                      echo 'pending';
                  } else {
                      echo 'deny';
                  } ?>">
                    <?= $coAuthor->status ?>
                  </span>
                        <?php if ($coAuthor->status != 'Accept') : if (!$this->session->tempdata('resend_invite_co_author')) : ?>
                          <button data="<?= $coAuthor->id ?>"
                                  class="btn btn-border green btn-resend btn-resend-invite-co-author">
                            Resend
                          </button>
                          <?php else : ?>
                          <button class="btn btn-border green btn-resend">Sent</button>
                        <?php endif; endif; ?>
                    </td>
                    <td>
                      <span data="<?= $coAuthor->id ?>" class="icon-cancel btn-remove-co-author"></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        <div class="co-author-list-mobile block-white">
            <?php foreach ($coAuthors as $coAuthor) :
            $count = 0;
            $firstPermission = '';
            if ($coAuthor->editContributions) {
                $count++;
                $firstPermission = 'Manage contributi...';
            }
            if ($coAuthor->editRestrict) {
                $count++;
                $firstPermission = 'Restricted access...';
            }
            if ($coAuthor->editAbstracts) {
                $count++;
                $firstPermission = 'Abstracts';
            }
            if ($coAuthor->editRegistration) {
                $count++;
                $firstPermission = 'Registration';
            }
            if ($coAuthor->editConference) {
                $count++;
                $firstPermission = 'Edit conference p...';
            }
            ?>
          <div class="co-author-module">
            <div class="action">
              <div class="brand status <?php if ($coAuthor->status == 'Accept') {
                  echo 'approve';
              } elseif ($coAuthor->status == 'Pending') {
                  echo 'pending';
              } else {
                  echo 'deny';
              } ?>">
                  <?= $coAuthor->status ?>
              </div>
              <div class="delete">
                <span data="<?= $coAuthor->id ?>" class="icon-cancel btn-remove-co-author"></span>
              </div>
            </div>
            <div class="form-item">
              <label class="label-custom">
                Co-Author
              </label>
              <input type="text" class="input input-custom readonly-custom" readonly value="<?= $coAuthor->email ?>"/>
            </div>
            <div class="form-item">
              <label class="label-custom">
                Allow
              </label>
              <button data="<?= $coAuthor->id ?>" type="button"
                      class="btn btn-bg btn-show-modal btn-show-permission-co-author">
                  <?= $firstPermission ?>
                  <?php if ($count > 1) : ?>
                    <span class="number">+ <?php echo $count - 1; ?></span>
                  <?php endif; ?>
                <i class="icon-angle-right"></i>
              </button>
            </div>
              <?php if ($coAuthor->status != 'Accept') : if (!$this->session->tempdata('resend_invite_co_author')) : ?>
                <button data="<?= $coAuthor->id ?>"
                        class="btn btn-border green btn-send-again btn-resend-invite-co-author">
                  Resend
                </button>
              <?php else : ?>
                <button class="btn btn-border green btn-send-again">Sent</button>
              <?php endif; endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </form>
  </div>
</div>
<div class="modal sm-modal modal-permission" id="permission" tabindex="-1" role="dialog"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Select Permission
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <input type="hidden" id="getConfPermissionID">
        <div class="form-item check-terms-item checkbox-register checkbox-square">
          <input type="checkbox" id="editConference" class="input input-permission" name="check_terms"
                 value="Edit conference page">
          <label></label>
          <div class="check-terms-item-text">Edit conference page</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register checkbox-square">
          <input type="checkbox" id="editRegistration" class="input input-permission" name="check_terms"
                 value="Registration">
          <label></label>
          <div class="check-terms-item-text">Registration</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register checkbox-square">
          <input type="checkbox" id="editAbstracts" class="input input-permission" name="check_terms" value="Abstracts">
          <label></label>
          <div class="check-terms-item-text">Abstracts</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register checkbox-square">
          <input type="checkbox" id="editRestrict" class="input input-permission" name="check_terms"
                 value="Restricted access">
          <label></label>
          <div class="check-terms-item-text">Restricted access</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register checkbox-square">
          <input type="checkbox" id="editContributions" class="input input-permission" name="check_terms"
                 value="Manage contributions">
          <label></label>
          <div class="check-terms-item-text">Manage contributions</div>
          <div class="error"></div>
        </div>
      </div>
      <div class="error error-choose-permission"></div>
      <div class="sm-modal-footer">
        <div class="btn-custom btn-bg green btn-done">
          <a id="btn_submit_permission_co_author" class="d-none">
            Done
          </a>
          <a id="btn_change_permission_co_author" class="d-none">
            Done
          </a>
        </div>
      </div>
    </div>
  </div>
</div>