<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 17-May-19
 * Time: 17:05
 */
?>
<div class="section-submit-abstract block-white">
    <?php if (!empty($checkAbstractActive)): ?>
  <div class="title">
    Abstract Submission for CID: <?= $conference['CID'] ?>
  </div>
  <form class="submit-abstract-form">
    <div class="form-item">
      <label class="label-custom">
        Please select, if you submit a talk or a poster
        <span class="req">*</span>
      </label>
      <div class="checkbox-inline d-flex">
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input abstract-talk" name="choose_talk_poster" value="talk" checked>
          <label></label>
          <div class="check-terms-item-text">Talk</div>
        </div>
        <div class="form-item check-terms-item checkbox-register">
          <input type="radio" class="input abstract-poster" name="choose_talk_poster" value="poster">
          <label></label>
          <div class="check-terms-item-text">Poster</div>
        </div>
      </div>
      <div class="error"></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Title
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="Abstract title" class="input-custom abstract-title" name="title">
      <div class="error"></div>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Author
        <span class="req">*</span>
      </label>
      <input type="text" placeholder="Author" class="input-custom" disabled value="<?= $username ?>"/>
    </div>
    <div class="form-item">
      <label class="label-custom">
        Co Authors
      </label>
      <input type="text" placeholder="Co Authors" class="input-custom abstract-co-authors" name="co-authors">
    </div>
    <div class="form-item">
      <label class="label-custom">
        Affiliations
      </label>
      <input type="text" placeholder="Affiliations" class="input-custom abstract-affiliations" name="affiliations">
    </div>
    <div class="form-item">
      <label class="label-custom">
        Abstract text
        <span class="req">*</span>
      </label>
      <textarea class="textarea-custom abstract-text" placeholder="The text of your abstract" name="text"></textarea>
      <div class="error"></div>
    </div>
    <div class="gr-btn-bottom d-flex">
      <div class="btn-custom btn-bg gray btn-back">
        <a  href="<?= base_url('conference/' . $conference['id']) ?>">
          Back
        </a>
      </div>
      <div class="btn-custom btn-bg green btn-submit ml-auto <?php if (!empty($checkSpamAbstract)) echo 'disabled'; ?>">
        <a class="btn-submit-abstract-conference">
          Submit
        </a>
      </div>
    </div>
  </form>
    <?php else: ?>
      <div>The abstract submission is closed.</div>
    <?php endif; ?>
</div>
<input type="hidden" id="get_id_conference" value="<?= $conference['id'] ?>">
<input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">
