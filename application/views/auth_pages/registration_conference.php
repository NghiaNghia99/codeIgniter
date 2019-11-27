<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 09-May-19
 * Time: 09:57
 */
?>
<h3>Registration of CID: <?= $cid->cid ?></h3>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="CID" value="<?= $cid->cid ?>">
  <label class="form-label">Type of Scientific Event</label>
  <input style="margin-bottom: 10px" type="text" class="input" placeholder="" value="<?= $cid->typeOfConference ?>"
         disabled>
  <br/>
  <label class="form-label">Conference title<span class="req">*</span></label>
  <input style="margin-bottom: 10px" type="text" class="input" name="confTitle" placeholder=""
         value="<?php echo set_value('confTitle') ?>">
  <div style="color: red" class="error"><?php echo form_error('confTitle') ?></div>
  <br/>
  <label class="form-label">Series of conference<span class="req">*</span></label>
  <input style="margin-bottom: 10px" type="text" class="input" name="confSeries"
         placeholder="Series of conference, e.g 7th Example Conference" value="<?php echo set_value('confSeries') ?>">
  <div style="color: red" class="error"><?php echo form_error('confSeries') ?></div>
  <br/>
  <label class="form-label">Organizing institution(s)<span class="req">*</span></label>
  <input style="margin-bottom: 10px" type="text" class="input" name="organizingInstitutions" placeholder=""
         value="<?php echo set_value('organizingInstitutions') ?>">
  <div style="color: red" class="error"><?php echo form_error('organizingInstitutions') ?></div>
  <br/>
  <label class="form-label">Location of conference --- City (Country)<span class="req">*</span></label>
  <input style="margin-bottom: 10px" type="text" class="input" name="confLocation" placeholder=""
         value="<?php echo set_value('confLocation') ?>">
  <div style="color: red" class="error"><?php echo form_error('confLocation') ?></div>
  <br/>
  <label class="form-label">Conference start<span class="req">*</span></label>
  <div class="bfh-datepicker" data-name="startDate" data-format="d.m.y" data-min="today">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <input type="text" class="input-medium" readonly>
  </div>
  <br/>
  <label class="form-label">End of conference<span class="req">*</span></label>
  <div class="bfh-datepicker" data-name="endDate" data-format="d.m.y" data-min="today">
    <span class="add-on"><i class="icon-calendar"></i></span>
    <input type="text" class="input-medium" readonly>
  </div>
  <br/>
  <label class="form-label">Conference/Workshop objectives<span class="req">*</span></label>
  <textarea style="margin-bottom: 10px" type="text" name="abstract"
            placeholder="Make it easy to understand"><?php echo set_value('abstract') ?></textarea>
  <div style="color: red" class="error"><?php echo form_error('abstract') ?></div>
  <br/>
  <label class="form-label">Main field of research of conference<span class="req">*</span></label>
  <select style="margin-bottom: 10px" id="category" name="category">
    <option></option>
      <?php foreach ($categories[0] as $category) {
          echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
      }
      ?>
  </select>
  <div style="color: red" class="error"><?php echo form_error('category') ?></div>
  <br/>
  <label class="form-label">Main research topic of conference<span class="req">*</span></label>
  <select style="margin-bottom: 10px" id="sub_category" name="subcategory">
    <option></option>
  </select>
  <div style="color: red" class="error"><?php echo form_error('subcategory') ?></div>
  <br/>
  <label class="control-label"
         style="text-align: right; padding-top: 0px;">Alternative category? </label>
  <input type="checkbox" id="add_alt_category" name="add_alt_category">
  <br>
  <div class="alt-category d-none">
    <label class="form-label">Alternative field of research</label>
    <select style="margin-bottom: 10px" id="alt_category" name="alt_category">
      <option></option>
        <?php foreach ($categories[0] as $category) {
            echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
        }
        ?>
    </select> <br/>
    <label class="form-label">Alternative research topic</label>
    <select style="margin-bottom: 10px" id="alt_sub_category" name="alt_subcategory">
      <option></option>
    </select> <br/>
  </div>
  <br/> <br/>
  <input style="margin-bottom: 10px" type="submit" class="button" value="Registration" name='submit'>
</form>