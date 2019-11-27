<?php 
// title, description_document, assignee, cccountable, estimated-time, story-points, startDate, endDate, version, progress, priority, category, Budget, video
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
    if(!empty($idProject))
    $linkProject =  "/api/v3/projects/".$idProject;
    $responseTask = $this->session->userdata('responseTask');


    // print_r($responseTask);die;
?>
<div class="section-project section-project-list">
    <div class="scroll-x">
        <div class="project-layout-list-sort">
            <div class="d-flex">
                <div class="p-2 mr-auto">
                    <a class="layout-list-status">New <?php 
                    if(!empty($responseTask->_embedded->type->name)){
                        echo $responseTask->_embedded->type->name;
                    }

                    ?></a>
                </div>
            </div>
        </div>
        <hr>
        <div class="project-layout-content project-layout-new-task">
            <form method="post" action ="<?php echo base_url('auth/project/'.$identifier.'/work-package/new-task/'.$responseTask->_embedded->type->id) ?>">
                <div class="body-content">
                    <div class="form-item">
                        <label class="form-label label-custom">
                            Title
                        </label>
                        <input type="hidden" value="if(!empty($responseTask->_embedded->type->id)){
                        echo $responseTask->_embedded->type->id;
                    }" >
                        <input type="text" class="input-custom" name="subject" value="<?php
                         if(!empty($responseTask->subject))
                         echo $responseTask->subject; ?>" />
                        <div class="error"><?php echo form_error('subject') ?></div>
                    </div> <!-- form-item -->
                                        <div class="form-item">
                        <label class="form-label label-custom">
                            Description
                        </label>
                        <textarea name="description_document" >
                            <?php  
                      if(!empty($responseTask->description->raw))
                       echo $responseTask->description->raw ?>
                        </textarea>
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
                                            <option value="<?php
                                              if(!empty($responseTask->_embedded->assignee->id))
                                              echo  $responseTask->_embedded->assignee->id ?>"><?php
                                              if(!empty($responseTask->_embedded->assignee->name))
                                              echo $responseTask->_embedded->assignee->name ?>
                                              </option>
                                            <?php 
                                            if(!empty($list_memberships && !empty($linkProject))){
                                        foreach($list_memberships as $varMember => $valMember){
                                            if($valMember->_links->project->href == $linkProject){
                                                foreach($list_member as $variable => $value){
                                                    if($valMember->_links->principal->title == $value->name && $responseTask->_embedded->assignee->name != $value->name){
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
                                            <option value="<?php if(!empty($responseTask->_embedded->responsible->id)){ echo $responseTask->_embedded->responsible->id;}?>"><?php if(!empty($responseTask->_embedded->responsible->name)){ echo $responseTask->_embedded->responsible->name;} ?></option>
                                            <?php 
                                            if(!empty($list_memberships && !empty($linkProject))){
                                        foreach($list_memberships as $varMember => $valMember){
                                            if($valMember->_links->project->href == $linkProject){
                                                foreach($list_member as $variable => $value){
                                                    if($valMember->_links->principal->title == $value->name && $responseTask->_embedded->responsible->name != $value->name ){
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
                                        <input type="number" class="input-custom" name="estimated-time" placeholder="Click to enter estimated time" value="<?php 
                                          if(!empty($responseTask->estimatedTime)){
                                              $str = $responseTask->estimatedTime;
                                                $str = str_replace("P","",$str);
                                                $str = str_replace("T","",$str);
                                                $str = str_replace("H","",$str);
                                              if(!strpos($str,"D")){
                                                echo (int)$str;
                                              }
                                              else{
                                                $str = explode("D", $str);
                                                $hour = $str[0] * 24;
                                                if($str[1] != null){
                                                 $hour = $hour + $str[1];
                                                }
                                                 echo (int)$hour;
                                              }
                                              }  
                                              ?>" 
                                              min="0" />
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                            Remaining Hours
                                        </label>
                                        <input type="number" class="input-custom" name="remaining-hours" placeholder="Click to enter Remaining Hours" 
                                        value="<?php 
                                          if(!empty($responseTask->remainingTime)){
                                              $str = $responseTask->remainingTime;
                                                $str = str_replace("P","",$str);
                                                $str = str_replace("T","",$str);
                                                $str = str_replace("H","",$str);
                                              if(!strpos($str,"D")){
                                                echo (int)$str;
                                              }
                                              else{
                                                $str = explode("D", $str);
                                                $hour = $str[0] * 24;
                                                if($str[1] != null){
                                                 $hour = $hour + $str[1];
                                                }
                                                 echo (int)$hour;
                                              }
                                              }  
                                              ?>" 
                                        min="0" />
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
                                    if(!empty($responseTask->_embedded->type->name) && $responseTask->_embedded->type->name != "Milestone"){
                                                
                                ?>
                                <div class="col-md-6 select-col">
                                    <div class="form-item input-group datetime-picker dash">
                                        <label class="form-label label-custom ">
                                        Start date
                                        </label>
                                        <input class="input-custom input-medium datepicker" name="startDate" data-date-format="dd.mm.yyyy" id="startDate"  value="<?php
                                        if((!empty($responseTask->startDate))){
                                        echo date("d.m.Y",strtotime($responseTask->startDate));
                                        }; ?>">
                                        <div class="error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item input-group datetime-picker">
                                        <label class="form-label label-custom ">
                                            Finish date
                                        </label>
                                        <input class="input-custom input-medium datepicker" name="endDate" data-date-format="dd.mm.yyyy" id="endDate" value="<?php
                                        if((!empty($responseTask->dueDate))){
                                        echo date("d.m.Y",strtotime($responseTask->dueDate));
                                        }; ?>"
                                        >
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
                                        <input class="input-custom input-medium datepicker" name="dateMileStone" data-date-format="dd.mm.yyyy" id="endDate" readonly value="<?php 
                                            if(!empty($responseTask->date)){
                                                echo $responseTask->date;
                                            }
                                        ?>">
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
                                            <option value="<?php 
                                            if(!empty($responseTask->percentageDone)){
                                                echo $responseTask->percentageDone; }
                                            else {
                                                echo "0";
                                            }
                                            ?>"><?php 
                                            if(!empty($responseTask->percentageDone)){
                                                echo $responseTask->percentageDone; }
                                            else {
                                                echo "0";
                                            }
                                            ?>
                                                
                                            </option>

                                            <?php 
                                                for($optionProgress = 0; $optionProgress<101;$optionProgress+=5){
                                                  if($optionProgress != $responseTask->percentageDone){
                                            ?>

                                            <option value = "<?=$optionProgress ?>"><?=$optionProgress ?></option>
                                            <?php }
                                            } 
                                            ?>
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
                                        <?php 
                                        if(!empty($responseTask->_embedded->priority->name)){
                                          ?>
                                        <option value = "<?= $responseTask->_embedded->priority->id ?>"><?= $responseTask->_embedded->priority->name ?></option>
                                      <?php } 
                                        for($optionPriority = 7; $optionPriority<11;$optionPriority++){
                                              if($optionPriority != $responseTask->_embedded->priority->id){
                                      ?>
                                        <option value = "<?=$optionPriority ?>"><?php 
                                        if($optionPriority == 7) echo "Low";
                                        else if($optionPriority == 8) echo "Normal";
                                        else if($optionPriority == 9) echo "High";
                                        else if($optionPriority == 10) echo "Immediate";
                                        ?></option>
                                        <?php } } ?>
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
                            <div class="form-item">
                                <label class="form-label label-custom">
                                    Budget
                                </label>
                                <select name="Budget" class="form-control select-custom">
                                    <option>100000</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="form-item block-file-upload">
                        <div class="block-overview">
                            <div class="form-item">
                                <label class="form-label label-custom">
                                    File
                                </label>
                                <div class="file-upload-content upload-area">
                                    <div class="btn-custom btn-border btn-gray btn-upload-file">
                                        <span>Choose File</span>
                                        <input type="file" name="attachFile" id="input_upload_video">
                                    </div>
                                    <p id="get_video_name" class="file-name">
                                        No file chosen
                                    </p>
                                    <p class="last-text upload-area-text">
                                        Drop your file here.
                                    </p>
                                </div>
                            </div>
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
                            <button class="btn-custom btn-bg green btn-cancel">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>