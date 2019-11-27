<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 17-May-19
 * Time: 17:05
 */
?>
<div class="section-submit-abstract block-white">
  <div class="title">
    Abstract Submission for CID: XuanScienceCon2019
  </div>
  <form class="submit-abstract-form">
    <div class="form-item">
      <label class="label-custom">
        Please select, if you submit a talk or a poster
        <span class="req">*</span>
      </label>
      <div class="checkbox-inline d-flex">
        <div class="form-item check-terms-item checkbox-register">
          <input type="checkbox" class="input" name="check_terms" value="1">
          <label></label>
          <div class="check-terms-item-text">Talk</div>
          <div class="error"></div>
        </div>
        <div class="form-item check-terms-item checkbox-register">
          <input type="checkbox" class="input" name="check_terms" value="1">
          <label></label>
          <div class="check-terms-item-text">Poster</div>
          <div class="error"></div>
        </div>
      </div>
      <div class="error"></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Title
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="Abstract title
      " class="input-custom"/>
      <div class="error"></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Author
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="Author
      " class="input-custom"/>
      <div class="error"></div>
    </div>  
    <div class="form-item">
      <label class="label-custom">
        Co Authors
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="Co Authors
      " class="input-custom"/>
      <div class="error"></div>
    </div>  
    <div class="form-item">
      <label class="label-custom">
        Affiliations
      </label>
      <input type="text" placeholder="Affiliations
      " class="input-custom"/>
      <div class="error"></div>
    </div>  
    <div class="form-item">
      <label class="label-custom">
        Abstract text
        <span class="req">*</span>
      </label>
      <textarea class="textarea-custom" placeholder="The text of your abstract"></textarea>
      <div class="error"></div>
    </div> 
    <div class="gr-btn-bottom d-flex">
      <div class="btn-custom btn-bg gray btn-back">
        <a href="#">
          Back
        </a>
      </div>
      <div class="btn-custom btn-bg green btn-submit ml-auto">
        <a href="#">
          Submit
        </a>
      </div>
    </div> 
  </form>
</div>
<h3>Abstract Submission for CID: <?= $cid ?></h3>
<h4>Abstract Submission is available.</h4>
<form method="post">
  <label class="control-label" style="text-align: right; padding-top: 0px;">Please select, if you submit a talk or a
    poster<span class="req">*</span></label>
  <input type="radio" name="choose_talk_poster" value="talk" checked>
  <input type="radio" name="choose_talk_poster" value="poster">
  <br>
  <label class="form-label">Title<span class="req">*</span> </label>
  <input style="margin-bottom: 10px" type="text" class="input" name="title" placeholder="Title"
         value="<?php echo set_value('title') ?>">
  <div style="color: red" class="error"><?php echo form_error('title') ?></div>
  <br/>
  <label class="form-label">Author</label>
  <input style="margin-bottom: 10px" type="text" class="input" disabled value="<?= $username ?>">
  <br/>
  <label class="form-label">Co Authors</label>
  <input style="margin-bottom: 10px" type="text" class="input" name="co-authors" placeholder="Co-authors"
         value="<?php echo set_value('co-authors') ?>">
  <br/>
  <label class="form-label">Affiliations</label>
  <input style="margin-bottom: 10px" type="text" class="input" name="affiliations" placeholder="Affiliations"
         value="<?php echo set_value('affiliations') ?>">
  <br/>
  <label class="form-label">Abstract text<span class="req">*</span> </label>
  <textarea style="margin-bottom: 10px" class="input" name="text"
            placeholder="The text of your abstract"><?php echo set_value('text') ?></textarea>
  <div style="color: red" class="error"><?php echo form_error('text') ?></div>
  <br/>
  <input style="margin-bottom: 10px" type="submit" class="button" value="Submit" name='submit'>
</form>
