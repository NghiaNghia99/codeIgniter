<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-Apr-19
 * Time: 11:44
 */
?>
<div class="section-register">
  <div class="title big-font-normal">Registration</div>
  <div class="container">
    <div class="block-white">
      <form id="registerForm" method="post">
          <?php if (empty($user)) { ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-item">
                  <label class="form-label label-custom">First name <span class="req">*</span></label>
                  <input type="text" class="input input-custom" id="first_name" name="first_name"
                         placeholder="First Name" value="<?php echo set_value('first_name') ?>">
                  <div class="error"><?php echo form_error('first_name') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Last name <span class="req">*</span></label>
                  <input type="text" class="input input-custom" id="last_name" name="last_name" placeholder="Last Name"
                         value="<?php echo set_value('last_name') ?>">
                  <div class="error"><?php echo form_error('last_name') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Affiliation <span class="req">*</span></label>
                  <input type="text" class="input input-custom" name="affiliation"
                         placeholder="University/Institute/Company" value="<?php echo set_value('affiliation') ?>">
                  <div class="error"><?php echo form_error('affiliation') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Field of research </label>
                  <select id="category" name="category" class="input-custom select-custom-none-search">
                    <option></option>
                      <?php foreach ($categories[0] as $category): ?>
                        <option
                          <?php if (isset($_SESSION['get_category_id']) && $categoryID == $category['id']) {
                              echo 'selected';
                          } ?>
                          value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-item">
                    <input type="hidden" id="get_id_category" value="<?php if (isset($_SESSION['get_category_id'])) echo $categoryID; ?>">
                    <input type="hidden" id="get_id_subcategory" value="<?php if (isset($_SESSION['get_subcategory_id'])) echo $subCategoryID; ?>">
                  <label class="form-label label-custom">Research topic </label>
                  <select id="sub_category" name="subcategory" class="input-custom select-custom-none-search">
                    <option value=""></option>
                  </select>
                  <div class="error"><?php echo form_error('subcategory') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Address </label>
                  <textarea class="textarea-custom" id="address" name="address"
                            placeholder="Address of University/Institute/Company"><?php echo set_value('address') ?></textarea>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Postal code </label>
                  <input type="text" class="input input-custom" name="postalCode" placeholder="Postal code"
                         value="<?php echo set_value('postalCode') ?>">
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">City </label>
                  <input type="text" class="input input-custom" id="city" name="city" placeholder="City"
                         value="<?php echo set_value('city') ?>">
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">State </label>
                  <input type="text" class="input input-custom" id="state" name="state" placeholder="State"
                         value="<?php echo set_value('state') ?>">
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Country </label>
                  <select name="country" class="input-custom select-custom">
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
                      foreach ($countries as $country) :
                          ?>
                        <option
                          value="<?= $country ?>" <?php if ($this->session->flashdata('get_country_name') && $country == $this->session->flashdata('get_country_name')) {
                            echo 'selected';
                        } ?>><?= $country ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-item">
                  <label class="form-label label-custom">Email <span class="req">*</span></label>
                  <input type="text" class="input input-custom" id="email" name="email" placeholder="Email"
                         value="<?php echo set_value('email') ?>">
                  <div class="error"><?php echo form_error('email') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Password <span class="req">*</span></label>
                  <input type="password" class="input input-custom" id="password" name="password" placeholder="Password"
                         value="<?php echo set_value('password') ?>">
                  <div class="error"><?php echo form_error('password') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Repeat <span class="req">*</span></label>
                  <input type="password" class="input input-custom" id="re_password" name="re_password"
                         placeholder="Repeat password" value="<?php echo set_value('re_password') ?>">
                  <div class="error"><?php echo form_error('re_password') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom label-custom-special">Required fields <span class="req">*</span></label>
                </div>
                <div class="form-item recaptcha-item">
                  <div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
                  <?php if (isset($_SESSION['errMsg_reCaptcha'])): ?>
                    <div class="error d-block"><?= $_SESSION['errMsg_reCaptcha'] ?></div>
                  <?php endif; ?>
                </div>
                <div class="form-item check-terms-item checkbox-register">
                  <input type="checkbox" class="input" name="check_terms" value="1">
                  <label></label>
                  <div class="check-terms-item-text">I agree to the <a class="link"
                                                                       href="<?= base_url('terms-and-conditions') ?>">Terms
                      and Conditions</a></div>
                  <div class="error"><?php echo form_error('check_terms') ?></div>
                </div>
                <input type="button" class="btn-custom btn-bg green btnRegister" value="Register">
              </div>
            </div>
          <?php } else { ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-item">
                  <label class="form-label label-custom">First name <span class="req">*</span></label>
                  <input type="text" class="input input-custom" id="first_name" name="first_name"
                         placeholder="First Name" value="<?php echo set_value('first_name', $user['firstName']) ?>">
                  <div class="error"><?php echo form_error('first_name') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Last name <span class="req">*</span></label>
                  <input type="text" class="input input-custom" id="last_name" name="last_name" placeholder="Last Name"
                         value="<?php echo set_value('last_name', $user['lastName']) ?>">
                  <div class="error"><?php echo form_error('last_name') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Affiliation <span class="req">*</span></label>
                  <input type="text" class="input input-custom" name="affiliation"
                         placeholder="University/Institute/Company"
                         value="<?php echo set_value('affiliation', $user['affiliation']) ?>">
                  <div class="error"><?php echo form_error('affiliation') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Field of research </label>
                  <select id="category" name="category" class="input-custom select-custom-none-search">
                    <option></option>
                      <?php foreach ($categories[0] as $category): ?>
                        <option
                          <?php if ($user['category'] == $category['id'] || isset($_SESSION['get_category_id']) && $categoryID == $category['id']) {
                              echo 'selected';
                          } ?>
                          value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Research topic </label>
                  <input type="hidden" id="get_id_category" value="<?php if (isset($_SESSION['get_category_id'])) echo $categoryID; else echo $user['category'] ?>">
                  <input type="hidden" id="get_id_subcategory" value="<?php if (isset($_SESSION['get_subcategory_id'])) echo $subCategoryID; else echo $user['subcategory'] ?>">
                  <select id="sub_category" name="subcategory" class="input-custom select-custom-none-search">
                    <option value=""></option>
                  </select>
                  <div class="error"><?php echo form_error('subcategory') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Address </label>
                  <textarea class="textarea-custom" id="address" name="address"
                            placeholder="Address of university/institute/company"><?php echo set_value('address',
                        $user['address']) ?></textarea>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Postal code </label>
                  <input type="text" class="input input-custom" name="postalCode" placeholder="Postal code"
                         value="<?php echo set_value('postalCode', $user['postalCode']) ?>">
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">City </label>
                  <input type="text" class="input input-custom" id="city" name="city" placeholder="City"
                         value="<?php echo set_value('city', $user['city']) ?>">
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">State </label>
                  <input type="text" class="input input-custom" id="state" name="state" placeholder="State"
                         value="<?php echo set_value('state', $user['state']) ?>">
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Country </label>
                  <select name="country" class="input-custom select-custom">
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
                      foreach ($countries as $country) :
                          ?>
                        <option value="<?= $country ?>" <?php if ($country == $user['country']) {
                            echo 'selected';
                        } ?>><?= $country ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-item">
                  <label class="form-label label-custom">Email<span class="req">*</span></label>
                  <input type="text" class="input input-custom" id="email" name="email" placeholder="Email"
                         value="<?php echo set_value('email', $user['email']) ?>">
                  <div class="error"><?php echo form_error('email') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Password<span class="req">*</span></label>
                  <input type="password" class="input input-custom" id="password" name="password" placeholder="Password"
                         value="<?php echo set_value('password') ?>">
                  <div class="error"><?php echo form_error('password') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom">Repeat<span class="req">*</span></label>
                  <input type="password" class="input input-custom" id="re_password" name="re_password"
                         placeholder="Repeat password" value="<?php echo set_value('re_password') ?>">
                  <div class="error"><?php echo form_error('re_password') ?></div>
                </div>
                <div class="form-item">
                  <label class="form-label label-custom label-custom-special">Required fields <span class="req">*</span></label>
                </div>
                <div class="form-item recaptcha-item">
                  <div class="g-recaptcha" data-sitekey="<?= $site_key ?>"></div>
                    <?php if (isset($_SESSION['errMsg_reCaptcha'])): ?>
                      <div class="error d-block"><?= $_SESSION['errMsg_reCaptcha'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-item check-terms-item checkbox-register">
                  <input type="checkbox" class="input" name="check_terms" value="1">
                  <label></label>
                  <div class="check-terms-item-text">I agree to the <a class="link"
                                                                       href="<?= base_url('terms-and-conditions') ?>">Terms
                      and Conditions</a></div>
                  <div class="error"><?php echo form_error('check_terms') ?></div>
                </div>
                <input type="button" class="btn-custom btn-bg green btnRegister" value="Register">
              </div>
            </div>
          <?php } ?>
      </form>
    </div>
  </div>
</div>
<div class="modal sm-modal modal-delete" id="modalNotificationNonConformEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <div class="">You have registered with an email address that does not seem to belong to an institution, university or company. Until we approve your address, you may not upload any content due to quality and securtiy measures. Thank you for your appreciation.</div>
      </div>
      <div class="sm-modal-footer">
        <div class="gr-button d-flex">
          <div class="btn-custom btn-bg green">
            <a class="add-spinner" id="btnRegisterNonConformEmail">
              OK
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
