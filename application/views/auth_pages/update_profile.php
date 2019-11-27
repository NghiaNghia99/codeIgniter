<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 02-May-19
 * Time: 17:51
 */
?>
<div class="section-update-profile block-white-p40-100">
  <form method="post">
      <div class="block-item">
          <div class="form-small-title">Information</div>
          <div class="form-item">
              <label class="form-label label-custom">First name<span class="req">*</span></label>
              <input type="text" class="input input-custom" id="first_name" name="first_name" placeholder="First Name"
                     value="<?php echo set_value('first_name', $user[0]->firstName) ?>">
              <div class="error"><?php echo form_error('first_name') ?></div>
          </div>
          <div class="form-item">
              <label class="form-label label-custom">Last name<span class="req">*</span></label>
              <input type="text" class="input input-custom" id="last_name" name="last_name" placeholder="Last Name"
                     value="<?php echo set_value('last_name', $user[0]->lastName) ?>">
              <div class="error"><?php echo form_error('last_name') ?></div>
          </div>
          <div class="form-item">
            <label class="form-label label-custom">Email<span class="req">*</span></label>
            <input type="text" class="input input-custom" id="email" name="email" disabled
                   value="<?php echo set_value('email', $user[0]->email) ?>">
          </div>
          <div class="form-item">
            <label class="form-label label-custom">Address</label>
            <input type="text" class="input input-custom" name="address"
                   value="<?php echo set_value('address', $user[0]->address) ?>">
          </div>
          <div class="form-item">
            <label class="form-label label-custom">Postal code</label>
            <input type="text" class="input input-custom" name="postalCode"
                   value="<?php echo set_value('postalCode', $user[0]->postalCode) ?>">
          </div>
          <div class="form-item">
            <label class="form-label label-custom">City</label>
            <input type="text" class="input input-custom" name="city"
                   value="<?php echo set_value('city', $user[0]->city) ?>">
          </div>
          <div class="form-item">
            <label class="form-label label-custom">State</label>
            <input type="text" class="input input-custom" name="state"
                   value="<?php echo set_value('state', $user[0]->state) ?>">
          </div>
          <div class="form-item">
            <label class="form-label label-custom">Country</label>
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
                    value="<?= $country ?>" <?php if ($country == $user[0]->country) {
                      echo 'selected';
                  } ?>><?= $country ?></option>
                <?php endforeach; ?>
            </select>
          </div>
      </div>
      <div class="block-item block-2">
          <div class="form-small-title">Professional information</div>
          <div class="form-item">
              <label class="form-label label-custom">Affiliation<span class="req">*</span></label>
              <input type="text" class="input input-custom" name="affiliation"
                     placeholder="University/Institute/Company"
                     value="<?php echo set_value('affiliation', $user[0]->affiliation) ?>">
              <div class="error"><?php echo form_error('affiliation') ?></div>
          </div>
          <div class="form-item">
              <label class="form-label label-custom">Field of research </label>
              <select id="category" name="category" class="input-custom select-custom-none-search">
                  <option value=""></option>
                  <?php foreach ($categories[0] as $category): ?>
                      <option
                          <?php if ($user[0]->category == $category['id'] || isset($_SESSION['get_category_id']) && $categoryID == $category['id']) {
                              echo 'selected';
                          } ?>
                          value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                  <?php endforeach; ?>
              </select>
              <div class="error"><?php echo form_error('category') ?></div>
          </div>
          <div class="form-item">
              <label class="form-label label-custom">Research topic </label>
              <input type="hidden" id="get_id_category"
                     value="<?php if (isset($_SESSION['get_category_id'])) echo $categoryID; else echo $user[0]->category; ?>">
              <input type="hidden" id="get_id_subcategory"
                     value="<?php if (isset($_SESSION['get_subcategory_id'])) echo $subCategoryID; else echo $user[0]->subcategory ?>">
              <select id="sub_category" name="subcategory" class="input-custom select-custom-none-search">
                  <option value=""></option>
              </select>
              <div class="error"><?php echo form_error('subcategory') ?></div>
          </div>
          <div class="form-item">
              <label class="form-label label-custom">Department </label>
              <input type="text" class="input input-custom" name="department" placeholder="Department"
                     value="<?php echo set_value('department', $user[0]->department) ?>">
          </div>
          <div class="form-item">
              <label class="form-label label-custom">Position </label>
              <input type="text" class="input input-custom" name="position" placeholder="Position"
                     value="<?php echo set_value('position', $user[0]->position) ?>">
          </div>
      </div>
      <input type="submit" class="add-spinner btn-custom btn-bg green" value="Save changes" name='submit'>
  </form>

</div>
