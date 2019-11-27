<?php
if($active_project_sidebar != "OrderPID" && $active_project_sidebar != "Project List" &&
 $active_project_sidebar != "Project info order pid"){
  if(!empty($listProject)){
 foreach($listProject as $variable => $value){
  if($value->identifierPID == $identifier){
     $this->session->set_userdata('projectName', $value->pid);
     $active_project = $value->pid;
  }
 }
}
?>
<div class="project-sidebar desktop-item">
  <div class="project-sidebar-item">
    <?php
        if($this->session->userdata('projectName')):
          $projectName =$this->session->userdata('projectName')?>
    <button class="btn dropdown-toggle active-custom" type="button" title="<?= $projectName?>"
            id="dropdownMenuProject"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <?= $projectName?>
    </button>
        <?php endif;?>
    <div class="dropdown-menu dropdown-height-scroll" aria-labelledby="dropdownMenuProject">
        <div class="btn-custom btn-border green btn-order-pid">
            <a href="<?= base_url('auth/project/work-package/order-pid') ?>">Order PID</a>
		    </div>
        <?php
          if(!empty($listProject)){
          foreach($listProject as $variable => $value){ ?>
        <a title="<?= $value->pid ?>"
            class="dropdown-item project-name project-sidebar-item-content block-white <?php if ($active_project == $value->pid) {
                echo ' active-custom';
            } ?> limitTextMenu" href="<?= base_url('auth/project/'.$value->identifierPID.'/work-package/') ?>"><?= $value->pid ?>
        </a>
      <?php } }?>
    </div>
    <a class="project-sidebar-item-content block-white <?php if ($active_project_sidebar == 'Work Package') echo ' active-custom';?> add-spinner" href="<?= base_url('auth/project/'.$identifier.'/work-package') ?>">Work Packages</a>
    <a class="project-sidebar-item-content block-white <?php if ($active_project_sidebar == 'Documents') echo ' active-custom';?>" href="<?= base_url('auth/project/'.$identifier.'/documents') ?>">Documents</a>
    <a class="project-sidebar-item-content block-white <?php if ($active_project_sidebar == 'Calendar') echo ' active-custom';?>" href="<?= base_url('auth/project/'.$identifier.'/calendar') ?>">Calendar</a>
    <a class="project-sidebar-item-content block-white <?php if ($active_project_sidebar == 'Member') echo ' active-custom';?>" href="<?= base_url('auth/project/'.$identifier.'/member') ?>">Members</a>
  </div>
</div>
<div class="project-sidebar mobile-item">
  <div class="profile-sidebar-item">
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_project_sidebar']) && ($active_project_sidebar == 'Project ABC')) : ?>
          <button class="btn dropdown-toggle active-custom limitTextMenu" type="button" id="dropdownMenuProfileButton"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $active_project_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu dropdown-sidebar-mobile dropdown-height-scroll" aria-labelledby="dropdownMenuProfileButton">
        <div class="block-btn-oder-pid">
          <div class="btn-custom btn-border green btn-order-pid">
              <a href="<?= base_url('auth/project/work-package/order-pid') ?>">Order PID</a>
          </div>
        </div>
           <?php
          if(!empty($listProject)){
          foreach($listProject as $variable => $value){ ?>
        <a  title="<?= $value->pid ?>"
            class="dropdown-item project-name project-sidebar-item-content block-white <?php if ($active_project == $value->pid) {
                echo ' active-custom';
            } ?> limitTextMenu" href="<?= base_url('auth/project/'.$identifier.'/work-package/') ?>"><?= $value->pid ?>
        </a>
      <?php } }?>
      </div>
    </div>
  </div>
  <div class="profile-sidebar-item">
    <div class="dropdown dropdown-menu-custom">
        <?php
        if (isset($_SESSION['active_project_sidebar']) && ($active_project_sidebar == 'Work Package'|| $active_project_sidebar == 'Documents'|| $active_project_sidebar == 'Calendar' || $active_project_sidebar == 'Member')) : ?>
          <button class="btn dropdown-toggle active-custom limitTextMenu" type="button" id="dropdownMenuProfileButton"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= $active_project_sidebar ?>
          </button>
        <?php else : ?>
          <button class="btn dropdown-toggle" type="button" id="dropdownMenuProfileButton" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
            Choose
          </button>
        <?php endif; ?>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuProfileButton">
        <a
          class="dropdown-item project-sidebar-item-content block-white limitTextMenu <?php if ($active_project_sidebar == 'Work Package') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/project/'.$identifier.'/work-package') ?> add-spinner">Work Packages</a>
        <a
          class="dropdown-item project-sidebar-item-content block-white limitTextMenu <?php if ($active_project_sidebar == 'Documents') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/project/'.$identifier.'/documents') ?>">Documents</a>
           <a
          class="dropdown-item project-sidebar-item-content block-white limitTextMenu <?php if ($active_project_sidebar == 'Calendar') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/project/'.$identifier.'/calendar') ?>">Calendar</a>
           <a
          class="dropdown-item project-sidebar-item-content block-white limitTextMenu <?php if ($active_project_sidebar == 'Member') {
              echo ' active-custom';
          } ?>" href="<?= base_url('auth/project/'.$identifier.'/member') ?>">Members</a>
      </div>
    </div>
  </div>
</div>
<?php } ?>
