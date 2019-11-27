<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 16-May-19
 * Time: 17:18
 */
?>
<!-- registration step 1 -->
<div class="section-detail-conference">
  <div class="block-white">
    <div class="block-conference-content">
      <div class="title">
        Registration for conference
      </div>
      <div class="form-item">
        <label class="label-custom">
          Please enter the CID of the conference, you want to register for and click "Next"
          <span class="req">*</span>
        </label>
        <input type="text" class="input input-custom" />
        <div class="error"></div>
      </div>
      <div class="gr-btn-bottom d-flex">
        <div class="btn-custom btn-bg gray btn-back">
          <a>
            Back
          </a>
        </div>
        <div class="btn-custom btn-bg green btn-next ml-auto">
          <a>
            Next
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- registration step 2 -->
<div class="section-registration-conference">
  <div class="title big-font-normal">
    Registration for conference
  </div>
  <div class="sm-block block-white register-conference-block">
    <div class="form-item">
      <label class="label-custom">
        Please enter the CID of the conference, you want to register for and click "Next"
        <span class="req">*</span>
      </label>
      <input type="text" class="input input-custom" />
      <div class="error"></div>
    </div>
    <div class="sub-title">
      Registration is available.
    </div>
    <div class="sm-text-item">
      <div class="title-sm-text-item">
        Comments by conference host:
      </div>
      <div class="content-sm-text-item">
        XuanScienceCon2019
      </div>
    </div>
    <div class="sm-text-item">
      <div class="title-sm-text-item">
        Personal information, that will be submitted to the conference organizer:
      </div>
      <div class="content-sm-text-item">
        <div class="title">
          Uwe Zell
        </div>
        <div class="text-item">
          <span>Email</span>
          uwezell@free.de
        </div>
        <div class="text-item">
          <span>Affiliation</span>
          ZL Associates
        </div>
        <div class="text-item">
          <span>Department</span>
          
        </div>
        <div class="text-item">
          <span>Streetname/ Number</span>
          ZL Associates
        </div>
        <div class="text-item">
          <span>City</span>
          
        </div>
        <div class="text-item">
          <span>State</span>
          
        </div>
        <div class="text-item">
          <span>Postal code</span>
          0
        </div>
         <div class="text-item">
          <span>Country</span>
        </div>
      </div>
    </div>
    <p>
      The following address information is going to be printed on the conference receip. This information can not be changed after the receipt has been issued. Please edit the information below.
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
      <input type="text" placeholder="University/Institute/Company" class="input-custom">
    </div>
    <div class="form-item">
      <label class="label-custom">
        Streetname/Number
        <span class="req">*</span>
      </label>
      <textarea class="textarea-custom" placeholder="Street name and number of university/Institute/Company"></textarea>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Postal code
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="Postal code" class="input-custom">
    </div>
    <div class="form-item">
      <label class="label-custom">
        City
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="City" class="input-custom">
    </div>
    <div class="form-item">
      <label class="label-custom">
        State
      </label>
      <input type="text" placeholder="State" class="input-custom">
    </div>
    <div class="form-item">
      <label class="label-custom">
        Country
        <span class="req">*</span>
      </label>
      <select class="input-custom select-custom">
        <option></option>
      </select>
    </div>
    <div class="sm-text-item">
      <div class="title-sm-text-item">
        I wil attend the conference dinner (special fees may apply)
      </div>
      <div class="content-sm-text-item">
        <div class="gr-checkbox d-flex">
          <div class="form-item check-terms-item checkbox-register">
            <input type="checkbox" class="input" name="check_terms" value="1">
            <label></label>
            <div class="check-terms-item-text">Yes</div>
            <div class="error"></div>
          </div>
          <div class="form-item check-terms-item checkbox-register">
            <input type="checkbox" class="input" name="check_terms" value="1">
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
    <div class="form-item">
      <label class="label-custom">
        Information
      </label>
      <textarea class="textarea-custom" placeholder="Special diet, etc.">
      </textarea>
    </div>
    <div class="form-item">
      <label class="label-custom">
        I agree that my name will be published as a participant on the conference web page:
        <span class="req">*</span>
      </label>
      <div class="gr-checkbox d-flex">
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input" name="check_terms" value="1">
          <label></label>
          <div class="check-terms-item-text">Yes</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input" name="check_terms" value="0">
          <label></label>
          <div class="check-terms-item-text">No</div>
          <div class="error"></div>
        </div>
      </div>
    </div>
    <div class="gr-btn-bottom d-flex">
      <div class="btn-custom btn-bg gray btn-back">
        <a>Back</a>
      </div>
      <div class="btn-custom btn-bg green btn-register ml-auto">
        <a>Register</a>
      </div>
    </div>
  </div>
</div>
<h3>Registration for conference</h3>
<form method="post" id="register_conference_form">
  <div class="step-1">
    <input type="hidden" id="get_all_cid" value="<?= implode('|,|', $list_cid); ?>">
    <input style="margin-bottom: 10px" type="text" class="get-all-cid" id="get_cid_register_conference"
           autocomplete="off" data-provide="typeahead" name="cid" placeholder="CID"
           value="<?php echo set_value('cid', $cid) ?>">
    <div style="color: red" class="error error-message"><?php echo form_error('cid') ?></div>
    <div id="btn_next_register_conference" class="btn btn-info">Next</div>
  </div>
  <div class="step-2">
    Registration is available.<br>
    Personal information, that will be submitted to the conference organizer:<br>
    <h4><?= $user->firstName ?> <?= $user->lastName ?></h4>
    <p>E-Mail: <b><?= $user->email ?></b></p>
    <p>Affiliation: <b><?= $user->affiliation ?></b></p>
    <p>Department: <b><?= $user->department ?></b></p>
    <p>Streetname/Number: <b><?= $user->address ?></b></p>
    <p>City: <b><?= $user->city ?></b></p>
    <p>State: <b><?= $user->state ?></b></p>
    <p>Postal code: <b><?= $user->postalCode ?></b></p>
    <p>Country: <b><?= $user->country ?></b></p>
    <input type="hidden" id="get_affiliation_register_conference" value="<?= $user->affiliation ?>">
    <input type="hidden" id="get_address_register_conference" value="<?= $user->address ?>">
    <input type="hidden" id="get_city_register_conference" value="<?= $user->city ?>">
    <input type="hidden" id="get_state_register_conference" value="<?= $user->state ?>">
    <input type="hidden" id="get_postalCode_register_conference" value="<?= $user->postalCode ?>">
    <input type="hidden" id="get_country_register_conference" value="<?= $user->country ?>">

    The following address information is going to be printed on the conference receipt. This information can not be
    changed after the receipt has been issued. Please edit the information below.
    <br/>
    <label class="control-label" style="text-align: right; padding-top: 0px;">Please use the address information from my
      profile </label>
    <input type="checkbox" id="use_info_profile_register_conference">
    <br>
    <label class="form-label">Name<span class="req">*</span> </label>
    <input style="margin-bottom: 10px" type="text" id="set_affiliation_register_conference" class="input" name="recName"
           placeholder="Postal code" value="<?php echo set_value('recName') ?>">
    <div style="color: red" class="error"><?php echo form_error('recName') ?></div>
    <br/>
    <label class="form-label">Streetname/Number<span class="req">*</span> </label>
    <textarea style="margin-bottom: 10px" id="set_address_register_conference" class="input" name="recStreet"
              placeholder="Address of university/institute/company"><?php echo set_value('recStreet') ?></textarea>
    <div style="color: red" class="error"><?php echo form_error('recStreet') ?></div>
    <br/>
    <label class="form-label">Postal code<span class="req">*</span> </label>
    <input style="margin-bottom: 10px" type="text" id="set_postalCode_register_conference" class="input"
           name="recPostalCode" placeholder="Postal code" value="<?php echo set_value('recPostalCode') ?>">
    <div style="color: red" class="error"><?php echo form_error('recPostalCode') ?></div>
    <br/>
    <label class="form-label">City<span class="req">*</span> </label>
    <input style="margin-bottom: 10px" type="text" id="set_city_register_conference" class="input" name="recCity"
           placeholder="City" value="<?php echo set_value('recCity') ?>">
    <div style="color: red" class="error"><?php echo form_error('recCity') ?></div>
    <br/>
    <label class="form-label">State: </label>
    <input style="margin-bottom: 10px" type="text" id="set_state_register_conference" class="input" name="recState"
           placeholder="State" value="<?php echo set_value('recState') ?>">
    <br/>
    <label class="form-label">Country<span class="req">*</span> </label>
    <select style="margin-bottom: 10px" name="recCountry" id="set_country_register_conference">
      <option value="option1">option1</option>
      <option value="option2">option2</option>
      <option value="option3">option3</option>
      <option value="vietnam">Vietnam</option>
    </select>
    <div style="color: red" class="error"><?php echo form_error('recCountry') ?></div>
    <br>
    <label class="control-label" style="text-align: right; padding-top: 0px;">I will attend the conference dinner
      (special fees may apply)</label>
    <input type="radio" name="attendConfDinner" value="1">Yes
    <input type="radio" name="attendConfDinner" value="0" checked>No
    <br>
    <p>Any special information that the conference host needs to know about, e.g. special diet, etc.?</p>
    <label class="form-label">Information:</label>
    <textarea style="margin-bottom: 10px" class="input" id="address" name="address"
              placeholder="Special diet, etc."><?php echo set_value('address') ?></textarea>
    <br/>
    <label class="control-label" style="text-align: right; padding-top: 0px;">I agree that my name will be published as
      a participant on the conference web page:</label>
    <input type="radio" name="publishName" value="1" checked>Yes
    <input type="radio" name="publishName" value="0">No
    <br>
    <p>Please click "Register" now to complete the registration process.</p>
    <input style="margin-bottom: 10px" type="submit" class="button" value="Register" name='submit'>
  </div>
</form>