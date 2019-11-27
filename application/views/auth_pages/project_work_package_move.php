<?php
    $responseTask = $this->session->userdata('responseTask');
?>
<div class="section-project section-project-work-package-more-option">
    <div class="scroll-x">
        <div class="title-page">
            <div class="prev-page">
                <span class="icon icon-arrow-down"></span>Move 
            </div>
            <hr>
        </div>
        <div class="project-layout-content project-layout-new-task">
            <form method="post">
                <div class="body-content">
                    <div class="title-move">
                        <a href="">	&bull; User story #12</a>. SSL certificate
                    </div>
                    <div class="form-item">
                        <div class="block-change-properties block-overview">
                            <div class="block-overview-title">
                            CHANGE PROPERTIES
                            </div>
                            <div class="row">
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        Project:
                                        </label>
                                        <select name="project" class="form-control select-custom">
                                            <?php 
                                                if(!empty($listProject)){
                                                    foreach($listProject as $variable => $value){
                                                        if($value->id != $idProject){
                                            ?>
                                            <option value="<?= $value->id; ?>"><?= $value->pid; ?></option>
                                            <?php                                                         
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
                                            Type:
                                        </label>
                                        <select name="type" class="form-control select-custom">
                                        <option value="1"><?php if(!empty($responseTask->_embedded->type->name)){ echo $responseTask->_embedded->type->name;} ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        Status
                                        </label>
                                        <select name="status" class="form-control select-custom">
                                            <option value="1"><?php if(!empty($responseTask->_embedded->status->name)){ echo $responseTask->_embedded->status->name;} ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        Priority
                                        </label>
                                        <select name="priority" class="form-control select-custom">
                                        <option value="8"><?php if(!empty($responseTask->_embedded->priority->name)){ echo $responseTask->_embedded->priority->name;} ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        Assignee
                                        </label>
                                        <select name="assignee" class="form-control select-custom">
                                            <option value=""><?= $responseTask->_links->assignee->title; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        Accountable
                                        </label>
                                        <select name="accountable" class="form-control select-custom">
                                        <option value=""><?php if(!empty($responseTask->_embedded->responsible->name)){ echo $responseTask->_embedded->responsible->name;} ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item input-group datetime-picker dash">
                                        <label class="form-label label-custom ">
                                        Start date
                                        </label>
                                        <input class="input-custom input-medium datepicker" name="startDate" data-date-format="dd.mm.yyyy" id="startDate" value="<?php
                                            if((!empty($responseTask->startDate))){
                                            echo date("d/m/Y",strtotime($responseTask->startDate));
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
                                            echo date("d/m/Y",strtotime($responseTask->dueDate));
                                        }; ?>">
                                        <div class="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="block-overview">
                            <label class="form-label label-custom">
                                Description
                            </label>
                            <textarea name="description_document" ><?=  $responseTask->description->raw ?></textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="block-overview">
                            <label class="form-label label-custom">
                                Budget
                            </label>
                            <select name="budget" class="form-control select-custom">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="footer-content">
                    <div class="btn-toolbar">
                        <div class="btn-group mr-2">
                            <button class="btn-custom btn-bg green btn-move">
                                Move
                            </button>
                        </div>
                        <div class="btn-group mr-2">
                            <button class="btn-custom btn-bg green btn-move-follow">
                                Move and follow
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