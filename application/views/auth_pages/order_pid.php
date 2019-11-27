<div class="section-order-pid content-wrapper">
  <div class="block-white tab-menu-content block-order-pid">
    <p>
    You can use our brand new project management toolbox for an early bird fee of only Price 1499 Euro (approx. 1 621 USD) now. All you need is to fill out the following form and click the "Order now" button. The payment will be handled with paypal, but you don't have to be a paypal customer to be able to place your order.
    </p>
    <form method="post" enctype="multipart/form-data" >
      <div class="form-item">
        <label class="form-label label-custom">
          PID <span class="req">*</span>
          <span class="unique">
          (Unique project identifier, e.g. "myScienceCon2017")
          </span> 
        </label>
        <input type="text" class="input-custom countCharacters" name="pid" placeholder="PID"
               value="<?php echo set_value('pid') ?>"/>
        <div class="text-after-right">
          <input type="hidden" class="limit-character" value="30">
          You have <span id="charNumber">30</span> characters left
        </div>
        <div class="error"><?php echo form_error('pid') ?></div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Contact first name
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="contactFirstName" placeholder="Contact first name"
               value="<?php echo set_value('contactFirstName') ?>"/>
        <div class="error">
            <?php echo form_error('contactFirstName') ?>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Contact last name
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="contactLastName" placeholder="Contact last name"
               value="<?php echo set_value('contactLastName') ?>"/>
        <div class="error">
            <?php echo form_error('contactLastName') ?>

        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Contact Email
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="contactEMail" placeholder="Contact email"
               value="<?php echo set_value('contactEMail') ?>"/>
        <div class="error"><?php echo form_error('contactEMail') ?></div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Billing affiliation
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="billingAffiliation" placeholder="Billing affiliation"
               value="<?php echo set_value('billingAffiliation') ?>"/>
        <div class="error">
            <?php echo form_error('billingAffiliation') ?>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Billing street
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="billingStreet" placeholder="Billing street"
               value="<?php echo set_value('billingStreet') ?>">
        <div class="error"><?php echo form_error('billingStreet') ?></div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">Billing street Nr
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="billingStreetNr" placeholder="Billing street Nr"
               value="<?php echo set_value('billingStreetNr') ?>">
        <div class="error">
            <?php echo form_error('billingStreetNr') ?>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Billing city
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="billingCity" placeholder="Billing city"
               value="<?php echo set_value('billingCity') ?>">
        <div class="error">
            <?php echo form_error('billingCity') ?>
        </div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Billing postal code
          <span class="req">*</span>
        </label>
        <input type="text" class="input-custom" name="billingPostalCode" placeholder="Billing postal code"
               value="<?php echo set_value('billingPostalCode') ?>"/>
        <div class="error"><?php echo form_error('billingPostalCode') ?></div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Billing country
          <span class="req">*</span>
        </label>
        <select name="billingCountry" id="country" class="input-custom select-custom">
        </select>
        <div class="error"><?php echo form_error('billingCountry') ?></div>
      </div>
      <div class="form-item">
        <label class="form-label label-custom">
          Billing state
        </label>
        <select name="billingState" id="state" class="input-custom select-custom">
        </select>
        <div class="error"><?php echo form_error('billingState') ?></div>
      </div>
      <button class="btn-custom btn-bg green btn-order  add-spinner" type="submit">
        Order now
      </button>
    </form>
  </div>
</div>