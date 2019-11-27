$(document).ready(function () {
  $('.get-country-list').append(
    '\t<option value="AF">Afghanistan</option>\n' +
    '\t<option value="AX">Åland Islands</option>\n' +
    '\t<option value="AL">Albania</option>\n' +
    '\t<option value="DZ">Algeria</option>\n' +
    '\t<option value="AS">American Samoa</option>\n' +
    '\t<option value="AD">Andorra</option>\n' +
    '\t<option value="AO">Angola</option>\n' +
    '\t<option value="AI">Anguilla</option>\n' +
    '\t<option value="AQ">Antarctica</option>\n' +
    '\t<option value="AG">Antigua and Barbuda</option>\n' +
    '\t<option value="AR">Argentina</option>\n' +
    '\t<option value="AM">Armenia</option>\n' +
    '\t<option value="AW">Aruba</option>\n' +
    '\t<option value="AU">Australia</option>\n' +
    '\t<option value="AT">Austria</option>\n' +
    '\t<option value="AZ">Azerbaijan</option>\n' +
    '\t<option value="BS">Bahamas</option>\n' +
    '\t<option value="BH">Bahrain</option>\n' +
    '\t<option value="BD">Bangladesh</option>\n' +
    '\t<option value="BB">Barbados</option>\n' +
    '\t<option value="BY">Belarus</option>\n' +
    '\t<option value="BE">Belgium</option>\n' +
    '\t<option value="BZ">Belize</option>\n' +
    '\t<option value="BJ">Benin</option>\n' +
    '\t<option value="BM">Bermuda</option>\n' +
    '\t<option value="BT">Bhutan</option>\n' +
    '\t<option value="BO">Bolivia, Plurinational State of</option>\n' +
    '\t<option value="BQ">Bonaire, Sint Eustatius and Saba</option>\n' +
    '\t<option value="BA">Bosnia and Herzegovina</option>\n' +
    '\t<option value="BW">Botswana</option>\n' +
    '\t<option value="BV">Bouvet Island</option>\n' +
    '\t<option value="BR">Brazil</option>\n' +
    '\t<option value="IO">British Indian Ocean Territory</option>\n' +
    '\t<option value="BN">Brunei Darussalam</option>\n' +
    '\t<option value="BG">Bulgaria</option>\n' +
    '\t<option value="BF">Burkina Faso</option>\n' +
    '\t<option value="BI">Burundi</option>\n' +
    '\t<option value="KH">Cambodia</option>\n' +
    '\t<option value="CM">Cameroon</option>\n' +
    '\t<option value="CA">Canada</option>\n' +
    '\t<option value="CV">Cape Verde</option>\n' +
    '\t<option value="KY">Cayman Islands</option>\n' +
    '\t<option value="CF">Central African Republic</option>\n' +
    '\t<option value="TD">Chad</option>\n' +
    '\t<option value="CL">Chile</option>\n' +
    '\t<option value="CN">China</option>\n' +
    '\t<option value="CX">Christmas Island</option>\n' +
    '\t<option value="CC">Cocos (Keeling) Islands</option>\n' +
    '\t<option value="CO">Colombia</option>\n' +
    '\t<option value="KM">Comoros</option>\n' +
    '\t<option value="CG">Congo</option>\n' +
    '\t<option value="CD">Congo, the Democratic Republic of the</option>\n' +
    '\t<option value="CK">Cook Islands</option>\n' +
    '\t<option value="CR">Costa Rica</option>\n' +
    '\t<option value="CI">Côte d\'Ivoire</option>\n' +
    '\t<option value="HR">Croatia</option>\n' +
    '\t<option value="CU">Cuba</option>\n' +
    '\t<option value="CW">Curaçao</option>\n' +
    '\t<option value="CY">Cyprus</option>\n' +
    '\t<option value="CZ">Czech Republic</option>\n' +
    '\t<option value="DK">Denmark</option>\n' +
    '\t<option value="DJ">Djibouti</option>\n' +
    '\t<option value="DM">Dominica</option>\n' +
    '\t<option value="DO">Dominican Republic</option>\n' +
    '\t<option value="EC">Ecuador</option>\n' +
    '\t<option value="EG">Egypt</option>\n' +
    '\t<option value="SV">El Salvador</option>\n' +
    '\t<option value="GQ">Equatorial Guinea</option>\n' +
    '\t<option value="ER">Eritrea</option>\n' +
    '\t<option value="EE">Estonia</option>\n' +
    '\t<option value="ET">Ethiopia</option>\n' +
    '\t<option value="FK">Falkland Islands (Malvinas)</option>\n' +
    '\t<option value="FO">Faroe Islands</option>\n' +
    '\t<option value="FJ">Fiji</option>\n' +
    '\t<option value="FI">Finland</option>\n' +
    '\t<option value="FR">France</option>\n' +
    '\t<option value="GF">French Guiana</option>\n' +
    '\t<option value="PF">French Polynesia</option>\n' +
    '\t<option value="TF">French Southern Territories</option>\n' +
    '\t<option value="GA">Gabon</option>\n' +
    '\t<option value="GM">Gambia</option>\n' +
    '\t<option value="GE">Georgia</option>\n' +
    '\t<option value="DE">Germany</option>\n' +
    '\t<option value="GH">Ghana</option>\n' +
    '\t<option value="GI">Gibraltar</option>\n' +
    '\t<option value="GR">Greece</option>\n' +
    '\t<option value="GL">Greenland</option>\n' +
    '\t<option value="GD">Grenada</option>\n' +
    '\t<option value="GP">Guadeloupe</option>\n' +
    '\t<option value="GU">Guam</option>\n' +
    '\t<option value="GT">Guatemala</option>\n' +
    '\t<option value="GG">Guernsey</option>\n' +
    '\t<option value="GN">Guinea</option>\n' +
    '\t<option value="GW">Guinea-Bissau</option>\n' +
    '\t<option value="GY">Guyana</option>\n' +
    '\t<option value="HT">Haiti</option>\n' +
    '\t<option value="HM">Heard Island and McDonald Islands</option>\n' +
    '\t<option value="VA">Holy See (Vatican City State)</option>\n' +
    '\t<option value="HN">Honduras</option>\n' +
    '\t<option value="HK">Hong Kong</option>\n' +
    '\t<option value="HU">Hungary</option>\n' +
    '\t<option value="IS">Iceland</option>\n' +
    '\t<option value="IN">India</option>\n' +
    '\t<option value="ID">Indonesia</option>\n' +
    '\t<option value="IR">Iran, Islamic Republic of</option>\n' +
    '\t<option value="IQ">Iraq</option>\n' +
    '\t<option value="IE">Ireland</option>\n' +
    '\t<option value="IM">Isle of Man</option>\n' +
    '\t<option value="IL">Israel</option>\n' +
    '\t<option value="IT">Italy</option>\n' +
    '\t<option value="JM">Jamaica</option>\n' +
    '\t<option value="JP">Japan</option>\n' +
    '\t<option value="JE">Jersey</option>\n' +
    '\t<option value="JO">Jordan</option>\n' +
    '\t<option value="KZ">Kazakhstan</option>\n' +
    '\t<option value="KE">Kenya</option>\n' +
    '\t<option value="KI">Kiribati</option>\n' +
    '\t<option value="KP">Korea, Democratic People\'s Republic of</option>\n' +
    '\t<option value="KR">Korea, Republic of</option>\n' +
    '\t<option value="KW">Kuwait</option>\n' +
    '\t<option value="KG">Kyrgyzstan</option>\n' +
    '\t<option value="LA">Lao People\'s Democratic Republic</option>\n' +
    '\t<option value="LV">Latvia</option>\n' +
    '\t<option value="LB">Lebanon</option>\n' +
    '\t<option value="LS">Lesotho</option>\n' +
    '\t<option value="LR">Liberia</option>\n' +
    '\t<option value="LY">Libya</option>\n' +
    '\t<option value="LI">Liechtenstein</option>\n' +
    '\t<option value="LT">Lithuania</option>\n' +
    '\t<option value="LU">Luxembourg</option>\n' +
    '\t<option value="MO">Macao</option>\n' +
    '\t<option value="MK">Macedonia, the former Yugoslav Republic of</option>\n' +
    '\t<option value="MG">Madagascar</option>\n' +
    '\t<option value="MW">Malawi</option>\n' +
    '\t<option value="MY">Malaysia</option>\n' +
    '\t<option value="MV">Maldives</option>\n' +
    '\t<option value="ML">Mali</option>\n' +
    '\t<option value="MT">Malta</option>\n' +
    '\t<option value="MH">Marshall Islands</option>\n' +
    '\t<option value="MQ">Martinique</option>\n' +
    '\t<option value="MR">Mauritania</option>\n' +
    '\t<option value="MU">Mauritius</option>\n' +
    '\t<option value="YT">Mayotte</option>\n' +
    '\t<option value="MX">Mexico</option>\n' +
    '\t<option value="FM">Micronesia, Federated States of</option>\n' +
    '\t<option value="MD">Moldova, Republic of</option>\n' +
    '\t<option value="MC">Monaco</option>\n' +
    '\t<option value="MN">Mongolia</option>\n' +
    '\t<option value="ME">Montenegro</option>\n' +
    '\t<option value="MS">Montserrat</option>\n' +
    '\t<option value="MA">Morocco</option>\n' +
    '\t<option value="MZ">Mozambique</option>\n' +
    '\t<option value="MM">Myanmar</option>\n' +
    '\t<option value="NA">Namibia</option>\n' +
    '\t<option value="NR">Nauru</option>\n' +
    '\t<option value="NP">Nepal</option>\n' +
    '\t<option value="NL">Netherlands</option>\n' +
    '\t<option value="NC">New Caledonia</option>\n' +
    '\t<option value="NZ">New Zealand</option>\n' +
    '\t<option value="NI">Nicaragua</option>\n' +
    '\t<option value="NE">Niger</option>\n' +
    '\t<option value="NG">Nigeria</option>\n' +
    '\t<option value="NU">Niue</option>\n' +
    '\t<option value="NF">Norfolk Island</option>\n' +
    '\t<option value="MP">Northern Mariana Islands</option>\n' +
    '\t<option value="NO">Norway</option>\n' +
    '\t<option value="OM">Oman</option>\n' +
    '\t<option value="PK">Pakistan</option>\n' +
    '\t<option value="PW">Palau</option>\n' +
    '\t<option value="PS">Palestinian Territory, Occupied</option>\n' +
    '\t<option value="PA">Panama</option>\n' +
    '\t<option value="PG">Papua New Guinea</option>\n' +
    '\t<option value="PY">Paraguay</option>\n' +
    '\t<option value="PE">Peru</option>\n' +
    '\t<option value="PH">Philippines</option>\n' +
    '\t<option value="PN">Pitcairn</option>\n' +
    '\t<option value="PL">Poland</option>\n' +
    '\t<option value="PT">Portugal</option>\n' +
    '\t<option value="PR">Puerto Rico</option>\n' +
    '\t<option value="QA">Qatar</option>\n' +
    '\t<option value="RE">Réunion</option>\n' +
    '\t<option value="RO">Romania</option>\n' +
    '\t<option value="RU">Russian Federation</option>\n' +
    '\t<option value="RW">Rwanda</option>\n' +
    '\t<option value="BL">Saint Barthélemy</option>\n' +
    '\t<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>\n' +
    '\t<option value="KN">Saint Kitts and Nevis</option>\n' +
    '\t<option value="LC">Saint Lucia</option>\n' +
    '\t<option value="MF">Saint Martin (French part)</option>\n' +
    '\t<option value="PM">Saint Pierre and Miquelon</option>\n' +
    '\t<option value="VC">Saint Vincent and the Grenadines</option>\n' +
    '\t<option value="WS">Samoa</option>\n' +
    '\t<option value="SM">San Marino</option>\n' +
    '\t<option value="ST">Sao Tome and Principe</option>\n' +
    '\t<option value="SA">Saudi Arabia</option>\n' +
    '\t<option value="SN">Senegal</option>\n' +
    '\t<option value="RS">Serbia</option>\n' +
    '\t<option value="SC">Seychelles</option>\n' +
    '\t<option value="SL">Sierra Leone</option>\n' +
    '\t<option value="SG">Singapore</option>\n' +
    '\t<option value="SX">Sint Maarten (Dutch part)</option>\n' +
    '\t<option value="SK">Slovakia</option>\n' +
    '\t<option value="SI">Slovenia</option>\n' +
    '\t<option value="SB">Solomon Islands</option>\n' +
    '\t<option value="SO">Somalia</option>\n' +
    '\t<option value="ZA">South Africa</option>\n' +
    '\t<option value="GS">South Georgia and the South Sandwich Islands</option>\n' +
    '\t<option value="SS">South Sudan</option>\n' +
    '\t<option value="ES">Spain</option>\n' +
    '\t<option value="LK">Sri Lanka</option>\n' +
    '\t<option value="SD">Sudan</option>\n' +
    '\t<option value="SR">Suriname</option>\n' +
    '\t<option value="SJ">Svalbard and Jan Mayen</option>\n' +
    '\t<option value="SZ">Swaziland</option>\n' +
    '\t<option value="SE">Sweden</option>\n' +
    '\t<option value="CH">Switzerland</option>\n' +
    '\t<option value="SY">Syrian Arab Republic</option>\n' +
    '\t<option value="TW">Taiwan, Province of China</option>\n' +
    '\t<option value="TJ">Tajikistan</option>\n' +
    '\t<option value="TZ">Tanzania, United Republic of</option>\n' +
    '\t<option value="TH">Thailand</option>\n' +
    '\t<option value="TL">Timor-Leste</option>\n' +
    '\t<option value="TG">Togo</option>\n' +
    '\t<option value="TK">Tokelau</option>\n' +
    '\t<option value="TO">Tonga</option>\n' +
    '\t<option value="TT">Trinidad and Tobago</option>\n' +
    '\t<option value="TN">Tunisia</option>\n' +
    '\t<option value="TR">Turkey</option>\n' +
    '\t<option value="TM">Turkmenistan</option>\n' +
    '\t<option value="TC">Turks and Caicos Islands</option>\n' +
    '\t<option value="TV">Tuvalu</option>\n' +
    '\t<option value="UG">Uganda</option>\n' +
    '\t<option value="UA">Ukraine</option>\n' +
    '\t<option value="AE">United Arab Emirates</option>\n' +
    '\t<option value="GB">United Kingdom</option>\n' +
    '\t<option value="US">United States</option>\n' +
    '\t<option value="UM">United States Minor Outlying Islands</option>\n' +
    '\t<option value="UY">Uruguay</option>\n' +
    '\t<option value="UZ">Uzbekistan</option>\n' +
    '\t<option value="VU">Vanuatu</option>\n' +
    '\t<option value="VE">Venezuela, Bolivarian Republic of</option>\n' +
    '\t<option value="VN">Viet Nam</option>\n' +
    '\t<option value="VG">Virgin Islands, British</option>\n' +
    '\t<option value="VI">Virgin Islands, U.S.</option>\n' +
    '\t<option value="WF">Wallis and Futuna</option>\n' +
    '\t<option value="EH">Western Sahara</option>\n' +
    '\t<option value="YE">Yemen</option>\n' +
    '\t<option value="ZM">Zambia</option>\n' +
    '\t<option value="ZW">Zimbabwe</option>'
  );
});