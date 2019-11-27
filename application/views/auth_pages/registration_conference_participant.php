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
          <a class="nav-link <?php if (!$this->session->tempdata('registration_tool_tab')) echo 'active'; ?>" id="participant-tab" data-toggle="tab" href="#participant" role="tab"
             aria-controls="participant" aria-selected="true">Participant list</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($this->session->tempdata('registration_tool_tab')) echo 'active'; ?>" id="registration-tool-tab" data-toggle="tab" href="#registration-tool" role="tab"
             aria-controls="registration-tool" aria-selected="true">Registration tool</a>
        </li>
      </ul>
      <div class="tab-content conference-tab-content registration-conference-tab-content" id="myTabContent">
        <div class="tab-pane conference-tab-pane participant-tab-content <?php if (!$this->session->tempdata('registration_tool_tab')) echo 'active'; ?>" id="participant" role="tabpanel"
             aria-labelledby="participant-tab">

          <input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">
          <div class="img-conference">
            <img src="<?= $banner_file ?>">
          </div>
          <div class="tab-content-detail">
            <div class="title">
              <?= $conference['confTitle'] ?>
            </div>
            <div class="sub-title">
              Registered participants
            </div>
            <p>
              Click on name to get more details about participant.
            </p>
            <div class="sm-table-item">
              <div class="table-filter">
                  <?= $registrationList ?>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane conference-tab-pane registration-tool-tab-content <?php if ($this->session->tempdata('registration_tool_tab')) echo 'active'; ?>" id="registration-tool" role="tabpanel"
             aria-labelledby="registration-tool-tab">
          <div class="img-conference">
            <img src="<?= $banner_file ?>">
          </div>
          <div class="tab-content-detail">
            <div class="title">
              <?= $conference['confTitle'] ?>
            </div>
            <div class="sub-title">
              Setup conference/workshop registration tool
            </div>
              <?php
              $now = time();
              if (!empty($registrationTool->registrationStart) && !empty($registrationTool->registrationEnd)) :
                  if ((int)$registrationTool->registrationStart < $now && $now < (int)$registrationTool->registrationEnd) :
                  ?>
                <div class="block-status opening">
                  <div class="title small-title">
                    Registration status
                  </div>
                  <div class="gr-icon-text">
                    <span class="icon-calendar"></span>
                      <?= date('d.m.Y', $registrationTool->registrationStart) ?> - <?= date('d.m.Y',
                        $registrationTool->registrationEnd) ?>
                  </div>
                  <div class="brand status">
                    Opening
                  </div>
                </div>
                  <?php else: ?>
                    <div class="block-status closed">
                      <div class="title small-title">
                        Registration status
                      </div>
                      <div class="gr-icon-text">
                        <span class="icon-calendar"></span>
                          <?= date('d.m.Y', $registrationTool->registrationStart) ?> - <?= date('d.m.Y',
                            $registrationTool->registrationEnd) ?>
                      </div>
                      <div class="brand status">
                        Closed
                      </div>
                    </div>
              <?php endif; else: ?>
            <div class="block-status">
              <div class="title small-title">
                Registration status
              </div>
              <div class="gr-icon-text">
                <div class="gr-icon-text">You have not set up an registration submission form, yet</div>
              </div>
            </div>
            <?php endif; ?>
            <div class="list-registration-item">
              <div class="row">
                <div class="col-md-6">
                  <div class="registration-item">
                    <div class="title small-title">
                      Setup registration form
                    </div>
                    <p>
                      If you wish to use our conference/workshop registration tool, please set up the mandatory
                      information here. You may provide basic information at the top of the registration form.<br/>Also, you
                      can get the dates when the registration period starts and ends.
                    </p>
                    <div class="btn-custom btn-border green" data-toggle="modal" data-target="#setup-registration">
                      <a>
                        Setup
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="registration-item">
                    <div class="title small-title">
                      Registration form
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
<div class="modal sm-modal setup-registration-modal" id="setup-registration" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title">
          Setup registration for CID: <?= $conference['CID'] ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title small-title">
          Headline notes for the registration:
        </div>
        <div class="form-item">
          <label class="label-custom">
            Notes appearing at the top of the registration form
            <span class="req">*</span>
          </label>
          <textarea name="registrationText" id="registrationText" placeholder="Note"
                    class="textarea-custom"><?php if (!empty($registrationTool->registrationText)) echo $registrationTool->registrationText ?></textarea>
          <div class="error"></div>
        </div>
        <div class="title small-title">
          Setup the time frame for registration:
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-item input-group datetime-picker">
              <label class="label-custom">
                Start of registration period
                <span class="req">*</span>
              </label>
              <input class="input-custom input-medium datepicker" name="registrationStart"
                     placeholder="Start of registration period" data-date-format="dd.mm.yyyy" id="startDate" readonly
                     value="<?php if (!empty($registrationTool->registrationStart)) echo date('d.m.Y',
                       $registrationTool->registrationStart) ?>">
              <div class="error"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-item input-group datetime-picker">
              <label class="label-custom">
                Deadline for registration
                <span class="req">*</span>
              </label>
              <input class="input-custom input-medium datepicker" name="registrationEnd"
                     placeholder="Deadline for registration" data-date-format="dd.mm.yyyy" id="endDate" readonly
                     value="<?php if (!empty($registrationTool->registrationEnd)) echo date('d.m.Y',
                       $registrationTool->registrationEnd) ?>">
              <div class="error"></div>
            </div>
          </div>
        </div>
        <div class="form-item check-terms-item checkbox-register checkbox-square ">
          <input type="checkbox" class="input" name="registerForDinner"
                 id="registerForDinner" <?php if (!empty($registrationTool->registerForDinner)) {
              echo 'checked';
          } ?>>
          <label></label>
          <div class="check-terms-item-text">Conference Dinner registration</div>
          <div class="error"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Name for optional checkbox 1 (leave empty, if not used)
          </label>
          <input type="text" class="input-custom" placeholder="Title" id="optionalCheckbox1"
                 value="<?php if (!empty($registrationTool->optionalCheckbox1)) echo $registrationTool->optionalCheckbox1 ?>"/>
          <div class="error"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Name for optional checkbox 2 (leave empty, if not used)
          </label>
          <input type="text" class="input-custom" placeholder="Title" id="optionalCheckbox2"
                 value="<?php if (!empty($registrationTool->optionalCheckbox2)) echo $registrationTool->optionalCheckbox2 ?>"/>
          <div class="error"></div>
        </div>
      </div>
      <div class="sm-modal-footer">
        <div class="btn-custom btn-bg dark-green btn-close" data-dismiss="modal">
          <a>Close</a>
        </div>
        <div class="btn-custom btn-bg green btn-close">
          <a id="btn_submit_registration_tool">Save</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Registration form -->
<div class="modal sm-modal registration-form-modal" id="registration-form" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Registration form
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Comments by conference host
          </div>
          <div class="content-sm-text-item">
              <?php
              if (!empty($registrationTool->registrationText)) {
                  echo $registrationTool->registrationText;
              } else {
                  echo 'Empty';
              }
              ?>
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Personal information, that will be submitted to the conference organizer
          </div>
        </div>
        <div class="small-title">
          Max Mustermann
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            E-Mail
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Affiliation
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Department
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Streetname/Number
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            City
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            State
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Postal code
          </div>
        </div>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            Country
          </div>
        </div>
        <p>
          The following address information is going to be printed on the conference receipt. This information can not
          be changed after the receipt has been issued. Please edit the information below.
        </p>
        <div class="form-item check-terms-item checkbox-register checkbox-square ">
          <input type="checkbox" class="input" name="check_terms" value="1">
          <label></label>
          <div class="check-terms-item-text">Please use the address information from my profile</div>
          <div class="error"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Name
            <span class="req">*</span>
          </label>
          <input type="text" class="input-custom" placeholder="University/Institute/Company"/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Streetname/Number
            <span class="req">*</span>
          </label>
          <textarea class="textarea-custom"
                    placeholder="Street name and number of university/institute/company"></textarea>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            Postal Code
            <span class="req">*</span>
          </label>
          <input type="text" class="input-custom" placeholder="Postal code"/>
          <div class="errorr"></div>
        </div>
        <div class="form-item">
          <label class="label-custom">
            City
            <span class="req">*</span>
          </label>
          <input type="text" class="input-custom" placeholder="City"/>
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
            Country
            <span class="req">*</span>
          </label>
          <select class="input-custom select-custom">
            <option></option>
              <?php
              $countries = array(
                "Afghanistan",
                "Albania",
                "Algeria",
                "American Samoa",
                "Andorra",
                "Angola",
                "Anguilla",
                "Antarctica",
                "Antigua and Barbuda",
                "Argentina",
                "Armenia",
                "Aruba",
                "Australia",
                "Austria",
                "Azerbaijan",
                "Bahamas",
                "Bahrain",
                "Bangladesh",
                "Barbados",
                "Belarus",
                "Belgium",
                "Belize",
                "Benin",
                "Bermuda",
                "Bhutan",
                "Bolivia",
                "Bosnia and Herzegowina",
                "Botswana",
                "Bouvet Island",
                "Brazil",
                "British Indian Ocean Territory",
                "Brunei Darussalam",
                "Bulgaria",
                "Burkina Faso",
                "Burundi",
                "Cambodia",
                "Cameroon",
                "Canada",
                "Cape Verde",
                "Cayman Islands",
                "Central African Republic",
                "Chad",
                "Chile",
                "China",
                "Christmas Island",
                "Cocos (Keeling) Islands",
                "Colombia",
                "Comoros",
                "Congo",
                "Congo, the Democratic Republic of the",
                "Cook Islands",
                "Costa Rica",
                "Cote d'Ivoire",
                "Croatia (Hrvatska)",
                "Cuba",
                "Cyprus",
                "Czech Republic",
                "Denmark",
                "Djibouti",
                "Dominica",
                "Dominican Republic",
                "East Timor",
                "Ecuador",
                "Egypt",
                "El Salvador",
                "Equatorial Guinea",
                "Eritrea",
                "Estonia",
                "Ethiopia",
                "Falkland Islands (Malvinas)",
                "Faroe Islands",
                "Fiji",
                "Finland",
                "France",
                "France Metropolitan",
                "French Guiana",
                "French Polynesia",
                "French Southern Territories",
                "Gabon",
                "Gambia",
                "Georgia",
                "Germany",
                "Ghana",
                "Gibraltar",
                "Greece",
                "Greenland",
                "Grenada",
                "Guadeloupe",
                "Guam",
                "Guatemala",
                "Guinea",
                "Guinea-Bissau",
                "Guyana",
                "Haiti",
                "Heard and Mc Donald Islands",
                "Holy See (Vatican City State)",
                "Honduras",
                "Hong Kong",
                "Hungary",
                "Iceland",
                "India",
                "Indonesia",
                "Iran (Islamic Republic of)",
                "Iraq",
                "Ireland",
                "Israel",
                "Italy",
                "Jamaica",
                "Japan",
                "Jordan",
                "Kazakhstan",
                "Kenya",
                "Kiribati",
                "Korea, Democratic People's Republic of",
                "Korea, Republic of",
                "Kuwait",
                "Kyrgyzstan",
                "Lao, People's Democratic Republic",
                "Latvia",
                "Lebanon",
                "Lesotho",
                "Liberia",
                "Libyan Arab Jamahiriya",
                "Liechtenstein",
                "Lithuania",
                "Luxembourg",
                "Macau",
                "Macedonia, The Former Yugoslav Republic of",
                "Madagascar",
                "Malawi",
                "Malaysia",
                "Maldives",
                "Mali",
                "Malta",
                "Marshall Islands",
                "Martinique",
                "Mauritania",
                "Mauritius",
                "Mayotte",
                "Mexico",
                "Micronesia, Federated States of",
                "Moldova, Republic of",
                "Monaco",
                "Mongolia",
                "Montserrat",
                "Morocco",
                "Mozambique",
                "Myanmar",
                "Namibia",
                "Nauru",
                "Nepal",
                "Netherlands",
                "Netherlands Antilles",
                "New Caledonia",
                "New Zealand",
                "Nicaragua",
                "Niger",
                "Nigeria",
                "Niue",
                "Norfolk Island",
                "Northern Mariana Islands",
                "Norway",
                "Oman",
                "Pakistan",
                "Palau",
                "Panama",
                "Papua New Guinea",
                "Paraguay",
                "Peru",
                "Philippines",
                "Pitcairn",
                "Poland",
                "Portugal",
                "Puerto Rico",
                "Qatar",
                "Reunion",
                "Romania",
                "Russian Federation",
                "Rwanda",
                "Saint Kitts and Nevis",
                "Saint Lucia",
                "Saint Vincent and the Grenadines",
                "Samoa",
                "San Marino",
                "Sao Tome and Principe",
                "Saudi Arabia",
                "Senegal",
                "Seychelles",
                "Sierra Leone",
                "Singapore",
                "Slovakia (Slovak Republic)",
                "Slovenia",
                "Solomon Islands",
                "Somalia",
                "South Africa",
                "South Georgia and the South Sandwich Islands",
                "Spain",
                "Sri Lanka",
                "St. Helena",
                "St. Pierre and Miquelon",
                "Sudan",
                "Suriname",
                "Svalbard and Jan Mayen Islands",
                "Swaziland",
                "Sweden",
                "Switzerland",
                "Syrian Arab Republic",
                "Taiwan",
                "Tajikistan",
                "Tanzania, United Republic of",
                "Thailand",
                "Togo",
                "Tokelau",
                "Tonga",
                "Trinidad and Tobago",
                "Tunisia",
                "Turkey",
                "Turkmenistan",
                "Turks and Caicos Islands",
                "Tuvalu",
                "Uganda",
                "Ukraine",
                "United Arab Emirates",
                "United Kingdom",
                "United States",
                "United States Minor Outlying Islands",
                "Uruguay",
                "Uzbekistan",
                "Vanuatu",
                "Venezuela",
                "Vietnam",
                "Virgin Islands (British)",
                "Virgin Islands (U.S.)",
                "Wallis and Futuna Islands",
                "Western Sahara",
                "Yemen",
                "Yugoslavia",
                "Zambia",
                "Zimbabwe"
              );
              foreach ($countries as $country) : ?>
                <option value="<?= $country ?>"><?= $country ?></option>
              <?php endforeach; ?>
          </select>
          <div class="error"></div>
        </div>
          <?php if (!empty($registrationTool->registerForDinner)) : ?>
            <div class="form-item gr-checkbox">
              <label class="label-custom">
                I will attend the conference dinner (special fees may apply):
                <span class="req">*</span>
              </label>
              <div class="gr-checkbox-inline d-flex">
                <div class="form-item check-terms-item checkbox-register">
                  <input type="radio" class="input" name="check_terms" value="1">
                  <label></label>
                  <div class="check-terms-item-text">Yes</div>
                  <div class="error"></div>
                </div>
                <div class="form-item check-terms-item checkbox-register">
                  <input type="radio" class="input" name="check_terms" value="0" checked>
                  <label></label>
                  <div class="check-terms-item-text">No</div>
                  <div class="error"></div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <p>
          Any special information that the conference host needs to know about, e.g. special diet, etc.?
        </p>
        <div class="form-item">
          <label class="label-custom">
            Information
            <span class="req">*</span>
          </label>
          <textarea class="textarea-custom" placeholder="Special diet, etc."></textarea>
        </div>
          <?php if (!empty($registrationTool->optionalCheckbox1)) : ?>
            <div class="form-item check-terms-item checkbox-register checkbox-square ">
              <input type="checkbox" class="input" name="check_terms" value="1">
              <label></label>
              <div class="check-terms-item-text"><?= $registrationTool->optionalCheckbox1 ?></div>
              <div class="error"></div>
            </div>
          <?php endif; ?>
          <?php if (!empty($registrationTool->optionalCheckbox2)) : ?>
            <div class="form-item check-terms-item checkbox-register checkbox-square ">
              <input type="checkbox" class="input" name="check_terms" value="1">
              <label></label>
              <div class="check-terms-item-text"><?= $registrationTool->optionalCheckbox2 ?></div>
              <div class="error"></div>
            </div>
          <?php endif; ?>
        <div class="form-item">
          <label class="label-custom">
            I agree that my name will be published as a participant on the conference web page:
            <span class="req">*</span>
          </label>
          <div class="gr-checkbox-inline d-flex">
            <div class="form-item check-terms-item checkbox-register">
              <input type="radio" class="input" name="check_terms1" value="1" checked>
              <label></label>
              <div class="check-terms-item-text">Yes</div>
              <div class="error"></div>
            </div>
            <div class="form-item check-terms-item checkbox-register">
              <input type="radio" class="input" name="check_terms1" value="0">
              <label></label>
              <div class="check-terms-item-text">No</div>
              <div class="error"></div>
            </div>
          </div>
          <p>
            Please click "Register" now to complete the registration process.
          </p>
        </div>
        <div class="btn-custom btn-bg dark-green mobile-item" data-dismiss="modal" aria-label="Close">Close</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal information -->
<div class="modal sm-modal information-modal" id="registration-information-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
</div>

<!-- Modal enter reason of reject conference-->
<div class="modal sm-modal modal-reject" id="reject_registration" tabindex="-1" role="dialog"
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
          Please provide why you are rejecting the registration
        </div>
        <input type="hidden" id="get_id_registration">
        <div class="form-item">
          <label class="label-custom">
            Detail
            <span class="req">*</span>
          </label>
          <textarea name="reasonRejectRegistration" id="reasonRejectRegistration" class="textarea-custom"></textarea>
          <div class="error"></div>
        </div>
      </div>
      <div class="sm-modal-footer">
        <div class="btn-custom btn-bg green">
          <a class="add-spinner" id="btn_submit_reject_registration">Submit</a>
        </div>
      </div>
    </div>
  </div>
</div>
