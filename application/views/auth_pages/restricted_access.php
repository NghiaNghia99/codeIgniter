<?php
$relativeDir = base_url('/uploads/userfiles/' . $conference['userID'] . '/conferences/' . $conference['id']);

if (!empty($conference['filenameBanner_original'])) {
    $ext_ = pathinfo($conference['filenameBanner_original']);
    $ext = $ext_['extension'];
    $banner_file = $relativeDir . '/ConferenceBanner.' . $ext . '?' . time();
} else {
    $banner_file = base_url('/assets/images/img-conference.png');
}
?>
<div class="section-post-page section-restrict-access">
  <div class="top-content">
    <div class="sm-menu-tab">
      <ul>
        <a href="#" class="active">
          Access rules
        </a>
      </ul>
    </div>
    <div class="block-white tab-menu-content restricted-access-tab-content">
      <div class="img-conference">
        <img src="<?= $banner_file ?>" alt="image"/>
      </div>
      <div class="text-before">
        <div class="title">
            <?= $conference['confTitle'] ?>
        </div>
        <div class="sub-title">
          Conference access rules
        </div>
        <p>
          Manage your access rules for the content of the conferences. You may offer the option of Restricted Access
          meaning that only the conference participants will be able to view the conference contribution.
        </p>
        <p>
          If you activate the Restricted Access option, the participants will be able to choose between Open Access and
          Restricted Access when uploading their conference contribution. The default publication rule is Open Access.
        </p>
        <p>
          Your conference is set to
            <?php if ($conference['allowClosedAccess'] != 1): ?>
              <span class="status-access open">Open Access</span>
            <?php else: ?>
              <span class="status-access restrict">Restricted Access</span>
            <?php endif; ?>
        </p>
      </div>
      <div id="accordion" class="restricted-accordion">
          <?php if ($conference['allowClosedAccess'] != 1): ?>
            <div id="btnShowCollapseRestrict" class="btn-custom btn-bg green btn-manage" data-toggle="collapse"
                 data-target="#collapse-restricted"
                 aria-expanded="true" aria-controls="collapse-restricted">
              <a>
                Manage access rules
              </a>
            </div>
          <?php else: ?>
            <div class="btn-custom btn-bg green btn-manage disabled">
              <a>
                Manage access rules
              </a>
            </div>
          <?php endif; ?>
          <?php if ($conference['allowClosedAccess'] != 1): ?>
            <div id="collapse-restricted" class="collapse" data-parent="#accordion">
              <form class="collapse-content" method="post">
                <div class="title small-title">
                  Access Rules <?= $conference['confTitle'] ?>
                </div>
                <div class="sm-gr-text">
                  <p>
                    Please select which access rules, Open Access or Restricted Access, you would like to offer for your
                    conference participant.
                  </p>
                  <p>
                    Please be aware that once the Restricted Access option is booked for your conference you may not
                    change
                    it back to Open Access. You will need to contact our support!
                  </p>
                </div>
                <div class="gr-checkbox">
                  <span>Please choose:</span>
                  <div class="form-item check-terms-item checkbox-register">
                    <input type="radio" class="input" name="restrict"
                           value="0" checked>
                    <label></label>
                    <div class="check-terms-item-text">Open Access</div>
                  </div>
                  <div class="form-item check-terms-item checkbox-register">
                    <input type="radio" class="input" name="restrict"
                           value="1">
                    <label></label>
                    <div class="check-terms-item-text">Restricted Access</div>
                  </div>
                </div>
                <div class="gr-button d-flex">
                  <div class="btn-custom btn-bg dark-green btn-cancel">
                    <a id="closeCollapseRestrict">
                      Cancel
                    </a>
                  </div>
                  <input type="submit" class="add-spinner btn-custom btn-bg green btn-save" name="submit" value="Save">
                </div>
              </form>
            </div>
          <?php endif; ?>
      </div>
    </div>
  </div>
</div>