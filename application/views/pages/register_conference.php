<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 16-May-19
 * Time: 17:18
 */
?>
<!-- registration step 1 -->
<div id="register_conference_step_1"
     class="section-register-conference step-1  d-none">
  <div class="block-conference-content block-white">
    <div class="title">
      Registration for conference
    </div>
    <div class="form-item">
      <label class="label-custom">
        Please enter the CID of the conference, you want to register for and click "Next"
        <span class="req">*</span>
      </label>
      <input type="hidden" id="get_all_cid" value="<?= implode('|,|', $list_cid); ?>">
      <input type="text" class="input input-custom get-all-cid" id="get_cid_register_conference"
             autocomplete="off" data-provide="typeahead" name="cid" placeholder="CID"
             value="<?= $conference->CID ?>">
      <div class="error error-message"></div>
    </div>
    <div class="gr-btn-bottom d-flex">
      <div class="btn-custom btn-bg gray btn-back">
        <a href="<?= base_url('conference/' . $conference->id) ?>">
          Back
        </a>
      </div>
      <div class="btn-custom btn-bg green btn-next ml-auto">
        <a id="btn_next_register_conference">
          Next
        </a>
      </div>
    </div>
  </div>
</div>
<!-- registration step 2 id="register_conference_form"-->
<form method="post" id="register_conference_step_2"
      class="section-registration-conference">
  <div class="title">
    Registration for conference
    <span class="brand price">
        <?php
        if ($conference->fee != 0) {
            echo '&euro; ' . $conference->fee;
        } else {
            echo 'Free';
        }
        ?>
    </span>
  </div>
  <div class="register-conference-block">
    <div class="form-item">
      <label class="label-custom">
        CID of the conference
        <span class="req">*</span>
      </label>
      <input id="set_cid_register_conference" type="text" class="input input-custom" name="cid"
             value="<?= $conference->CID ?>" disabled/>
    </div>
    <div class="sm-text-item">
      <div class="title-sm-text-item">
        Comments by conference host:
      </div>
      <div class="content-sm-text-item">
          <?php
          if (!empty($registrationTool)) {
              echo $registrationTool->registrationText;
          }
          ?>
      </div>
    </div>
    <div class="sm-text-item">
      <div class="title-sm-text-item">
        Personal information, that will be submitted to the conference organizer:
      </div>
      <div class="content-sm-text-item">
        <div class="title">
            <?= $user->firstName ?> <?= $user->lastName ?>
        </div>
        <div class="show-info-item-mr-8 display-block">
          <span>Email</span>
            <?= $user->email ?>
        </div>
        <div class="show-info-item-mr-8 display-block">
          <span>Affiliation</span>
            <?= $user->affiliation ?>
        </div>
        <div class="show-info-item-mr-8 display-block">
          <span>Department</span>
            <?= $user->department ?>
        </div>
        <div class="show-info-item-mr-8 display-block">
          <span>Streetname/ Number</span>
            <?= $user->address ?>
        </div>
        <div class="show-info-item-mr-8">
          <span>City</span>
            <?= $user->city ?>
        </div>
        <div class="show-info-item-mr-8">
          <span>State</span>
            <?= $user->state ?>
        </div>
        <div class="show-info-item-mr-8">
          <span>Postal code</span>
            <?= $user->postalCode ?>
        </div>
        <div class="show-info-item-mr-8">
          <span>Country</span>
            <?= $user->country ?>
        </div>
      </div>
    </div>
    <input type="hidden" id="get_affiliation_register_conference" value="<?= $user->affiliation ?>">
    <input type="hidden" id="get_address_register_conference" value="<?= $user->address ?>">
    <input type="hidden" id="get_city_register_conference" value="<?= $user->city ?>">
    <input type="hidden" id="get_state_register_conference" value="<?= $user->state ?>">
    <input type="hidden" id="get_postalCode_register_conference" value="<?= $user->postalCode ?>">
    <input type="hidden" id="get_country_register_conference" value="<?= $user->country ?>">
    <p>
      The following address information is going to be printed on the conference receipt. This information can not be
      changed after the receipt has been issued. Please edit the information below.
    </p>
    <div class="form-item check-terms-item checkbox-register checkbox-square ">
      <input type="checkbox" class="input" id="use_info_profile_register_conference" name="check_terms" value="1">
      <label></label>
      <div class="check-terms-item-text">Please use the address information from my profile</div>
      <div class="error"></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Name/Affiliation
        <span class="req">*</span>
      </label>
      <input type="text" id="set_affiliation_register_conference" class="input input-custom" name="recName"
             placeholder="University/Institute/Company" value="<?php echo set_value('recName') ?>">
      <div class="error"><?php echo form_error('recName') ?></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Streetname/Number
        <span class="req">*</span>
      </label>
      <textarea id="set_address_register_conference" class="input textarea-custom" name="recStreet"
                placeholder="Street name and number of university/Institute/Company"><?php echo set_value('recStreet') ?></textarea>
      <div class="error"><?php echo form_error('recStreet') ?></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Postal code
        <span class="req">*</span>
      </label>
      <input type="text" id="set_postalCode_register_conference" class="input input-custom"
             name="recPostalCode" placeholder="Postal code" value="<?php echo set_value('recPostalCode') ?>">
      <div class="error"><?php echo form_error('recPostalCode') ?></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        City
        <span class="req">*</span>
      </label>
      <input type="text" id="set_city_register_conference" class="input input-custom" name="recCity"
             placeholder="City" value="<?php echo set_value('recCity') ?>">
      <div class="error"><?php echo form_error('recCity') ?></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        State
        <span class="req">*</span>
      </label>
      <input type="text" id="set_state_register_conference" class="input input-custom" name="recState"
             placeholder="State" value="<?php echo set_value('recState') ?>">
      <div class="error"><?php echo form_error('recState') ?></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Country
      </label>
      <select name="recCountry" id="set_country_register_conference" class="input-custom select-custom">
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
            <option
              value="<?= $country ?>" <?php if ($this->session->flashdata('get_country_name') && $country == $this->session->flashdata('get_country_name')) {
                echo 'selected';
            } ?>><?= $country ?></option>
          <?php endforeach; ?>
      </select>
      <div class="error"><?php echo form_error('recCountry') ?></div>
    </div>
      <?php if (!empty($registrationTool) && !empty($registrationTool->registerForDinner)): ?>
        <div class="sm-text-item">
          <div class="title-sm-text-item">
            I will attend the conference dinner (special fees may apply)
          </div>
          <div class="content-sm-text-item">
            <div class="gr-checkbox d-flex">
              <div class="form-item check-terms-item checkbox-register">
                <input type="radio" class="input" name="attendConfDinner" value="1">
                <label></label>
                <div class="check-terms-item-text">Yes</div>
                <div class="error"></div>
              </div>
              <div class="form-item check-terms-item checkbox-register">
                <input type="radio" class="input" name="attendConfDinner" value="0" checked>
                <label></label>
                <div class="check-terms-item-text">No</div>
                <div class="error"></div>
              </div>
            </div>
            <p>
              Any special information that the conference host needs to know about, e.g. special diet, etc.?
            </p>
          </div>
        </div>
      <?php endif; ?>
    <div class="form-item">
      <label class="label-custom">
        Information
      </label>
      <textarea name="additionalInfo" class="textarea-custom"
                placeholder="Special diet, etc."><?php echo set_value('additionalInfo') ?></textarea>
      <div class="error"><?php echo form_error('additionalInfo') ?></div>
    </div>
    <?php if (!empty($registrationTool->optionalCheckbox1)) : ?>
      <div class="form-item check-terms-item checkbox-register checkbox-square ">
        <input type="checkbox" class="input" name="option1" value="1">
        <label></label>
        <div class="check-terms-item-text"><?= $registrationTool->optionalCheckbox1 ?></div>
        <div class="error"></div>
      </div>
    <?php endif; ?>
    <?php if (!empty($registrationTool->optionalCheckbox2)) : ?>
      <div class="form-item check-terms-item checkbox-register checkbox-square ">
        <input type="checkbox" class="input" name="option2" value="1">
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
      <div class="gr-checkbox d-flex">
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input" name="publishName" value="1" checked>
          <label></label>
          <div class="check-terms-item-text">Yes</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input" name="publishName" value="0">
          <label></label>
          <div class="check-terms-item-text">No</div>
          <div class="error"></div>
        </div>
      </div>
    </div>
    <div class="gr-btn-bottom d-flex">
      <div class="btn-custom btn-bg gray btn-back">
        <a href="<?= base_url('conference/' . $conference->id) ?>">Back</a>
      </div>
        <?php if ($conference->fee != 0): ?>
          <input type="hidden" class="getCID" name="item_number" value="<?= $conference->CID ?>" />
          <input type="hidden" name="conference_fee" value="<?= $conference->fee ?>" />
          <input type="hidden" name="conference_id" value="<?= $conference->id ?>" />
          <input type="hidden" name="conference_paypalEmail" value="<?= $conference->paypalEmail ?>" />
          <input type="hidden" name="conference_title" value="<?= $conference->confTitle ?>" />
          <div class="gr-btn-bottom-register">
            <input type="submit" class="add-spinner btn-custom btn-bg gray btn-back btn_submit_register_conference"
                   value="Pay later" name='pay_later'>
            <input type="submit" class="add-spinner btn-custom btn-bg green btn-register btn_submit_register_conference"
                   value="Pay now" name='pay_now'>
          </div>
        <?php else: ?>
          <input type="submit" class="add-spinner btn-custom btn-bg green btn-register ml-auto btn_submit_register_conference"
                 value="Register" name='submit'>
        <?php endif; ?>
    </div>
  </div>
</form>