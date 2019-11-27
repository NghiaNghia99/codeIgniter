<?php
?>
<div class="section-report">
    <div class="title big-font-normal">Report</div>
    <form method="post" class="block-white section-report-content">
        <div class="section-report-content-title">What is wrong with this <?= $postType ?>?</div>
        <div class="section-report-content-item">
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Sexual content">
                <label></label>
                <div class="checkbox-custom-text">Sexual content</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Violent or repulsive content">
                <label></label>
                <div class="checkbox-custom-text">Violent or repulsive content</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Hateful or abusive content">
                <label></label>
                <div class="checkbox-custom-text">Hateful or abusive content</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Harmful dangerous content">
                <label></label>
                <div class="checkbox-custom-text">Harmful dangerous content</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Child abuse">
                <label></label>
                <div class="checkbox-custom-text">Child abuse</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Promotes terrorism">
                <label></label>
                <div class="checkbox-custom-text">Promotes terrorism</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Spam or misleading">
                <label></label>
                <div class="checkbox-custom-text">Spam or misleading</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Infringes my rights">
                <label></label>
                <div class="checkbox-custom-text">Infringes my rights</div>
            </div>
            <div class="checkbox-custom">
                <input type="radio" class="input" name="report_item" value="Captions issue">
                <label></label>
                <div class="checkbox-custom-text">Captions issue</div>
            </div>
        </div>
        <div class="group-button d-flex justify-content-between">
          <div class="btn-custom btn-bg gray"><a href="<?= base_url($postType . '/' . $postID) ?>">Back</a></div>
          <input type="submit" class="add-spinner btn-custom btn-bg green" value="Report">
        </div>
      <div class="error error-fw-bold mt-3"><?php echo form_error('report_item')?></div>
    </form>
</div>