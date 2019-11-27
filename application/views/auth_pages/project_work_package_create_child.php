<?php 
// title, description_document, assignee, cccountable, estimated-time, story-points, startDate, endDate, version, progress, priority, category, Budget, video
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
    if(!empty($idProject))
    $linkProject =  "/api/v3/projects/".$idProject;
    //print_r($list_member);die;
?>
<div class="section-project section-project-list section-project-new-task section-project-new-child">
  <div class="project-layout-list-sort">
    <div class="d-flex">
      <div class="p-2 mr-auto">
        <a class="layout-list-status">New</a>
        <div class="btn-list-sort">
          <button class="btn btn-custom btn-choose-task" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuCreate"><?php
              if($type == 1){
                  echo "Task";
              }
              if($type == 2){
                  echo "Milestone";
              }
              if($type == 3){
                  echo "Phase";
              }
              if($type == 4){
                  echo "Feature";
              }
              if($type == 5){
                  echo "Epic";
              }
              if($type == 6){
                  echo "User story";
              }
              if($type == 7){
                  echo "Bug";
              }
              ?></button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuCreate">
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/1') ?>"><span class="dot dark-blue"></span> Task
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/2') ?>"><span class="dot green"></span> Milestone
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/3') ?>"><span class="dot light-blue"></span> Phase
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/4') ?>"><span class="dot feature-dot"></span> Feature
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/5') ?>"><span class="dot yellow"></span> Epic
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/6') ?>"><span class="dot grey"></span> User story
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white" href="<?= base_url('auth/project/'.$identifier.'/work-package/create-child/'.$idTask.'/7') ?>"><span class="dot red"></span> Bug
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="project-layout-content project-layout-new-task">
    <form method="post" enctype="multipart/form-data">
      <div class="body-content">
        <div class="form-item">
          <label class="form-label label-custom">
            Title
          </label>
          <input type="text" class="input-custom" name="subject" placeholder="Click to enter title"/>
          <div class="error"><?php echo form_error('subject') ?></div>
        </div> <!-- form-item -->
        <div class="form-item form-item-description">
          <label class="form-label label-custom">
            Description
          </label>
          <textarea name="description_document" placeholder="Click to enter description"></textarea>
        </div>
        <div class="form-item">
          <div class="block-overview">
            <div class="block-overview-title">
              people
            </div>
            <div class="row">
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Assignee
                  </label>
                  <select name="assignee" class="form-control select-custom">
                    <option></option>
                      <?php
                      if(!empty($list_memberships && !empty($linkProject))){
                          foreach($list_memberships as $varMember => $valMember){
                              if($valMember->_links->project->href == $linkProject){
                                  foreach($list_member as $variable => $value){
                                      if($valMember->_links->principal->title == $value->name){
                                          ?>
                                        <option value ="<?= $value->id?>"><?= $value->name ?></option>
                                      <?php }
                                  }
                              }
                          }
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Accountable
                  </label>
                  <select name="accountable" class="form-control select-custom">
                    <option></option>
                      <?php
                      if(!empty($list_memberships && !empty($linkProject))){
                          foreach($list_memberships as $varMember => $valMember){
                              if($valMember->_links->project->href == $linkProject){
                                  foreach($list_member as $variable => $value){
                                      if($valMember->_links->principal->title == $value->name){
                                          ?>
                                        <option value ="<?= $value->id?>"><?= $value->name ?></option>
                                      <?php }
                                  }
                              }
                          }
                      }
                      ?>
                  </select>
                </div>
              </div>
            </div>
            <hr>
          </div>
        </div>
        <div class="form-item">
          <div class="block-overview">
            <div class="block-overview-title">
              TIME
            </div>
            <div class="row">
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Estimated time (hour)
                  </label>
                  <input type="number" class="input-custom" name="estimatedTime" placeholder="Click to enter estimated time" min="0" />
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Remaining Hours
                  </label>
                  <input type="number" class="input-custom" name="remaining-hours" placeholder="Click to enter Remaining Hours" min="0" />
                  <!-- <select name="estimatedTime" class="form-control select-custom">
                      <option value="PT8H"> 0 </option>
                  </select> -->
                </div>
              </div>
            </div>
            <hr>
          </div>
        </div>
        <div class="form-item">
          <div class="block-overview">
            <div class="block-overview-title">
              DETAILS
            </div>
            <div class="row">
                <?php
                if($type != 2){
                    ?>
                  <div class="col-md-6 select-col">
                    <div class="form-item input-group datetime-picker dash">
                      <label class="form-label label-custom ">
                        Start date
                      </label>
                      <input class="input-custom input-medium datepicker" name="startDate" data-date-format="dd.mm.yyyy" placeholder="Start date" id="startDate" value="" readonly>
                      <div class="error"></div>
                    </div>
                  </div>
                  <div class="col-md-6 select-col">
                    <div class="form-item input-group datetime-picker">
                      <label class="form-label label-custom ">
                        Finish date
                      </label>
                      <input class="input-custom input-medium datepicker" name="endDate" data-date-format="dd.mm.yyyy" placeholder="Finish date" id="endDate" value=""  readonly>
                      <div class="error"></div>
                    </div>
                  </div>
                    <?php
                }
                else
                {
                    ?>
                  <div class="col-md-6 select-col">
                    <div class="form-item input-group datetime-picker">
                      <label class="form-label label-custom ">
                        Date
                      </label>
                      <input class="input-custom input-medium datepicker" name="dateMileStone" data-date-format="dd.mm.yyyy" id="endDate" value="0" readonly>
                      <div class="error"></div>
                    </div>
                  </div>
                    <?php
                }
                ?>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Version
                  </label>
                  <select name="version" class="form-control select-custom">
                    <option>Sprint 1</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Progress (%)
                  </label>
                  <select name="percentageDone" class="form-control select-custom">
                      <?php
                      for($optionProgress = 0; $optionProgress<101;$optionProgress+=5){
                          ?>

                        <option value = "<?=$optionProgress ?>"><?=$optionProgress ?></option>
                      <?php } ?>

                  </select>
                  <div class="error"><?php echo form_error('percentageDone') ?></div>
                </div>

              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Priority
                  </label>
                  <select name="priority" class="form-control select-custom">
                    <option value = "7">Low</option>
                    <option value = "8">Normal</option>
                    <option value = "9">High</option>
                    <option value = "10">Immediate</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Category
                  </label>
                  <select name="category" class="form-control select-custom">
                    <option>Acceptance Test</option>
                  </select>
                </div>
              </div>
            </div>
            <hr>
          </div>
        </div>
        <div class="form-item">
          <div class="block-overview">
            <div class="block-overview-title">
              Costs
            </div>
            <div class="row">
              <div class="col-12 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Budget
                  </label>
                  <input type="text" class="input-custom" placeholder="-" disabled>
                </div>
              </div>
            </div>
          </div>
          <hr style="border: 0">
        </div>
        <div class="form-item form-item-attachment">
          <label class="form-label label-custom">
            File
          </label>
          <input type="hidden" class="usernameLogin" value="<?= $username ?>">
          <div class="block-file block-file-list">
          </div>
        </div>
        <div class="form-item block-file-upload">
          <div class="file-upload-content upload-area">
            <div class="btn-custom btn-border btn-gray btn-upload-file">
              <label for="input_upload_attachment">Choose File</label>
              <input type="file" name="file" id="input_upload_attachment">
            </div>
            <p class="last-text upload-area-text">
              Drop your file here.
            </p>
          </div>
        </div>
      </div>
      <div class="footer-content">
        <div class="btn-toolbar">
          <div class="btn-group mr-2" type="submit">
            <button class="btn-custom btn-bg green btn-create add-spinner">
              Create
            </button>
          </div>
          <div class="btn-group">
            <div class="btn-custom btn-bg gray btn-cancel">
              <a href="<?= base_url('auth/project/' . $identifier . '/work-package') ?>">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>