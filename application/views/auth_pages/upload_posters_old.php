<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 03-May-19
 * Time: 17:25
 */
?>
<?php if (empty($_SESSION['keyword_blacklist'])): ?>
<?php if (empty($_SESSION['waitForApprove'])): ?>
<div class="content-wrapper content-upload">
  <form method="post" enctype="multipart/form-data">
    <div class="title">
      Upload poster
      <span>(Maximum file size 50MB; You may use TeX commands.)</span>
    </div>
    <div class="block-checkbox-detail">
      <p>
        If this contribution should be linked to a conference with an unique Conference-Identifier (CID) provided by the
        conference host, please activate the check box below.
      </p>
      <div class="form-item check-terms-item checkbox-register fs-14 checkbox-show">
        <input type="checkbox" class="input show-link-to-conference" name="check_link_to_conference"
               value="1" <?php if (isset($_SESSION['link_to_conference'])) echo 'checked' ?>>
        <label></label>
        <div class="check-terms-item-text">Link contribution to conference (CID)?</div>
      </div>
      <div class="link-to-conference d-none">
        <div class="form-item">
          <label class="form-label label-custom">
            Please enter the CID of the conference
            <span class="req">*</span>
          </label>
          <input type="hidden" id="get_all_cid" value="<?= implode('|,|', $cid); ?>">
          <input type="text" class="input input-custom get-all-cid get-cid-upload" id="get_cid" data-provide="typeahead"
                 name="cid"
                 placeholder="CID" autocomplete="off"
                 value="<?php if (isset($_SESSION['link_to_conference'])) echo set_value('cid', $_SESSION['link_to_conference']) ?>">
          <div class="error"><?php echo form_error('cid') ?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">
            Please choose the session
            <span class="req">*</span>
          </label>
          <select id="get_session_cid" name="session"
                  class="session-link-to-conference input-custom select-custom-none-search">
              <?php if (isset($_SESSION['link_to_conference'])) {
                  foreach ($sessions as $session) {
                      echo '<option value="' . $session['ID'] . '">' . $session['name'] . '</option>';
                  }
              } ?>
          </select>
        </div>
        <p>
          Please be aware, that the conference organizer has to approve, that your video belongs to the conference,
          before
          your contribution will become visible in the responding conference page.
        </p>
      </div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">
        Title
        <span class="req">*</span>
      </label>
      <input type="text" class="input input-custom countCharacters" name="title"
             placeholder="Title"
             value="<?php echo set_value('title') ?>"/>
      <div class="text-after-right">
        <input type="hidden" class="limit-character" value="300">
        You have <span id="charNumber">300</span> characters left
      </div>
      <div class="error"><?php echo form_error('title') ?></div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">
        Affiliation
      </label>
      <input type="text" class="input input-custom countCharacters" name="affiliation"
             placeholder="Affiliation connected with the poster"
             value="<?php echo set_value('affiliation') ?>"/>
      <div class="text-after-right">
        <input type="hidden" class="limit-character" value="150">
        You have <span id="charNumber">150</span> characters left
      </div>
      <div class="error"><?php echo form_error('affiliation') ?></div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">
        Abstract
        <span class="req">*</span>
      </label>
      <textarea type="text" class="input-custom textarea-custom countCharacters" name="caption"
                placeholder="Short description of poster (1000 chars max)"><?php echo set_value('caption') ?></textarea>
      <div class="gr-text-after">
        <div class="text-left">
          Test you TeX commands
          <span class="link TeXModal" data-toggle="modal" data-target="#TeXModal">Here</span>
        </div>
        <div class="text-right">
          <input type="hidden" class="limit-character" value="1000">
          You have <span id="charNumber">1000</span> characters left
        </div>
      </div>
      <div class="error"><?php echo form_error('caption') ?></div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">
        Co-authors
      </label>
      <input type="text" class="input input-custom countCharacters" name="co_authors" placeholder="Co-authors if any"
             value="<?php echo set_value('co_authors') ?>"/>
      <div class="text-after-right">
        <input type="hidden" class="limit-character" value="1000">
        You have <span id="charNumber">1000</span> characters left
      </div>
      <div class="error"><?php echo form_error('co_authors') ?></div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">
        Further reading
      </label>
      <textarea class="input-custom textarea-custom countCharacters" name="further_reading"
                placeholder="Publication with additional information"><?php echo set_value('further_reading') ?></textarea>
      <div class="text-after-right">
        <input type="hidden" class="limit-character" value="250">
        You have <span id="charNumber">250</span> characters left
      </div>
      <div class="error"><?php echo form_error('further_reading') ?></div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">
        Main field of research
        <span class="req">*</span>
      </label>
      <select id="category" class="input-custom select-custom-none-search" name="category">
        <option></option>
          <?php foreach ($categories[0] as $category): ?>
            <option
              <?php if (isset($_SESSION['get_category_id']) && $categoryID == $category['id']) {
                  echo 'selected';
              } ?>
              value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
          <?php endforeach; ?>
      </select>
      <div class="error"><?php echo form_error('category') ?></div>
    </div>
    <div class="form-item">
      <input type="hidden" id="get_id_category"
             value="<?php if (isset($_SESSION['get_category_id'])) echo $categoryID ?>">
      <input type="hidden" id="get_id_subcategory"
             value="<?php if (isset($_SESSION['get_subcategory_id'])) echo $subCategoryID ?>">
      <label class="form-label label-custom">Main research topic<span class="req">*</span></label>
      <select id="sub_category" name="subcategory" class="input-custom select-custom-none-search">
        <option></option>
      </select>
      <div class="error"><?php echo form_error('subcategory') ?></div>
    </div>
    <div class="form-item check-terms-item checkbox-register fs-14">
      <input type="checkbox" id="add_alt_category" class="input" name="check_terms"
             value="1" <?php if (!empty($post['altCategory1']) || !empty($post['altSubCategory1']) || !empty($_SESSION['show_alt_category_item'])) echo 'checked' ?>>
      <label></label>
      <div class="check-terms-item-text">Alternative category?</div>
    </div>
    <div
      class="alt-category <?php if (empty($post['altCategory1']) && empty($_SESSION['show_alt_category_item'])) echo 'd-none' ?>">
      <div class="form-item">
        <label class="form-label label-custom">Alternative field of research</label>
        <select id="alt_category" name="alt_category" class="input-custom select-custom-none-search">
          <option></option>
            <?php foreach ($categories[0] as $category): ?>
              <option
                <?php if (isset($_SESSION['get_alt_category_id']) && $altCategoryID == $category['id']) {
                    echo 'selected';
                } ?>
                value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <div class="error"><?php echo form_error('alt_category') ?></div>
      </div>
      <div class="form-item">
        <input type="hidden" id="get_id_alt_category"
               value="<?php if (isset($_SESSION['get_alt_category_id'])) echo $altCategoryID ?>">
        <input type="hidden" id="get_id_alt_subcategory"
               value="<?php if (isset($_SESSION['get_alt_subcategory_id'])) echo $altSubCategoryID ?>">
        <label class="form-label label-custom">Alternative research topic</label>
        <select id="alt_sub_category" name="alt_subcategory" class="input-custom select-custom-none-search">
          <option></option>
        </select>
        <div class="error"><?php echo form_error('alt_subcategory') ?></div>
      </div>
    </div>
    <div class="form-item">
      <label class="form-label label-custom">Language</label>
      <select name="language" class="input-custom select-custom">
          <?php
          foreach ($languages as $language) : ?>
            <option value="<?= $language ?>"><?= $language ?></option>
          <?php endforeach; ?>
      </select>
      <div class="error"></div>
    </div>
    <div class="form-item check-terms-item checkbox-register">
      <input type="checkbox" class="input" name="registerDOI" value="1">
      <label></label>
      <div class="check-terms-item-text">Register a DOI?</div>
      <div class="error"><?php echo form_error('check_terms') ?></div>
    </div>
    <div class="form-item check-terms-item checkbox-custom checkbox-square">
      <input type="checkbox" class="input" name="sharePublic" value="1">
      <label></label>
      <div class="check-terms-item-text">Share Public</div>
    </div>
    <div class="note-share-public">
      In case the conference has only restricted access, if you do not choose "Share public" option, the content object will only be visible to conference participants. Therefore, we want to encourage to allow for "Share public".
    </div>
    <div class="required-field">
      <label class="form-label label-custom">
        Required fields
        <span class="req">*</span>
      </label>
      <div class="block-file-upload">
        <label class="form-label label-custom">
          File upload
        </label>
        <div class="form-label label-custom">
          Poster file (pdf)
          <span class="req">*</span>
        </div>
        <div class="file-upload-content upload-area">
          <div class="btn-custom btn-border btn-gray btn-upload-file">
            <label for="input_upload_video">Choose File</label>
            <input type="file" name="file" id="input_upload_video"/>
          </div>
          <p id="get_video_name" class="file-name">
            No file chosen
          </p>
          <p class="last-text">
            Drop your file here.
          </p>
        </div>
          <?php if ($this->session->flashdata('upload_post_msg')) : ?>
            <div class="error error-fw-bold mt-3"
                 id="upload_video_msg"><?= $this->session->flashdata('upload_post_msg') ?></div>
          <?php endif; ?>
      </div>
    </div>
    <div class="sm-text-item upload-info" id="video_upload_info">
    </div>
    <div id="video_upload_btn" class="button-bottom d-none">
      <input type="submit" class="add-spinner btn-custom btn-bg green btn-upload ml-auto" value="Upload" name="submit">
    </div>
      <?php if ($this->session->flashdata('upload_post_msg')) : ?>
        <div class="button-bottom btn-reset">
          <a href="<?= base_url('auth/content/poster/upload') ?>" class="add-spinner btn-custom no-child btn-bg green btn-upload ml-auto">Reset</a>
        </div>
      <?php endif; ?>
    <div class="sm-text-item">
      <div class="title-sm-text-item">
        Uploaded posters this session
      </div>
      <div class="content-sm-text-item">
        The following list contains thumbnail images of your uploaded posters in this session.
      </div>
    </div>
    <div class="sm-table-item">
      <div class="title-sm-table-item">
        Posters in your job list
      </div>
      <table class="table table-custom table-preview-upload">
        <thead>
        <tr>
          <th>Preview</th>
          <th>Title</th>
          <th>Date of upload</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $list_post = $this->session->upload_poster;
        if (!empty($list_post)):
            foreach ($list_post as $post):
                ?>
              <tr>
                <td>
                  <div class="img-table">
                    <img src="<?= $post['thumbnail'] ?>" alt="image"/>
                  </div>
                </td>
                <td>
                    <?= $post['title'] ?>
                </td>
                <td>
                    <?= date('d/m/Y', $post['date']) ?>
                </td>
              </tr>
            <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
    <div id="video_upload_info"></div>
    <div id="video_upload_btn" class="button-bottom d-none">
      <input type="submit" class="add-spinner btn-custom btn-bg green btn-upload ml-auto" value="Upload" name="submit">
    </div>
  </form>
</div>
<div class="modal sm-modal" id="TeXModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Please test your TeX formulas below
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="form-item">
          <label class="form-label label-custom">
            Your TeX formula
          </label>
          <textarea id="teXFormulaInput" class="input-custom textarea-custom" placeholder="Make sure to use $...$ or $$...$$"></textarea>
        </div>
        <button class="btn btn-custom btn-bg green btn-tex-it" type="button" name="TeXit" id="button_TeXit">
          TeX it
        </button>
        <div class="blank" id="formula"></div>
      </div>
      <div class="sm-modal-footer">
        <p>
          If you keep encountering problems with your TeX formula please have a look at the
          <a class="link" href="http://docs.mathjax.org/en/latest" target="_blank">MathJax documentation</a>
        </p>
        <p>
          One common problem may be that for line breaks you need to use"\\\\" compared to "\\" in normal TeX formulas.
        </p>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
  <div class="block-white-p40-100">
    You have registered with an email address that does not seem to belong to an institution, university or company.
    Until we approve your address, you may not upload any content due to quality and securtiy measures. If you have any
    further questions, please contact us.
  </div>
<?php endif; ?>
<?php else: ?>
  <div class="block-white-p40-100">
    <p>You had failed to upload this poster due to our terms and conditions. Please upload a new poster or contact our team for more information.</p>
    <a class="link mt-2" href="<?= base_url('auth/content/poster/upload') ?>">Upload a new poster here.</a>
  </div>
<?php endif; ?>