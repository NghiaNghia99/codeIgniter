<?php
if (!empty($idProject)) {
    $linkProject = "/api/v3/projects/" . $idProject;
}
$responseTask = $this->session->userdata('responseTask');
//$relations = array();

//if (!empty($responseTask->_links->children)) {
//    foreach ($responseTask->_links->children as $variableChild => $valueChild) {
//        $url = str_replace("/api/v3/", "", $valueChild->href);
//        $url = $this->config->config['api_url'] . $url;
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_USERPWD, $api_key);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//        $responseChild = curl_exec($ch);
//        curl_close($ch);
//
//        $responseChild = json_decode($responseChild);
//        array_push($relations, $responseChild);
//    }
//}
//foreach ($relations as $key => $relation){
//    var_dump($relation->id);
//    var_dump($relation->_embedded->type->id);
//    var_dump($relation->_embedded->type->name);
//    var_dump($relation->_embedded->status->id);
//    var_dump($relation->_embedded->status->name);
//    var_dump($relation->subject);
//    var_dump($relation);
//    die;
//}
?>
<div class="section-project section-project-calendar section-calendar-detail">
  <input type="hidden" id="work_package" value="<?= $responseTask->id ?>">
  <input type="hidden" id="work_package_identifier" value="<?= $identifier ?>">
  <div class="scroll-x">
    <div class="project-layout-list-sort">
      <div class="d-flex">
        <div class="mr-auto btn-list-sort">
          <div class="prev-page">
            <span class="icon icon-arrow-down"></span>
          </div>
          <div class="btn-list-sort">
            <button class="btn btn-custom btn-bg btn-create btn-update-type" id="btnShowMenuType">
              <span id="type_icon" class="dot <?php
              if ($responseTask->_embedded->type->id == 1) {
                  echo 'dark-blue';
              } elseif ($responseTask->_embedded->type->id == 2) {
                  echo 'green';
              } elseif ($responseTask->_embedded->type->id == 3) {
                  echo 'light-blue';
              }elseif ($responseTask->_embedded->type->id == 4) {
                  echo 'feature-dot';
              } elseif ($responseTask->_embedded->type->id == 5) {
                  echo 'yellow';
              } elseif ($responseTask->_embedded->type->id == 6) {
                  echo 'grey';
              } elseif ($responseTask->_embedded->type->id == 7) {
                  echo 'red';
              }
              ?>"></span>
              <span id="type_name" class="type-name"><?= $responseTask->_embedded->type->name ?></span>
            </button>
            <div class="dropdown-menu-type">
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot dark-blue" data-id="1"
                 data-type="Task"><span class="dot dark-blue"></span> Task
              </a>
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot green" data-id="2"
                 data-type="Milestone"><span class="dot green"></span> Milestone
              </a>
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot light-blue" data-id="3"
                 data-type="Phase"><span class="dot light-blue"></span> Phase
              </a>
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot feature-dot" data-id="4"">
              <span class="dot feature-dot"></span> Feature
              </a>
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot yellow" data-id="5"
                 data-type="Epic"><span
                  class="dot yellow"></span> Epic
              </a>
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot grey" data-id="6"
                 data-type="User story"><span class="dot grey"></span> User story
              </a>
              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                 data-work_packageID="<?= $responseTask->id ?>" data-icon="dot red" data-id="7"
                 data-type="Bug"><span class="dot red"></span> Bug
              </a>
            </div>
          </div>
          <span class="name-task text-nowrap"><?php if (!empty($idTask)) {
                  echo $responseTask->subject;
              } ?>
            </span>
        </div>
        <div class="btn-list-sort">
          <a class="btn btn-custom btn-bg btn-views <?php if ($checkWatched) { echo 'watched'; } ?>"
             title="<?php if ($checkWatched) { echo 'Unwatch work package'; } else { echo 'Watch work package';} ?>">
            <span class="icon icon-views btn-watcher <?php if ($checkWatched) {
                echo 'remove';
            } ?>" <?php if ($checkWatched) {
                echo 'data-id="' . $checkWatched . '"';
            } ?>></span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="project-layout-task-detail">
    <div class="section-attended-project section-task-detail-left">
      <div class="body-content">
        <div class="block-action">
          <div class="btn-group">
            <button class="btn btn-sm btn-action btn-update-status <?php
            if ($responseTask->_embedded->status->id == 1) {
                echo 'new-dot';
            } elseif ($responseTask->_embedded->status->id == 7) {
                echo 'in-progress-dot';
            } elseif ($responseTask->_embedded->status->id == 17) {
                echo 'need-review-dot';
            } elseif ($responseTask->_embedded->status->id == 18) {
                echo 'reopen-dot';
            } elseif ($responseTask->_embedded->status->id == 5) {
                echo 'done-dot';
            } elseif ($responseTask->_embedded->status->id == 13) {
                echo 'closed-dot';
            }
            ?>" id="btnShowMenuStatus">
              <span id="status_name" class="status-name"><?= $responseTask->_embedded->status->name ?></span>
            </button>
            <div class="dropdown-menu-status">
              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                 data-work_packageID="<?= $responseTask->id ?>"
                 data-style="btn btn-sm btn-action btn-update-status new-dot" data-id="1" data-status="New"><span
                  class="dot new-dot"></span> New
              </a>
              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                 data-work_packageID="<?= $responseTask->id ?>"
                 data-style="btn btn-sm btn-action btn-update-status in-progress-dot" data-id="7"
                 data-status="In progress"><span class="dot in-progress-dot"></span> In progress
              </a>
              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                 data-work_packageID="<?= $responseTask->id ?>"
                 data-style="btn btn-sm btn-action btn-update-status need-review-dot" data-id="17"
                 data-status="In progress"><span class="dot need-review-dot"></span> Need Review
              </a>
              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                 data-work_packageID="<?= $responseTask->id ?>"
                 data-style="btn btn-sm btn-action btn-update-status reopen-dot" data-id="18"
                 data-status="In progress"><span class="dot reopen-dot"></span> ReOpen
              </a>
              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                 data-work_packageID="<?= $responseTask->id ?>"
                 data-style="btn btn-sm btn-action btn-update-status done-dot" data-id="16"
                 data-status="In progress"><span class="dot done-dot"></span> Done
              </a>
              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                 data-work_packageID="<?= $responseTask->id ?>"
                 data-style="btn btn-sm btn-action btn-update-status closed-dot" data-id="13" data-status="Closed"><span
                  class="dot closed-dot"></span> Closed
              </a>
            </div>
          </div>
          <span>1: Created by <?= $responseTask->_embedded->author->name ?>. Last updated on <?php
              $date = date_create($responseTask->_embedded->project->updatedAt);
              echo date_format($date, "m/d/Y h:i A"); ?>.</span>
        </div>
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="type-id" id="type_id" value="<?= $responseTask->_embedded->type->id ?>">
          <input type="hidden" name="status-id" id="status_id" value="<?= $responseTask->_embedded->status->id ?>">
          <div class="block-overview">
            <hr/>
            <div class="block-overview-title">
              Subject
            </div>
            <div class="row">
              <div class="col-12 select-col">
                <div class="form-item">
                  <input type="text" class="input-custom" name="subject" placeholder="Click to enter subject"
                         value="<?php
                         if (!empty($responseTask->subject))
                             echo $responseTask->subject ?>"/>
                </div>
              </div>
            </div>
          </div>
          <div class="block-overview">
            <br>
            <div class="block-overview-title">
              description
            </div>
            <div class="row">
              <div class="col-12 select-col">
                <div class="form-item">
                  <input type="text" class="input-custom" name="description" placeholder="Click to enter description"
                         value="<?php
                         if (!empty($responseTask->description->raw))
                             echo $responseTask->description->raw ?>"/>
                </div>
              </div>
            </div>
          </div>
          <div class="block-overview">
            <hr/>
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
                    if (!empty($responseTask->_embedded->assignee->id))
                        echo $responseTask->_embedded->assignee->id ?>"><?php
                        if (!empty($responseTask->_embedded->assignee->name))
                            echo $responseTask->_embedded->assignee->name ?>
                    </option>
                      <?php
                      if (!empty($list_memberships) && !empty($linkProject)) {
                          foreach ($list_memberships as $varMember => $valMember) {
                              if ($valMember->_links->project->href == $linkProject) {
                                  foreach ($list_member as $variable => $value) {
                                      $href = str_replace('/api/v3/users/', '', $valMember->_links->principal->href);
                                      if ($href == $value->id && $responseTask->_embedded->assignee->id != $value->id) {
                                          ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
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
                    <option value="<?php if (!empty($responseTask->_embedded->responsible->id)) {
                        echo $responseTask->_embedded->responsible->id;
                    } ?>"><?php if (!empty($responseTask->_embedded->responsible->name)) {
                            echo $responseTask->_embedded->responsible->name;
                        } ?></option>
                      <?php
                      if (!empty($list_memberships) && !empty($linkProject)) {
                          foreach ($list_memberships as $varMember => $valMember) {
                              if ($valMember->_links->project->href == $linkProject) {
                                  foreach ($list_member as $variable => $value) {
                                      $href = str_replace('/api/v3/users/', '', $valMember->_links->principal->href);
                                      if ($href == $value->id && $responseTask->_embedded->responsible->id != $value->id) {
                                          ?>
                                        <option value="<?= $value->id ?>"><?= $value->name ?></option>
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
          </div>
          <div class="block-overview">
            <hr/>
            <div class="block-overview-title">
              TIME
            </div>
            <div class="row">
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Estimated time (hour)
                  </label>
                  <input type="number" class="input-custom" name="estimated-time"
                         placeholder="Click to enter estimated time" value="<?php
                  if (!empty($responseTask->estimatedTime)) {
                      $str = $responseTask->estimatedTime;
                      $str = str_replace("P", "", $str);
                      $str = str_replace("T", "", $str);
                      $str = str_replace("H", "", $str);
                      if (!strpos($str, "D")) {
                          echo (int)$str;
                      } else {
                          $str = explode("D", $str);
                          $hour = $str[0] * 24;
                          if ($str[1] != null) {
                              $hour = $hour + $str[1];
                          }
                          echo (int)$hour;
                      }
                  }
                  ?>"
                         <?php
                         if (!empty($checkChildren)){
                           echo " disabled ";
                         }
                         ?>
                         min="0"/>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Remaining Hours
                  </label>
                  <input type="number" class="input-custom" name="remaining-hours"
                         placeholder="Click to enter Remaining Hours"
                         value="<?php
                         if (!empty($responseTask->remainingTime)) {
                             $str = $responseTask->remainingTime;
                             $str = str_replace("P", "", $str);
                             $str = str_replace("T", "", $str);
                             $str = str_replace("H", "", $str);
                             if (!strpos($str, "D")) {
                                 echo (int)$str;
                             } else {
                                 $str = explode("D", $str);
                                 $hour = $str[0] * 24;
                                 if ($str[1] != null) {
                                     $hour = $hour + $str[1];
                                 }
                                 echo (int)$hour;
                             }
                         }
                         ?>"
                    <?php
                    if (!empty($checkChildren)){
                        echo " disabled ";
                    }
                    ?>
                         min="0"/>
                </div>
              </div>
            </div>
          </div>
          <div class="block-overview">
            <hr/>
            <div class="block-overview-title">
              DETAILS
            </div>
            <div class="row">
                <?php
                if (!empty($responseTask->_embedded->type->name) && $responseTask->_embedded->type->name != "Milestone") {

                    ?>
                  <div class="col-md-6 select-col">
                    <div class="form-item input-group datetime-picker dash">
                      <label class="form-label label-custom ">
                        Date
                      </label>
                      <input class="input-custom input-medium datepicker" name="startDate" data-date-format="dd.mm.yyyy"
                             id="startDate" value="<?php
                      if ((!empty($responseTask->startDate))) {
                          echo date("d.m.Y", strtotime($responseTask->startDate));
                      }; ?>" readonly <?php if (!empty($checkChildren)) echo 'disabled'; ?>>
                      <div class="error"></div>
                    </div>
                  </div>
                  <div class="col-md-6 select-col">
                    <div class="form-item input-group datetime-picker">
                      <label class="form-label label-custom ">
                        &nbsp;
                      </label>
                      <input class="input-custom input-medium datepicker " name="endDate" data-date-format="dd.mm.yyyy"
                             id="endDate" value="<?php
                      if ((!empty($responseTask->dueDate))) {
                          echo date("d.m.Y", strtotime($responseTask->dueDate));
                      }; ?>" readonly <?php if (!empty($checkChildren)) echo 'disabled'; ?>>
                      <div class="error"></div>
                    </div>
                  </div>
                    <?php
                } else {
                    ?>
                  <div class="col-md-6 select-col">
                    <div class="form-item input-group datetime-picker">
                      <label class="form-label label-custom ">
                        Date
                      </label>
                      <input class="input-custom input-medium datepicker" name="dateMileStone"
                             data-date-format="dd.mm.yyyy" id="endDate" readonly value="<?php
                      if (!empty($responseTask->date)) {
                          echo date("d.m.Y", strtotime($responseTask->date));
                      }
                      ?>" readonly <?php if (!empty($checkChildren)) echo 'disabled'; ?>>
                      <div class="error"></div>
                    </div>
                  </div>
                    <?php
                }
                ?>
                <?php if (!empty($versionsArr)): ?>
                  <div class="col-md-6 select-col">
                    <div class="form-item">
                      <label class="form-label label-custom">
                        Version
                      </label>
                      <select name="version" class="form-control select-custom-none-search">
                        <option value="">-</option>
                          <?php foreach ($versionsArr as $key => $version) :
                              ?>
                            <option value="<?= $version['href'] ?>"
                              <?php
                              if (substr($version['href'], 17) == $responseTask->_embedded->version->id)
                                echo "selected"
                              ?>
                            ><?= $version['name'] ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                <?php endif; ?>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Progress (%)
                  </label>
                  <select name="percentageDone" class="form-control select-custom" <?php if (!empty($checkChildren)) echo 'disabled'; ?>>
                      <?php for ($optionProgress = 0; $optionProgress < 101; $optionProgress+=5): ?>
                        <option value="<?= $optionProgress ?>"
                          <?php if ($optionProgress == $responseTask->percentageDone) echo "selected"; ?>><?= $optionProgress ?></option>
                      <?php endfor; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Priority
                  </label>
                  <select name="priority" class="form-control select-custom">
                      <?php
                      if (!empty($responseTask->_embedded->priority->name)) {
                          ?>
                        <option
                          value="<?= $responseTask->_embedded->priority->id ?>"><?= $responseTask->_embedded->priority->name ?></option>
                      <?php }
                      for ($optionPriority = 7; $optionPriority < 11; $optionPriority++) {
                          if ($optionPriority != $responseTask->_embedded->priority->id) {
                              ?>
                            <option value="<?= $optionPriority ?>"><?php
                                if ($optionPriority == 7) {
                                    echo "Low";
                                } else {
                                    if ($optionPriority == 8) {
                                        echo "Normal";
                                    } else {
                                        if ($optionPriority == 9) {
                                            echo "High";
                                        } else {
                                            if ($optionPriority == 10) {
                                                echo "Immediate";
                                            }
                                        }
                                    }
                                }
                                ?></option>
                          <?php }
                      } ?>
                  </select>
                </div>
              </div>
                <?php if (!empty($categoriesArr)): ?>
                  <div class="col-md-6 select-col">
                    <div class="form-item">
                      <label class="form-label label-custom">
                        Category
                      </label>
                      <select name="category" class="form-control select-custom-none-search">
                        <option value="">-</option>
                          <?php foreach ($categoriesArr as $key => $category) :
                              ?>
                            <option value="<?= $category['href'] ?>"
                              <?php
                              if (substr($category['href'], 19) == $responseTask->_embedded->category->id)
                                  echo "selected"
                              ?>><?= $category['name'] ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                <?php endif; ?>
            </div>
          </div>
          <div class="block-overview d-none">
            <hr/>
            <div class="block-overview-title">
              OTHER
            </div>
            <div class="row">
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Position
                  </label>
                  <input type="text" class="input-custom" name="position" disabled value="1"/>
                </div>
              </div>
            </div>
          </div>
          <div class="block-overview d-none">
            <hr/>
            <div class="block-overview-title">
              Costs
            </div>
            <div class="row">
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Overall costs
                  </label>
                  <input type="text" class="input-custom" name="overall-costs" disabled value="<?php
                  if (!empty($responseTask->overallCosts)) {
                      echo $responseTask->overallCosts;
                  } else {
                      echo '-';
                  } ?>"/>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Spent units
                  </label>
                  <input type="text" class="input-custom" name="ppent-units" disabled value="<?php
                  if (!empty($responseTask->spentTime)) {
                      echo $responseTask->spentTime;
                  } else {
                      echo '-';
                  } ?>"/>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Labor costs
                  </label>
                  <input type="text" class="input-custom" name="labor-costs" disabled value="<?php
                  if (!empty($responseTask->laborCosts)) {
                      echo $responseTask->laborCosts;
                  } else {
                      echo '-';
                  } ?>"/>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Budget
                  </label>
                  <input type="text" class="input-custom" name="budget" disabled value="-"/>
                </div>
              </div>
              <div class="col-md-6 select-col">
                <div class="form-item">
                  <label class="form-label label-custom">
                    Unit costs
                  </label>
                  <input type="text" class="input-custom" name="unit-costs" disabled value="-"/>
                </div>
              </div>
            </div>
          </div>
          <div class="block-overview">
            <hr/>
            <div class="form-item-attachment">
              <label class="form-label label-custom">
                File
              </label>
              <input type="hidden" class="usernameLogin" value="<?= $username ?>">
              <div class="block-file">
                  <?php if (!empty($attachmentList)): foreach ($attachmentList as $key => $attachment): ?>
                    <div class="block-file-info d-flex align-items-center justify-content-start">
                      <div class="block-file-info-name">
                        <div class="name-item">
                          <a href="<?= base_url('auth/project/attachment/' . $attachment['id']) ?>" target="_blank"><?= $attachment['fileName'] ?></a>
                        </div>
                        <button type="button" class="close icon-cancel btn-delete-attachment"
                                data-id="<?= $attachment['id'] ?>"></button>
                      </div>
                      <div class="block-file-info-author-time-publishing">
                        <span><?= $attachment['author'] ?></span>
                        <span title="<?php
                        $date = date_create($attachment['createdAt']);
                        echo date_format($date, "F j, h:i A"); ?>"><?= $attachment['countTime'] ?>
                          </span>
                      </div>
                    </div>
                  <?php endforeach; endif; ?>
              </div>
              <div class="block-file block-file-list"></div>
            </div>
            <div class="row">
              <div class="col-12 content-upload">
                <div class="block-file-upload">
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
            </div>
          </div>
          <div class="block-overview">
            <div class="btn-toolbar">
              <div class="btn-group mr-2">
                <button class="btn-custom btn-bg green btn-update add-spinner" type="submit">
                  Update
                </button>
              </div>
              <div class="btn-group">
                <a href="<?= base_url('auth/project/'. $identifier .'/work-package') ?>" class="btn-custom no-child btn-bg btn-cancel btn-cancel-edit-member">
                  Cancel
                </a>
              </div>
            </div>
          </div>
        </form>
      </div> <!-- body-content -->
    </div>
    <div class="section-attended-project section-task-detail-right">
      <div class="scroll-x">
        <div class="top-content">
          <div class="sm-menu-tab">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                 aria-controls="nav-home" aria-selected="true">activity</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                 aria-controls="nav-profile" aria-selected="false">relations</a>
              <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                 aria-controls="nav-contact" aria-selected="false">WATCHERS</a>
            </div>
          </div>
        </div>
      </div> <!-- top-content -->
      <div class="body-content tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <div class="block-overview">
              <?php
              if (!empty($activities)): $dateCurrent = null;
                  $index = 1;
                  foreach ($activities as $key => $value) {
                      if (!empty($value['user'])) {
                          $avatar_jpg = 'uploads/userfiles/' . $value['user']['id'] . '/profilePhoto.jpg';
                          if (file_exists($avatar_jpg)) {
                              $avatar = $avatar_jpg . '?' . time();
                          } else {
                              $avatar = 'assets/images/img-avatar-default.png';
                          }
                          if ($index == 1):
                              ?>
                            <div class="block-activity">
                              <div class="block-date">
                                  <?php $date = date_create($value['createdAt']);
                                  echo date_format($date, "F j, Y");
                                  ?>
                              </div>
                              <div class="block-info-activity d-flex">
                                <div class="block-img">
                                  <img src="<?= base_url($avatar) ?>" alt=""/>
                                </div>
                                <div class="block-info">
                                  <div class="author">
                                      <?= $responseTask->_embedded->author->name ?>
                                  </div>
                                  <div class="time-publishing">
                                    created on <?php
                                      $date = date_create($value['createdAt']);
                                      echo date_format($date, "m/d/Y h:i A"); ?>
                                  </div>
                                </div>
                              </div>
                              <div class="block-detail">
                                <div class="title-activity"><?= $value['comment'] ?></div>
                              </div>
                            </div>
                          <?php else: ?>
                            <div class="block-activity">
                                <?php
                                $date = date_format(date_create($value['createdAt']), "dmY");
                                if ($date != $dateCurrent):
                                    ?>
                                  <div class="block-date">
                                      <?php echo date_format(date_create($value['createdAt']), "F j, Y");
                                      ?>
                                  </div>
                                <?php endif; ?>
                              <div class="block-info-activity d-flex">
                                <div class="block-img">
                                  <img src="<?= base_url($avatar) ?>" alt=""/>
                                </div>
                                <div class="block-info">
                                  <div class="author">
                                      <?= $value['user']['name'] ?>
                                  </div>
                                  <div class="time-publishing">
                                    updated on <?php
                                      $date = date_create($value['createdAt']);
                                      echo date_format($date, "m/d/Y h:i A"); ?>
                                  </div>
                                </div>
                              </div>
                              <div class="block-detail">
                                <div class="title-activity"><?= $value['comment'] ?></div>
                                <div class="description-activity">
                                  <ul>
                                      <?php foreach ($value['detail'] as $detail => $content) {
                                          echo '<li>' . $content . '</li>';
                                      }
                                      ?>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          <?php endif;
                      }
                      $dateCurrent = date_format(date_create($value['createdAt']), "dmY");
                      $index++;
                  }
                  ?>
              <?php endif; ?>
            <div class="info-state-activity add-comment-item">
              <div class="add-comment-button">Write a comment</div>
              <div class="add-comment-textarea d-none">
                <textarea name="comment" id="comment" class="form-control textarea-custom"></textarea>
                <div class="d-flex justify-content-end">
                  <div class="btn-custom btn-bg green">
                    <a id="btn_save_comment">Save</a>
                  </div>
                  <div class="btn-custom btn-bg gray">
                    <a id="btn_cancel_comment">Cancel</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <div class="block-overview table-children">
            <div class="block-overview-title">
              Children
            </div>
            <div class="table-responsive text-nowrap">
              <table class="table table-borderless table-sm">
                <thead>
                <tr>
                  <th class="col-id">ID</th>
                  <th class="col-type">TYPE</th>
                  <th class="col-subject">SUBJECT</th>
                  <th class="col-status">STATUS</th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (!empty($relations)):
                    foreach ($relations as $key => $relation):

                        ?>
                      <tr>
                        <td class="ordinal-number" id="ordinal-number">
                          <a href="<?= base_url('auth/project/'.$identifier.'/work-package/edit/' . $relation->id) ?>"><?= $relation->id ?></a>
                        </td>
                        <td class="">
                          <button class="btn btn-sm dropdown-toggle btn-action btn-update-type-relation" type="button"
                                  data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false"
                                  data-id="<?= $relation->_embedded->type->id ?>">
                              <?= $relation->_embedded->type->name ?>
                          </button>
                          <div class="dropdown-menu" x-placement="top-start"
                               style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(719px, 521px, 0px);">
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="1">Task</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="2">Milestone</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="3">Phase</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="4">Feature</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="5">Epic</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="6">User story</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-type-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="7">Bug</a>
                          </div>
                        </td>
                        <td>
                            <?= $relation->subject ?>
                        </td>
                        <td class="">
                          <button class="btn btn-sm dropdown-toggle btn-action btn-update-status-relation" type="button"
                                  data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false"
                                  data-id="<?= $relation->_embedded->status->id ?>">
                              <?= $relation->_embedded->status->name ?>
                          </button>
                          <div class="dropdown-menu" x-placement="top-start"
                               style="position: absolute; transform: translate3d(1007px, 521px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="1">New</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="7">In progress</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="17">Need Review</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="18">ReOpen</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="16">Done</a>
                            <a class="dropdown-item project-sidebar-item-content block-white update-status-item"
                               data-work_packageID="<?= $relation->id ?>" data-id="13">Closed</a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; endif; ?>
                <tr class="add-work-package d-none">
                  <td></td>
                  <td>
                    <button class="btn btn-sm dropdown-toggle btn-action btn-add-type" type="button"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"
                            data-id="1">Task
                    </button>
                    <div class="dropdown-menu" x-placement="top-start"
                         style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(719px, 521px, 0px);">
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                         data-id="1">Task</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                         data-id="2">Milestone</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                         data-id="3">Phase</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                         data-id="4">Feature</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                         data-id="5">Epic</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item" data-id="6">User
                        story</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                         data-id="7">Bug</a>
                    </div>
                  </td>
                  <td class="form-item">
                    <input type="text" class="input-add-work-package input-custom">
                  </td>
                  <td>
                    <button class="btn btn-sm dropdown-toggle btn-action btn-add-status" type="button"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"
                            data-id="1">New
                    </button>
                    <div class="dropdown-menu" x-placement="top-start"
                         style="position: absolute; transform: translate3d(1007px, 521px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <a class="dropdown-item project-sidebar-item-content block-white add-status-item"
                         data-id="1">New</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-status-item" data-id="7">In
                        progress</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-status-item" data-id="17">Need
                        Review</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-status-item" data-id="18">ReOpen</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-status-item" data-id="16">Done</a>
                      <a class="dropdown-item project-sidebar-item-content block-white add-status-item" data-id="13">Closed</a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="create-new-child">+ Create new child
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
          <div class="block-overview">
            <div class="block-activity activity-list">
                <?php
                if (!empty($watchers)):
                    foreach ($watchers as $key => $watcher):
                        $avatar_jpg = 'uploads/userfiles/' . $watcher['userSmnID'] . '/profilePhoto.jpg';
                        if (file_exists($avatar_jpg)) {
                            $avatar = $avatar_jpg . '?' . time();
                        } else {
                            $avatar = 'assets/images/img-avatar-default.png';
                        }
                        ?>
                      <div class="block-info-activity d-flex tab-watches" id="watcher_<?= $watcher['id'] ?>">
                        <div class="block-img">
                          <img src="<?= base_url($avatar) ?>" alt="">
                        </div>
                        <div class="block-info">
                          <div class="author"><?= $watcher['name'] ?></div>
                        </div>
                      </div>
                    <?php endforeach; endif; ?>
            </div>
            <!--          <div class="form-item">-->
            <!--            <select name="watchers" class="form-control select-custom select2-hidden-accessible" data-select2-id="84" tabindex="-1" aria-hidden="true">-->
            <!--              <option data-select2-id="86">Choose watchers</option>-->
            <!--            </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" data-select2-id="85" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-watchers-af-container"><span class="select2-selection__rendered ui-sortable" id="select2-watchers-af-container" role="textbox" aria-readonly="true" title="Choose watchers">Choose watchers</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>-->
            <!--          </div>-->
          </div>
        </div>
      </div> <!-- body-content -->
    </div>
  </div>
</div>
</div>
<div class="modal sm-modal modal-delete" id="modalDeleteAttachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="modal-header sm-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <input type="hidden" id="attachmentID">
        <div class="title">Do you want to delete this attachment?</div>
      </div>
      <div class="sm-modal-footer">
        <div class="gr-button d-flex">
          <div class="btn-custom btn-border green" data-dismiss="modal">
            <a>
              CANCEL
            </a>
          </div>
          <div class="btn-custom btn-bg green">
            <a class="add-spinner" id="btnSubmitDeleteAttachment">
              OK
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
