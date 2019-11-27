<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 06-May-19
 * Time: 15:53
 */
?>
<div class="section-post-page content-wrapper">
  <div class="top-content">
    <div class="title-section">
      Video Content
    </div>
    <div class="sm-menu-tab">
      <ul class="menu-post-detail">
        <a class="menu-view" href="<?= base_url('auth/content/video/' . $post['id']) ?>">
          Video
        </a>
        <a class="menu-edit active" href="<?= base_url('auth/content/video/edit/' . $post['id']) ?>">
          Edit
        </a>
        <a class="menu-request-doi" href="<?= base_url('auth/content/video/request-doi/' . $post['id']) ?>">
          Request DOI
        </a>
        <a class="menu-link-to-conference" href="<?= base_url('auth/content/video/link-to-conference/' . $post['id']) ?>">
          Link to conference
        </a>
      </ul>
      <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
      <button class="btn btn-popup delete-menu btn-delete-video">
        Delete Video
      </button>
    </div>
  </div>
  <div class="block-white tab-menu-content edit-tab-content">
    <div class="post-page-info">
      <div class="title">
        <?= $post['title'] ?>
      </div>
      <form method="post">
        <div class="form-item">
          <label class="form-label label-custom">
            Title
            <span class="req">*</span>
          </label>
          <input type="text" class="input input-custom"
                 name="video_title" placeholder="Title"
                 value="<?php echo set_value('video_title', $post['title']) ?>"/>
          <div class="error"><?php echo form_error('video_title') ?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">
            Affiliation
          </label>
          <input type="text" class="input input-custom" name="video_affiliation"
                 placeholder="Affiliation connected with the video"
                 value="<?php echo set_value('video_affiliation', $post['videoAffiliation']) ?>">
          <div class="error"><?php echo form_error('video_affiliation') ?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">
            Caption
            <span class="req">
              *
            </span>
          </label>
          <textarea class="input textarea-custom" name="video_caption"><?php echo set_value('video_caption',
                $post['caption']) ?></textarea>
          <div class="text-after">
            Test you TeX commands
            <span class="link TeXModal" data-toggle="modal" data-target="#TeXModal">Here</span>
          </div>
          <div class="error"><?php echo form_error('video_caption') ?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">
            Co-authors
          </label>
          <input type="text" class="input input-custom" name="video_co_authors" placeholder="Co-authors if any"
                 value="<?php echo set_value('video_co_authors', $post['coAuthors']) ?>">
          <div class="error"><?php echo form_error('video_co_authors') ?></div>
        </div>
        <div class="form-item textarea-item">
          <label class="form-label label-custom">
            Further reading
          </label>
          <textarea class="input textarea-custom" name="video_further_reading"
                    placeholder="Publication with Additional information"><?php echo set_value('video_further_reading',
                $post['furtherReading']) ?></textarea>
          <div class="error"><?php echo form_error('video_further_reading') ?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">Main field of research 
            <span class="req">*</span>
          </label>
          <select id="category" name="category" class="input-custom select-custom-none-search">
              <?php foreach ($categories[0] as $category): ?>
                <option
                  <?php if ($post['category'] == $category['id'] || (isset($_SESSION['get_category_id']) && $categoryID == $category['id'])) {
                      echo 'selected';
                  } ?>
                  value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
              <?php endforeach; ?>
          </select>
          <div class="error"><?php echo form_error('category') ?></div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">
            Main research topic
            <span class="req">*</span>
          </label>
          <input type="hidden" id="get_id_category" value="<?php if (isset($_SESSION['get_category_id'])) {
              echo $categoryID;
          } else {
              echo $post['category'];
          } ?>">
          <input type="hidden" id="get_id_subcategory" value="<?php if (isset($_SESSION['get_subcategory_id'])) {
              echo $subCategoryID;
          } else {
              echo $post['subcategory'];
          } ?>">
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
                    <?php if ($post['altCategory1'] == $category['id'] || (isset($_SESSION['get_alt_category_id']) && $altCategoryID == $category['id'])) {
                        echo 'selected';
                    } ?>
                    value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <div class="error"><?php echo form_error('alt_category') ?></div>
          </div>
          <div class="form-item">
            <input type="hidden" id="get_id_alt_category" value="<?php if (isset($_SESSION['get_alt_category_id'])) {
                echo $altCategoryID;
            } else {
                echo $post['altCategory1'];
            } ?>">
            <input type="hidden" id="get_id_alt_subcategory" value="<?php if (isset($_SESSION['get_alt_subcategory_id'])) {
                echo $altSubCategoryID;
            } else {
                echo $post['altSubCategory1'];
            } ?>">
            <label class="form-label label-custom">Alternative research topic</label>
            <select id="alt_sub_category" name="alt_subcategory" class="input-custom select-custom-none-search">
              <option></option>
            </select>
            <div class="error"><?php echo form_error('alt_subcategory') ?></div>
          </div>
        </div>
        <div class="form-item">
          <label class="form-label label-custom">
            Additional informations
          </label>
          <textarea class="input textarea-custom" name="video_additional_information"
                    placeholder="Additional information about the movie"><?php echo set_value('video_additional_information',
                $post['description']) ?></textarea>
          <div class="text-after">
            Test you TeX commands
            <span class="link TeXModal" data-toggle="modal" data-target="#TeXModal">Here</span>
          </div>
          <div class="error"><?php echo form_error('video_additional_information') ?></div>
        </div>
        <?php if ($checkLinkToConference): ?>
          <div class="share-public-option">
            <div class="form-item check-terms-item fs-14 checkbox-custom">
              <input id="sharePublic" type="radio" class="input" name="sharePublic" <?php if ($post['public'] == 1) echo "checked"; ?>>
              <label></label>
              <div class="check-terms-item-text">Share Public</div>
            </div>
            <div class="form-item check-terms-item fs-14 checkbox-custom">
              <input id="closeAccess" type="radio" class="input" name="sharePublic" <?php if ($post['public'] == 0) echo "checked"; ?>>
              <label></label>
              <div class="check-terms-item-text">Restricted Access</div>
            </div>
          </div>
          <div class="note-share-public">
            In case the conference has only restricted access, if you do not choose "Share public" option, the content object will only be visible to conference participants. Therefore, we want to encourage to allow for "Share public".
          </div>
        <?php endif; ?>
        <div class="form-item gr-button">
          <label class="form-label label-custom">
            Required fields
            <span class="req">
              *
            </span>
          </label>
          <div class="d-flex">
            <input type="submit" class="add-spinner btn-custom btn-bg green btn-save" value="Save changes" name="submit">
            <button type="button" class="btn-custom btn-bg gray btn-cancel btn-redirect" data-link="<?= base_url('auth/content/video/' . $post['id']) ?>">
              Cancel
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete video
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title">
            <?= $post['title'] ?>
        </div>
        <div class="modal-description">
        </div>
      </div>
      <div class="sm-modal-footer d-none">
        <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
        <button class="btn-custom btn-bg green btn-delete btn-delete-video-confirm" data-dismiss="modal">Delete video
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deleteStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete video
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="modal-description">
        </div>
      </div>
    </div>
  </div>
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