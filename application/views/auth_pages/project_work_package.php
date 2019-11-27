<?php
$response = $this->session->userdata('response');

$list_task_gantt_chart = array();
$cntArray = 0;
$urlTask = $this->session->userdata('urlTask');
if (!empty($projectID)) {
    $linkProject = "/api/v3/projects/" . $projectID;
}
?>
<input type="hidden" id="work_package_identifier" value="<?= $identifier ?>">
<div class="section-project section-project-list project-list section-project-work-package">
  <div class="scroll-x">
    <div class="project-layout-list-sort">
      <div class="d-flex">
        <div class="mr-auto btn-list-sort">
          <a class="layout-list-status">All open</a>
        </div>
        <div class="btn-list-sort">
          <button class="btn btn-custom btn-bg btn-create" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false" id="dropdownMenuCreate">&#43;&nbsp;Create
          </button>
          <div class="dropdown-menu dropdown-menu-right mt" aria-labelledby="dropdownMenuCreate">
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/1') ?>"><span
                class="dot dark-blue"></span> Task
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/2') ?>"><span
                class="dot green"></span> Milestone
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/3') ?>"><span
                class="dot light-blue"></span> Phase
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/4') ?>"><span
                class="dot feature-dot"></span> Feature
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/5') ?>"><span
                class="dot yellow"></span> Epic
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/6') ?>"><span
                class="dot grey"></span> User story
            </a>
            <a class="dropdown-item project-sidebar-item-content block-white"
               href="<?= base_url('auth/project/' . $identifier . '/work-package/new-task/7') ?>"><span
                class="dot red"></span> Bug
            </a>
          </div>
        </div>
          <?php if (!empty($list_task)): ?>
            <div class="btn-list-sort ml-0">
              <a class="ml-3 btn btn-custom btn-bg btn-icon btn-chart"><span class="icon icon-chart"></span></a>
            </div>
          <?php endif; ?>
          <?php
          $dataFormat = 'day';
          if (isset($_SESSION['formatGanttChart']) && $_SESSION['formatGanttChart'] == 'day'){
              $dataFormat = 'month';
          } ?>
        <div class="btn-list-sort ml-0">
          <div id="btn_change_format" class="ml-3 btn-custom pl-3 pr-3 btn-border gray no-child d-none" data-format="<?= $dataFormat ?>">
            View by <?= $dataFormat ?></div>
        </div>
        <div class="modal fade option-export-modal" id="modalOptionExport">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <p class="modal-title">Work package table configuration</p>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-pdf-file"></span></div>
                      <label>PDF</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-pdf-attachments"></span></div>
                      <label>PDF with attachments</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-pdf-descriptions"></span></div>
                      <label>PDF with descriptions</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-pdf-descriptions-attachments"></span></div>
                      <label>PDF with descriptions and attachments </label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-csv"></span></div>
                      <label>CSV</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-atom-file"></span></div>
                      <label>Atom</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-xls"></span></div>
                      <label>XLS</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-xls-description"></span></div>
                      <label>XLS with description</label>
                    </div>
                    <div class="col-6 col-sm-4 block-icon">
                      <div><span class="icon icon-xls-relations"></span></div>
                      <label>XLS with relations</label>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid wrapper-work-package">
    <div id="filter" class="row collapse">
      <div class="block-filter block-filter-table">
        <div class="block-left">
          <div class="block-input-filter">
            <div class="form-item input-filter">
              <label class="form-label label-custom">
                Filter by text
              </label>
              <input type="input" name="filter-text" class="input-custom"
                     placeholder="Subject, Description, Comments..."/>
            </div>
            <div class="d-flex">
              <div class="form-item select-is">
                <label class="form-label label-custom">
                  Status
                </label>
                <select name="" class="form-control select-custom ">
                  <option value="o">open</option>
                  <option value="=">is</option>
                  <option value="c">closed</option>
                  <option value="!">is not</option>
                  <option value="*">all</option>
                </select>
              </div>
              <div class="form-item select-scheduled">
                <label class="form-label label-custom">
                  &nbsp;
                </label>
                <select name="" class="form-control select-custom ">
                  <option>to be scheduled</option>
                </select>
              </div>
              <div class="form-item">
                <label class="form-label label-custom">
                  &nbsp;
                </label>
                <span class="icon-cancel icon-close-input-filter"></span>
              </div>
            </div>
          </div>
          <div class="form-item add-filter">
            <select name="" class="form-control select-custom ">
              <option>+ Add Filter</option>
            </select>
          </div>
        </div>
        <div class="block-right">
          <div class="form-item ">
            <label class="form-label label-custom">
              &nbsp;
            </label>
            <div class="btn-toolbar">
              <div class="btn-group">
                <button class="btn-custom btn-bg green btn-Done">
                  Done
                </button>
              </div>
              <div class="btn-group">
                <button class="btn-custom btn-bg green btn-cancel btn-close-block-filter">
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row equal test">
      <div class="wrapper-table-list  wrapper-table-list-work-package cell">
        <div class="table-list">
          <div class="table-responsive min-height-180 text-nowrap">
            <table class="table" id="table-work-package-task">
              <tbody>
              <tr>
                <th scope="col" id="col-id">
                  <div class="dropdown">
                      <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="title">ID</span><span class="icon icon-dropdown"></span>
                      </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuProperties">
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=ID&ordinary=asc"><span class="icon icon-arrow-down"></span>Sort ascending
                      </a>
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=ID&ordinary=desc"><span class="icon icon-arrow-up"></span>Sort descending
                      </a>
                    </div>
                  </div>
                </th>
                <th scope="col" class="th-subject" id="col-subject">
                  <div class="dropdown">
                      <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="title">Subject</span><span class="icon icon-dropdown"> </span>
                      </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuProperties">
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=Subject&ordinary=asc"><span class="icon icon-arrow-down"></span>Sort ascending
                      </a>
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=Subject&ordinary=desc"><span class="icon icon-arrow-up"></span>Sort descending
                      </a>
                    </div>
                  </div>
                </th>
                <th scope="col">
                  <div class="dropdown">
                      <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="title">Start Date</span><span class="icon icon-dropdown"> </span>
                      </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuProperties">
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=startDate&ordinary=asc"><span class="icon icon-arrow-down"></span>Sort ascending
                      </a>
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=startDate&ordinary=desc"><span class="icon icon-arrow-up"></span>Sort descending
                      </a>
                    </div>
                  </div>
                </th>
                <th scope="col">
                  <div class="dropdown">
                      <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="title">Finish Date</span><span class="icon icon-dropdown"> </span>
                      </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuProperties">
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=dueDate&ordinary=asc"><span class="icon icon-arrow-down"></span>Sort ascending
                      </a>
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=dueDate&ordinary=desc"><span class="icon icon-arrow-up"></span>Sort descending
                      </a>
                    </div>
                  </div>
                </th>
                <th scope="col">
                  <div class="dropdown">
                      <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="title">Type</span><span class="icon icon-dropdown"> </span>
                      </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuProperties">
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=Type&ordinary=asc"><span class="icon icon-arrow-down"></span>Sort ascending
                      </a>
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=Type&ordinary=desc"><span class="icon icon-arrow-up"></span>Sort descending
                      </a>
                    </div>
                  </div>
                </th>
                <th scope="col">
                  <div class="dropdown">
                      <span id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="title">Assignee</span><span class="icon icon-dropdown"> </span>
                      </span>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuProperties">
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=assignee&ordinary=asc"><span class="icon icon-arrow-down"></span>Sort ascending
                      </a>
                      <a class="dropdown-item project-sidebar-item-content block-white"
                         href="?sort=assignee&ordinary=desc"><span class="icon icon-arrow-up"></span>Sort descending
                      </a>
                    </div>
                  </div>
                </th>
                <th scope="col" data-toggle="modal" data-target="#configureModal">
                  <span class="icon-setting"></span>
                </th>
                <div class="modal fade configure-modal" id="configureModal">
                  <div class="modal-dialog modal-xl modal-dialog-centered">
                    <form method="POST">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <p class="modal-title">Work package table configuration</p>
                          <button type="button" class="close" data-dismiss="modal"><span class="icon-cancel"></span>
                          </button>
                        </div>
                        <hr>
                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="top-content">
                            <div class="scroll-x">
                              <nav class="sm-menu-tab">
                                <div class="nav nav-tabs" id="nav-tab-column" role="tablist">
                                  <a class="nav-item nav-link active" id="nav-filter-tab" data-toggle="tab"
                                     href="#nav-filter"
                                     role="tab" aria-controls="nav-filter" aria-selected="false">Filter</a>
                                  <a class="nav-item nav-link" id="nav-sort-by-tab" data-toggle="tab"
                                     href="#nav-sort-by" role="tab" aria-controls="nav-sort-by"
                                     aria-selected="false">Sort by</a>
                                </div>
                              </nav>
                            </div>
                          </div>
                          <div class="tab-content" id="nav-tabConfigure">
                            <div class="tab-pane fade active show" id="nav-filter" role="tabpanel"
                                 aria-labelledby="nav-filter-tab">
                              <div class="content">
                                <div class="block-filter">
                                  <div class="block-input-filter">
                                    <div class="form-item input-filter">
                                      <label class="form-label label-custom">
                                        Filter by text
                                      </label>
                                      <input type="input" name="filter-text" class="input-custom"
                                             placeholder="Subject, Description, Comments..."/>
                                    </div>
                                    <div class="d-flex">
                                      <div class="form-item select-is form-status-select">
                                        <label class="form-label label-custom">
                                          Status
                                        </label>
                                        <select name="statusFilter" class="form-control select-custom-none-search"
                                                id="statusFilter">
                                          <option disabled selected hidden>Please select</option>
                                          <option value="o">open</option>
                                          <option value="=">is</option>
                                          <option value="c">closed</option>
                                          <option value="!">is not</option>
                                          <option value="*">all</option>
                                        </select>
                                      </div>
                                      <div class="form-item select-scheduled" id="statusTask" style="display: none;">
                                        <label class="form-label label-custom">
                                          &nbsp;
                                        </label>
                                        <select id="test" class="form-control select-custom-none-search"
                                                name="statusTask[]" multiple>
                                          <option value="1">New</option>
                                          <option value="7">In progress</option>
                                          <option value="17">Need Review</option>
                                          <option value="18">Reopen</option>
                                          <option value="16">Done</option>
                                          <option value="13">Closed
                                          </option>
                                          <option value="2">In specification
                                          </option>
                                          <option value="3">Specified</option>
                                          <option value="4">
                                            Confirmed
                                          </option>
                                          <option value="5">To be scheduled
                                          </option>
                                          <option value="6">scheduled
                                          </option>
                                          <option value="8">In development
                                          </option>
                                          <option value="9">Developed</option>
                                        </select>
                                      </div>
                                      <div class="form-item">
                                        <label class="form-label label-custom">
                                          &nbsp;
                                        </label>
                                        <span class="icon-cancel icon-close-input-filter"></span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-item add-filter">
                                    <select name="" class="form-control select-custom ">
                                      <option>+ Add Filter</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="nav-sort-by" role="tabpanel"
                                 aria-labelledby="nav-sort-by-tab">
                              <div class="content">
                                <div class="d-flex flex-wrap bg-light form-sort">
                                  <div class="select-sort">
                                    <div class="form-item">
                                      <select class="form-control select-custom" name="seclect-sort-first">
                                        <option value="startDate" selected>Start date
                                        </option>
                                        <option value="responsible">Accountable
                                        </option>
                                        <option value="assignee">Assignee
                                        </option>
                                        <option value="author">Author</option>
                                        <option value="category">Category
                                        </option>
                                        <option value="createdAt">Created on
                                        </option>
                                        <option value="estimatedTime">Estimated
                                          time
                                        </option>
                                        <option value="dueDate">Finish date
                                        </option>
                                        <option value="id">ID</option>
                                        <option value="position">Position
                                        </option>
                                        <option value="priority">Priority
                                        </option>
                                        <option value="percentageDone">Progress (%)
                                        </option>
                                        <option value="project">Project</option>
                                        <option value="remainingHour">
                                          Remaining Hours
                                        </option>
                                        <option value="status">Status
                                        </option>
                                        <option value="subject">Subject</option>
                                        <option value="type">Type</option>
                                        <option value="updatedAt">Updated on
                                        </option>
                                        <option value="version">Version</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="type-sort">
                                    <div class="d-flex radio-sort">
                                      <div class="form-item check-terms-item checkbox-register fs-14">
                                        <input type="radio" class="input" name="check-sort-first" value="asc" checked>
                                        <label></label>
                                        <div class="check-terms-item-text">
                                          Ascending
                                        </div>
                                      </div>
                                      <div class="form-item check-terms-item checkbox-register fs-14">
                                        <input type="radio" class="input" name="check-sort-first" value="desc">
                                        <label></label>
                                        <div class="check-terms-item-text">
                                          Descending
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="d-flex flex-wrap bg-light form-sort">
                                  <div class="select-sort">
                                    <div class="form-item">
                                      <select class="form-control select-custom" name="seclect-sort-second">
                                        <option value="responsible">Accountable
                                        </option>
                                        <option value="assignee">Assignee
                                        </option>
                                        <option value="author">Author</option>
                                        <option value="category">Category
                                        </option>
                                        <option value="createdAt">Created on
                                        </option>
                                        <option value="estimatedTime">Estimated
                                          time
                                        </option>
                                        <option value="dueDate">Finish date
                                        </option>
                                        <option value="id">ID</option>
                                        <option value="position">Position
                                        </option>
                                        <option value="priority">Priority
                                        </option>
                                        <option value="percentageDone">Progress (%)
                                        </option>
                                        <option value="project">Project</option>
                                        <option value="remainingHour">
                                          Remaining Hours
                                        </option>
                                        <option value="startDate">Start date
                                        </option>
                                        <option value="status">Status
                                        </option>
                                        <option value="subject" selected>Subject</option>
                                        <option value="type">Type</option>
                                        <option value="updatedAt">Updated on
                                        </option>
                                        <option value="version">Version</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="type-sort">
                                    <div class="d-flex radio-sort">
                                      <div class="form-item check-terms-item checkbox-register fs-14">
                                        <input type="radio" class="input" name="check-sort-second" value="asc" checked>
                                        <label></label>
                                        <div class="check-terms-item-text">
                                          Ascending
                                        </div>
                                      </div>
                                      <div class="form-item check-terms-item checkbox-register fs-14">
                                        <input type="radio" class="input" name="check-sort-second" value="desc">
                                        <label></label>
                                        <div class="check-terms-item-text">
                                          Descending
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="d-flex flex-wrap bg-light form-sort">
                                  <div class="select-sort">
                                    <div class="form-item">
                                      <select class="form-control select-custom" name="seclect-sort-third">
                                        <option value="responsible" selected>Accountable
                                        </option>
                                        <option value="assignee">Assignee
                                        </option>
                                        <option value="author">Author</option>
                                        <option value="category">Category
                                        </option>
                                        <option value="createdAt">Created on
                                        </option>
                                        <option value="estimatedTime">Estimated
                                          time
                                        </option>
                                        <option value="dueDate">Finish date
                                        </option>
                                        <option value="id">ID</option>
                                        <option value="position">Position
                                        </option>
                                        <option value="priority">Priority
                                        </option>
                                        <option value="percentageDone">Progress (%)
                                        </option>
                                        <option value="project">Project</option>
                                        <option value="remainingHour">
                                          Remaining Hours
                                        </option>
                                        <option value="startDate">Start date
                                        </option>
                                        <option value="status">Status
                                        </option>
                                        <option value="subject">Subject</option>
                                        <option value="type">Type</option>
                                        <option value="updatedAt">Updated on
                                        </option>
                                        <option value="version">Version</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="type-sort">
                                    <div class="d-flex radio-sort">
                                      <div class="form-item check-terms-item checkbox-register fs-14">
                                        <input type="radio" class="input" name="check-sort-third" value="asc" checked>
                                        <label></label>
                                        <div class="check-terms-item-text">
                                          Ascending
                                        </div>
                                      </div>
                                      <div class="form-item check-terms-item checkbox-register fs-14">
                                        <input type="radio" class="input" name="check-sort-third" value="desc">
                                        <label></label>
                                        <div class="check-terms-item-text">
                                          Descending
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <div class="btn-toolbar">
                            <div class="btn-group">
                              <button class="btn btn-custom no-child btn-bg btn-cancel" data-dismiss="modal">
                                Cancel
                              </button>
                            </div>
                            <div class="btn-group">
                              <button class="btn btn-custom no-child btn-bg green btn-apply">
                                Apply
                              </button>
                            </div>
                          </div>
                        </div>

                      </div>
                  </div>
                  </form>
                </div>
              </tr>
              <!-- description:element.description.raw,
                                          start:element.startDate,
                                          end:element.dueDate,
                                          project : element._links.project.title,
                                          status: element._links.status.title,
                                          assignee: element._links.assignee.title,
                                          priority: element._links.priority.title,
                                          startDate: element.startDate,
                                          finishDate: element.dueDate -->
              <?php

              if (!empty($list_task)) :
                  echo '<script type="text/javascript">';

                  echo "var events = " . json_encode($list_task) . ";";
                  echo '
                                    var eventsArray = [];
                                    events.forEach(function(element, index){
                                        eventsArray.push({
                                            id: element.id,
                                            name:element.subject,
                                            series:
                                            [
                                                { 
                                                    name: "Planned",
                                                    start: new Date(1919,05,13),
                                                    end: new Date(2019,08,15) 
                                                }
                                            ] 
                                        })
																		})';
                  echo "</script>";
                  foreach ($list_task as $variable => $value) :
                      if ($value->_links->parent->href == null) {
                          if (empty($value->_links->children)) {
                              $list_task_gantt_chart[$cntArray] = clone $value;
                              $cntArray++;
                          } ?>
                        <tr class="row-task glineitem<?= $value->id ?>" data-work-package-id=<?= $value->id ?>
                        data-highlight=<?php echo "embedded-Ganttchildrow_" . $value->id; ?> class="row-task-table"
                            data-parent="<?php
                            if (!empty($value->_links->parent->href)) {
                                $idParent = str_replace("/api/v3/work_packages/", "", $value->_links->parent->href);
                                echo $idParent;
                            } else {
                                echo "-1";
                            } ?>">
                          <td class="ordinal-number" id="ordinal-number" value="<?= $value->id ?>">
                              <?= $value->id ?></td>
                          <td class="column-subject">
                            <a class="limitTextMenu" href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/'.$value->id) ?>" title="<?= $value->subject ?>"><?= $value->subject ?></a>
                          </td>
                          <td id="startDate_<?= $value->id ?>">
                              <?php
                              if (isset($value->startDate)) {
                                  echo date("d/m/Y", strtotime($value->startDate));
                              }
                              else if (isset($value->date)){
                                if ($value->_links->type->title == 'Milestone'){
                                    echo date("d/m/Y", strtotime($value->date));
                                }
                              }
                              ?>
                          </td>
                          <td id="dueDate_<?= $value->id ?>">
                              <?php
                              if (isset($value->dueDate)) {
                                  echo date("d/m/Y", strtotime($value->dueDate));
                              }
                              else if (isset($value->date)){
                                  if ($value->_links->type->title == 'Milestone'){
                                      echo date("d/m/Y", strtotime($value->date));
                                  }
                              }
                              ?>
                          </td>
                          <td>
                            <div class="mr-auto" id="type_<?= $value->id ?>">
                                <?php if (isset($value->_links->type->title)) {
                                    echo $value->_links->type->title;
                                } ?>
                            </div>
                          </td>
                          <td>
                            <div class="mr-auto" id="assignee_<?= $value->id ?>">
                                <?php if (isset($value->_links->assignee->title)) {
                                    echo $value->_links->assignee->title;
                                } ?>
                            </div>
                          </td>
                          <td class="dropdown dropleft">
                            <div class="d-flex">
                              <div class="block-row-info">
                                <a class="btn-row-info">&nbsp;<span class="icon icon-info"
                                                                    data-id="<?php if (!empty($value->id)) {
                                                                        echo $value->id;
                                                                    } ?>"></span></a>
                              </div>
                              <span class="icon icon-dropdown-option icon-more-vertical" data-toggle="dropdown"
                                    aria-expanded="false"></span>
                              <div class="dropdown-menu dropdown-more-option">
                                <a class="dropdown-item project-sidebar-item-content block-white"
                                   href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/' . $value->id . '') ?>">
                                  <span class="icon icon-views"></span>Open
                                </a>
                                <a class="dropdown-item project-sidebar-item-content block-white"
                                   href="<?= base_url('auth/project/' . $identifier . '/work-package/copy-task/' . $value->id . '') ?>">
                                  <span class="icon icon-copy"></span>Copy
                                </a>
                                <a class="dropdown-item project-sidebar-item-content block-white add-spinner"
                                   href="<?= base_url('auth/project/' . $identifier . '/work-package/delete/' . $value->id . '') ?>">
                                  <span class="icon icon-delete"></span>Delete
                                </a>
                                <a
                                  href="<?= base_url('auth/project/' . $identifier . '/work-package/create-child/' . $value->id . '/1') ?>"
                                  class="dropdown-item project-sidebar-item-content block-white btn-create-new-child"
                                  data-id="<?php if (!empty($value->id)) {
                                      echo $value->id;
                                  } ?>">
                                  <span class="icon icon-create-new"></span>Create new child
                                </a>
                              </div>
                            </div>
                          </td>
                        </tr>
                          <?php
                          if (!empty($value->_links->children)) {
                              $list_task_gantt_chart[$cntArray] = clone $value;
                              $cntArray++;
                              foreach ($value->_links->children as $variableChild => $valueChild) {
                                  $idChild = str_replace("/api/v3/work_packages/", "", $valueChild->href);
                                  $url = str_replace("/api/v3/", "", $valueChild->href);
                                  $url = $this->config->config['api_url'] . $url;
                                  $ch = curl_init();
                                  curl_setopt($ch, CURLOPT_URL, $url);
                                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                  curl_setopt($ch, CURLOPT_USERPWD, $api_key);
                                  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                                  $responseChild = curl_exec($ch);
                                  curl_close($ch);
                                  $responseChild = json_decode($responseChild);
                                  $list_task_gantt_chart[$cntArray] = $responseChild;
                                  $cntArray++; ?>

                                <tr id="collapseRow<?= $value->id ?>" class="collapse show row-task glineitem<?= $idChild ?>"
                                    data-highlight=<?php echo "embedded-Ganttchildrow_" . $idChild; ?> data-level="1">
                                  <td class="ordinal-number" id="ordinal-number" value="<?= $idChild ?>">
                                      <?= $idChild ?></td>
                                  <td class="column-subject">
                                    <a class="limitTextMenu" href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/'.$idChild) ?>" title="<?= $valueChild->title ?>"><?= $valueChild->title ?></a>
                                  </td>
                                  <td>
                                      <?php
                                      if (isset($responseChild->startDate)) {
                                          echo date("d/m/Y", strtotime($responseChild->startDate));
                                      }
                                      else if (isset($responseChild->date)){
                                          if ($responseChild->_links->type->title == 'Milestone'){
                                              echo date("d/m/Y", strtotime($responseChild->date));
                                          }
                                      }
                                      ?>
                                  </td>
                                  <td>
                                      <?php
                                      if (isset($responseChild->dueDate)) {
                                          echo date("d/m/Y", strtotime($responseChild->dueDate));
                                      }
                                      else if (isset($responseChild->date)){
                                          if ($responseChild->_links->type->title == 'Milestone'){
                                              echo date("d/m/Y", strtotime($responseChild->date));
                                          }
                                      }
                                      ?>
                                  </td>
                                  <td>
                                    <div class="mr-auto">
                                        <?php if (isset($responseChild->_links->type->title)) {
                                            echo $responseChild->_links->type->title;
                                        } ?>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="mr-auto">
                                        <?php if (isset($value->_links->assignee->title)) {
                                            echo $value->_links->assignee->title;
                                        } ?>
                                    </div>
                                  </td>
                                  <td class="dropdown dropleft">
                                    <div class="d-flex">
                                      <div class="block-row-info">
                                        <a class="btn-row-info">&nbsp;<span class="icon icon-info"
                                                                            data-id=<?= $responseChild->id ?>></span></a>
                                      </div>
                                      <span class="icon icon-dropdown-option icon-more-vertical" data-toggle="dropdown"
                                            aria-expanded="false"></span>
                                      <div class="dropdown-menu dropdown-more-option">
                                        <a class="dropdown-item project-sidebar-item-content block-white"
                                           href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/' . $idChild . '') ?>">
                                          <span class="icon icon-views"></span>Open
                                        </a>
                                        <a class="dropdown-item project-sidebar-item-content block-white"
                                           href="<?= base_url('auth/project/' . $identifier . '/work-package/copy-task/' . $idChild . '') ?>">
                                          <span class="icon icon-copy"></span>Copy
                                        </a>
                                        <a class="dropdown-item project-sidebar-item-content block-white add-spinner"
                                           href="<?= base_url('auth/project/' . $identifier . '/work-package/delete/' . $idChild . '') ?>">
                                          <span class="icon icon-delete"></span>Delete
                                        </a>
                                        <a
                                          href="<?= base_url('auth/project/' . $identifier . '/work-package/create-child/' . $responseChild->id . '/1') ?>"
                                          class="dropdown-item project-sidebar-item-content block-white btn-create-new-child"
                                          data-id="<?php if (!empty($value->id)) {
                                              echo $value->id;
                                          } ?>">
                                          <span class="icon icon-create-new"></span>Create new child
                                        </a>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                  <?php
                                  if (!empty($responseChild->_links->children)) {
                                      foreach ($responseChild->_links->children as $variableresponseChild => $valueresponseChild) {
                                          $idChild2 = str_replace("/api/v3/work_packages/", "",
                                            $valueresponseChild->href);
                                          $url = str_replace("/api/v3/", "", $valueresponseChild->href);
                                          $url = $this->config->config['api_url'] . $url;
                                          $ch2 = curl_init();
                                          curl_setopt($ch2, CURLOPT_URL, $url);
                                          curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
                                          curl_setopt($ch2, CURLOPT_USERPWD, $api_key);
                                          curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");
                                          $responseChild2 = curl_exec($ch2);
                                          curl_close($ch2);
                                          $responseChild2 = json_decode($responseChild2);
                                          $list_task_gantt_chart[$cntArray] = $responseChild2;
                                          $cntArray++; ?>
                                        <tr id="collapseRow<?= $responseChild->id ?>"
                                            class="collapse show row-task glineitem<?= $idChild2 ?>"
                                            data-highlight=<?php echo "embedded-Ganttchildrow_" . $idChild2; ?> data-level="2">

                                          <td class="ordinal-number" id="ordinal-number" value="<?= $idChild2 ?>">
                                              <?= $idChild2 ?></td>
                                          <td class="column-subject">
                                            <a class="limitTextMenu" href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/'.$idChild2) ?>" title="<?= $valueresponseChild->title ?>"><?= $valueresponseChild->title ?></a>
                                          </td>
                                          <td>
                                              <?php
                                              if (isset($responseChild2->startDate)) {
                                                  echo date("d/m/Y", strtotime($responseChild2->startDate));
                                              }
                                              else if (isset($responseChild2->date)){
                                                  if ($responseChild2->_links->type->title == 'Milestone'){
                                                      echo date("d/m/Y", strtotime($responseChild2->date));
                                                  }
                                              }
                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                              if (isset($responseChild2->dueDate)) {
                                                  echo date("d/m/Y", strtotime($responseChild2->dueDate));
                                              }
                                              else if (isset($responseChild2->date)){
                                                  if ($responseChild2->_links->type->title == 'Milestone'){
                                                      echo date("d/m/Y", strtotime($responseChild2->date));
                                                  }
                                              }
                                              ?>
                                          </td>
                                          <td>
                                            <div class="mr-auto">
                                                <?php if (isset($responseChild2->_links->type->title)) {
                                                    echo $responseChild2->_links->type->title;
                                                } ?>
                                            </div>
                                          </td>
                                          <td>
                                            <div class="mr-auto">
                                                <?php if (isset($value->_links->assignee->title)) {
                                                    echo $value->_links->assignee->title;
                                                } ?>
                                            </div>
                                          </td>
                                          <td class="dropdown dropleft">
                                            <div class="d-flex">
                                              <div class="block-row-info">
                                                <a class="btn-row-info">&nbsp;<span class="icon icon-info"
                                                                                    data-id=<?= $responseChild2->id ?>></span></a>
                                              </div>
                                              <span class="icon icon-dropdown-option icon-more-vertical"
                                                    data-toggle="dropdown"
                                                    aria-expanded="false"></span>
                                              <div class="dropdown-menu dropdown-more-option">
                                                <a class="dropdown-item project-sidebar-item-content block-white"
                                                   href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/' . $idChild2 . '') ?>">
                                                  <span class="icon icon-views"></span>Open
                                                </a>
                                                <a class="dropdown-item project-sidebar-item-content block-white"
                                                   href="<?= base_url('auth/project/' . $identifier . '/work-package/copy-task/' . $idChild2 . '') ?>">
                                                  <span class="icon icon-copy"></span>Copy
                                                </a>
                                                <a
                                                  class="dropdown-item project-sidebar-item-content block-white add-spinner"
                                                  href="<?= base_url('auth/project/' . $identifier . '/work-package/delete/' . $idChild2 . '') ?>">
                                                  <span class="icon icon-delete"></span>Delete
                                                </a>
                                              </div>
                                            </div>
                                          </td>
                                        </tr>
                                          <?php
                                      }
                                  }
                              }
                          }
                      } endforeach;
              endif;
              ?>
              <!--							<tr class="row-create-work-package">-->
              <!--								<td colspan="2" class="create-work-package">-->
              <!--									<span class="create-new-child">+ Create new work package</span>-->
              <!--									<div class="form-item">-->
              <!--										<input type="text" class="input-custom create-new-task" name="new-task" placeholder="Developer 1" value="" />-->
              <!--									</div>-->
              <!--								</td>-->
              <!--								<td colspan="5" class="close-create-work-package">-->
              <!--									<span class="icon icon-cancel"></span>-->
              <!--								</td>-->
              <!--							</tr>-->
              <tr class="row-create-work-package">
                <td colspan="2" class="create-work-package-custom">
                  <span class="create-new-work-package">+ Create new work package</span>
                </td>
                <td colspan="5"></td>
              </tr>
              <tr class="add-work-package d-none">
                <td></td>
                <td class="form-item">
                  <input type="text" class="input-create-new-work-package input-custom">
                </td>
                <td></td>
                <td></td>
                <td>Task</td>
                <td class="close-create-work-package">
                  <span class="icon icon-cancel"></span>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div> <!-- wrapper-table-project-list -->

      <div class="wrapper-chart cell">
        <div id="embedded-Gantt">
            <?php
            if (isset($_SESSION['formatGanttChart'])){
                $format = $_SESSION['formatGanttChart'];
            }
            else{
                $format = 'month';
            }
            ?>
          <script type="text/javascript">
            <?php
            if ($format == 'day'){
              echo "var g = new JSGantt.GanttChart(document.getElementById('embedded-Gantt'), 'day');";
            }
            else{
              echo "var g = new JSGantt.GanttChart(document.getElementById('embedded-Gantt'), 'month');";
            }
            ?>
            // console.log(g);
            if (g.getDivId() != null) {
              g.setCaptionType('Caption'); // Set to Show Caption (None,Caption,Resource,Duration,Complete)
              g.setQuarterColWidth(50);
              g.setDayMajorDateDisplayFormat('mon yyyy');
              g.setDayMinorDateDisplayFormat('dd');
              g.setDateTaskDisplayFormat('day dd month yyyy'); // Shown in tool tip box
              g.setShowTaskInfoLink(1); // Show link in tool tip (0/1)
              g.setShowDeps(1);
              g.setShowEndWeekDate(
                0); // Show/Hide the date for the last day of the week in header for daily view (1/0)
              g.setUseSingleCell(
                10000
              ); // Set the threshold at which we will only use one cell per table row (0 disables).  Helps with rendering performance for large charts.
              g.setFormatArr('Day'); // Even with setUseSingleCell using Hour format on such a large chart can cause issues in some browsers
                <?php
                if (!empty($list_task_gantt_chart)) {
                    $typeFirst = preg_replace('/\s+/', '', (strtolower($list_task_gantt_chart[0]->_links->type->
                    title)));
                    $dateMock = date("Y-m-d");
                    $dateMock = date('Y-m-d', strtotime($dateMock .
                      ' + 30 days'));
                    if ($typeFirst === "milestone") {
                        if ($list_task_gantt_chart[0]->date === null) {
                            $list_task_gantt_chart[0]->date = $dateMock;
                        }
                    } else {
                        if ($list_task_gantt_chart[0]->startDate === null) {
                            $list_task_gantt_chart[0]->startDate = $dateMock;
                            $list_task_gantt_chart[0]->dueDate = $dateMock;
                        }
                    }
                    if (!empty($list_task_gantt_chart)) {
                        foreach ($list_task_gantt_chart as $variable => $value):
                            if (!empty($value->_links->children)) {
                                if ($value->_links->parent->href == null) {
                                    $type = preg_replace('/\s+/', '', (strtolower($value->_links->type->title)));
                                    if ($type === "milestone") {
                                        if (empty($value->date)) {
                                            // echo "milistone empty - ";
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '', '', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, 0, 1, 1, '', '', '', 1,1,'', g));";
                                        } else {
                                            //echo "milistone not empty - ";
                                            $caption = date("d/m/Y", strtotime($value->date));
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->date .
                                              "', '" . $value->date .
                                              "', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, 0, 1, 1, '', '" . $caption .
                                              "', '', 1,1,'', g));";
                                        }
                                    } else {
                                        if (!empty($value->startDate) || !empty($value->dueDate)) {
                                            // echo "task not empty - ";
                                            $captionRight = date("d/m/Y", strtotime($value->dueDate));
                                            $captionLeft = date("d/m/Y", strtotime($value->startDate));
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->startDate .
                                              "' , '" . $value->dueDate .
                                              "' , 'g" . $type .
                                              "', '', '','', '', '', '', '3', '', '" . $captionRight .
                                              "','" . $captionLeft .
                                              "' ,1 ,1 ,'', g));";
                                        } else {
                                            // echo "task empty - ";
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '' , '' , 'g" . $type .
                                              "', '', '','', '', '', '', '', '', '','' ,1,1, '', g));";
                                        }
                                    }
                                } else {
                                    $type = preg_replace('/\s+/', '', (strtolower($value->_links->type->title)));
                                    if ($type === "milestone") {
                                        if (empty($value->date)) {
                                            // echo "milistone empty - ";
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '', '', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, '', '', 1, $idParent, '', '', 1,0,'', g));";
                                        } else {
                                            //echo "milistone not empty - ";
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            $caption = date("d/m/Y", strtotime($value->date));
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->date .
                                              "', '" . $value->date .
                                              "', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, '', '', 1, $idParent, '" . $caption .
                                              "', '', 1,0,'', g));";
                                        }
                                    } else {
                                        if (!empty($value->startDate) || !empty($value->dueDate)) {
                                            // echo "task not empty - ";
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            $captionRight = date("d/m/Y", strtotime($value->dueDate));
                                            $captionLeft = date("d/m/Y", strtotime($value->startDate));
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->startDate .
                                              "' , '" . $value->dueDate .
                                              "' , 'g" . $type .
                                              "', '', '','', '', '', '', '3', $idParent, '" . $captionRight .
                                              "','" . $captionLeft .
                                              "' , 1,0,'', g));";
                                        } else {
                                            // echo "task empty - ";
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '' , '' , 'g" . $type .
                                              "', '', '','', '', '', '', '', $idParent, '','' , 1,0,'', g));";
                                        }
                                    }
                                }
                            } else {
                                if ($value->_links->parent->href == null) {
                                    $type = preg_replace('/\s+/', '', (strtolower($value->_links->type->title)));
                                    if ($type === "milestone") {
                                        if (empty($value->date)) {
                                            // echo "milistone empty - ";
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '', '', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, 0, 1, 1, '', '', '', 1,0,'', g));";
                                        } else {
                                            //echo "milistone not empty - ";
                                            $caption = date("d/m/Y", strtotime($value->date));
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->date .
                                              "', '" . $value->date .
                                              "', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, 0, 1, 1, '', '" . $caption .
                                              "', '', 1,0,'', g));";
                                        }
                                    } else {
                                        if (!empty($value->startDate) || !empty($value->dueDate)) {
                                            // echo "task not empty - ";
                                            $captionRight = date("d/m/Y", strtotime($value->dueDate));
                                            $captionLeft = date("d/m/Y", strtotime($value->startDate));
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->startDate .
                                              "' , '" . $value->dueDate .
                                              "' , 'g" . $type .
                                              "', '', '','', '', '', '', '3', '', '" . $captionRight .
                                              "','" . $captionLeft .
                                              "' ,1,0, '', g));";
                                        } else {
                                            // echo "task empty - ";
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '' , '' , 'g" . $type .
                                              "', '', '','', '', '', '', '', '', '','' , 1,0,'', g));";
                                        }
                                    }
                                } else {
                                    $type = preg_replace('/\s+/', '', (strtolower($value->_links->type->title)));
                                    if ($type === "milestone") {
                                        if (empty($value->date)) {
                                            // echo "milistone empty - ";
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '', '', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, 0, 1, 1, $idParent, '', '', 0,0,'', g));";
                                        } else {
                                            //echo "milistone not empty - ";
                                            $caption = date("d/m/Y", strtotime($value->date));
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->date .
                                              "', '" . $value->date .
                                              "', 'g" . $type .
                                              "', '', 1, 'Shlomy', 100, 0, 1, 1, $idParent, '" . $caption .
                                              "', '', 0,0,'', g));";
                                        }
                                    } else {
                                        if (!empty($value->startDate) || !empty($value->dueDate)) {
                                            // echo "task not empty - ";
                                            $captionRight = date("d/m/Y", strtotime($value->dueDate));
                                            $captionLeft = date("d/m/Y", strtotime($value->startDate));
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '" . $value->startDate .
                                              "' , '" . $value->dueDate .
                                              "' , 'g" . $type .
                                              "', '', '','', '', '', '', '3', $idParent, '" . $captionRight .
                                              "','" . $captionLeft .
                                              "' , 0,0,'', g));";
                                        } else {
                                            // echo "task empty - ";
                                            $idParent = str_replace("/api/v3/work_packages/", "",
                                              $value->_links->parent->href);
                                            echo "g.AddTaskItem(new JSGantt.TaskItem($value->id, '" . $value->subject .
                                              "', '' , '' , 'g" . $type .
                                              "', '', '','', '', '', '', '', $idParent, '','' , 0,0,'', g));";
                                        }
                                    }
                                }
                            }

                        endforeach;
                    }
                } ?>
              g.Draw();
            } else {
              alert("Error, unable to create Gantt Chart");
            }
          </script>
        </div>
      </div> <!-- wrapper-chart -->
      <div class="wrapper-row-info section-attended-project cell work-package-detail">
          <?php
          if (!empty($list_task_gantt_chart)) {
              foreach ($list_task_gantt_chart as $variable => $value) :
                  $type = preg_replace('/\s+/', '', (strtolower($value->_links->type->title)))
                  ?>
                <div class="scroll-x wrapper-block-row-info" data-id=<?php if (!empty($value->id)) {
                    echo $value->id;
                } ?>>
                  <div class="top-content">
                    <div class="scroll-x">
                      <nav class="sm-menu-tab">
                        <div class="nav nav-tabs" id="nav-tab-column" role="tablist">
                          <a class="nav-item nav-link active" id="nav-overview-tab<?php if (!empty($value->id)) {
                              echo $value->id;
                          } ?>" data-toggle="tab" href="#nav-overview<?php if (!empty($value->id)) {
                              echo $value->id;
                          } ?>" role="tab" aria-controls="nav-overview" aria-selected="true">overview
                          </a>
                          <a class="nav-item nav-link nav-activity-tab" data-work_packageID="<?= $value->id ?>"
                             id="nav-activity-tab<?= $value->id ?>" data-toggle="tab"
                             href="#nav-activity<?php if (!empty($value->id)) {
                                 echo $value->id;
                             } ?>" role="tab" aria-controls="nav-activity" aria-selected="true">activity
                          </a>
                          <a class="nav-item nav-link nav-relations-tab" data-work_packageID="<?= $value->id ?>"
                             id="nav-relations-tab<?= $value->id ?>" data-toggle="tab"
                             href="#nav-relations<?php if (!empty($value->id)) {
                                 echo $value->id;
                             } ?>" role="tab" aria-controls="nav-relations" aria-selected="true">relations
                          </a>
                          <a class="nav-item nav-link nav-watches-tab" data-work_packageID="<?= $value->id ?>"
                             id="nav-watches-tab<?= $value->id ?>" data-toggle="tab"
                             href="#nav-watches<?php if (!empty($value->id)) {
                                 echo $value->id;
                             } ?>" role="tab" aria-controls="nav-watches" aria-selected="true">watches
                          </a>
                        </div>
                        <div class="btn-close-row-info">
                          <span class="icon-cancel"></span>
                        </div>
                      </nav>
                    </div>
                  </div> <!-- top-content -->
                  <div class="tab-content" id="nav-tabRowInfo">
                    <div class="tab-pane fade active show" id="nav-overview<?php if (!empty($value->id)) {
                        echo $value->id;
                    } ?>" role="tabpanel" aria-labelledby="nav-overview-tab">
                      <div class="body-content body-content-row-info pb-5">
                        <div class="form-item select-set-parent">
                          <select name="set-parent" class="form-control select-custom">
                            <option disabled selected>Choose new parent or press escape to cancel</option>
                          </select>
                        </div>
                          <?php
                          $typeID = substr($value->_links->type->href, 14);
                          $statusID = substr($value->_links->status->href, 17);
                          ?>
                        <div class="d-flex align-items-center">
                          <div class="btn-list-sort">
                            <input type="hidden" id="type_id_<?= $value->id ?>">
                            <button class="btn btn-custom btn-bg btn-create btn-update-type btnShowMenuType">
                        <span id="type_icon_<?= $value->id ?>" class="dot <?php
                        if ($typeID == 1) {
                            echo 'dark-blue';
                        } elseif ($typeID == 2) {
                            echo 'green';
                        } elseif ($typeID == 3) {
                            echo 'light-blue';
                        } elseif ($typeID == 4) {
                            echo 'feature-dot';
                        } elseif ($typeID == 5) {
                            echo 'yellow';
                        } elseif ($typeID == 6) {
                            echo 'grey';
                        } elseif ($typeID == 7) {
                            echo 'red';
                        }
                        ?>"></span>
                              <span id="type_name_<?= $value->id ?>"
                                    class="type-name"><?= $value->_links->type->title ?></span>
                            </button>
                            <div class="dropdown-menu-type">
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot dark-blue" data-id="1"
                                 data-type="Task"><span class="dot dark-blue"></span> Task
                              </a>
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot green" data-id="2"
                                 data-type="Milestone"><span class="dot green"></span> Milestone
                              </a>
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot light-blue" data-id="3"
                                 data-type="Phase"><span class="dot light-blue"></span> Phase
                              </a>
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot feature-dot" data-id="4"">
                              <span class="dot feature-dot"></span> Feature
                              </a>
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot yellow" data-id="5"
                                 data-type="Epic"><span
                                  class="dot yellow"></span> Epic
                              </a>
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot grey" data-id="6"
                                 data-type="User story"><span class="dot grey"></span> User story
                              </a>
                              <a class="dropdown-item dropdown-type-item block-white update-type-item"
                                 data-work_packageID="<?= $value->id ?>" data-icon="dot red" data-id="7"
                                 data-type="Bug"><span class="dot red"></span> Bug
                              </a>
                            </div>
                          </div>
                          <span class="name-task text-nowrap"><?php if (!empty($value->subject)) {
                                  echo $value->subject;
                              } ?>
                      </span>
                        </div>
                        <hr>
                        <div class="block-action">
                          <div class="btn-group">
                            <input type="hidden" id="status_id_<?= $value->id ?>">
                            <button class="btn btn-sm btn-action btn-update-status <?php
                            if ($statusID == 1) {
                                echo 'new-dot';
                            } elseif ($statusID == 7) {
                                echo 'in-progress-dot';
                            } elseif ($statusID == 17) {
                                echo 'need-review-dot';
                            } elseif ($statusID == 18) {
                                echo 'reopen-dot';
                            } elseif ($statusID == 5) {
                                echo 'done-dot';
                            } elseif ($statusID == 13) {
                                echo 'closed-dot';
                            }
                            ?> btnShowMenuStatus">
                              <span id="status_name_<?= $value->id ?>"
                                    class="status-name"><?= $value->_links->status->title ?></span>
                            </button>
                            <div class="dropdown-menu-status">
                              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                                 data-work_packageID="<?= $value->id ?>"
                                 data-style="btn btn-sm btn-action btn-update-status new-dot btnShowMenuStatus"
                                 data-id="1" data-status="New"><span
                                  class="dot new-dot"></span> New
                              </a>
                              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                                 data-work_packageID="<?= $value->id ?>"
                                 data-style="btn btn-sm btn-action btn-update-status in-progress-dot btnShowMenuStatus"
                                 data-id="7"
                                 data-status="In progress"><span class="dot in-progress-dot"></span> In progress
                              </a>
                              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                                 data-work_packageID="<?= $value->id ?>"
                                 data-style="btn btn-sm btn-action btn-update-status need-review-dot btnShowMenuStatus"
                                 data-id="17"
                                 data-status="In progress"><span class="dot need-review-dot"></span> Need Review
                              </a>
                              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                                 data-work_packageID="<?= $value->id ?>"
                                 data-style="btn btn-sm btn-action btn-update-status reopen-dot btnShowMenuStatus"
                                 data-id="18"
                                 data-status="In progress"><span class="dot reopen-dot"></span> ReOpen
                              </a>
                              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                                 data-work_packageID="<?= $value->id ?>"
                                 data-style="btn btn-sm btn-action btn-update-status done-dot btnShowMenuStatus"
                                 data-id="16"
                                 data-status="In progress"><span class="dot done-dot"></span> Done
                              </a>
                              <a class="dropdown-item dropdown-status-item block-white update-status-item"
                                 data-work_packageID="<?= $value->id ?>"
                                 data-style="btn btn-sm btn-action btn-update-status closed-dot btnShowMenuStatus"
                                 data-id="13" data-status="Closed"><span
                                  class="dot closed-dot"></span> Closed
                              </a>
                            </div>
                          </div>
                          <span>1: Created by <?= $value->_links->author->title ?> . Last updated on <?php
                              $date = date_create($value->updatedAt);
                              echo date_format($date, "m/d/Y h:i A"); ?>.</span>
                        </div>
                        <div class="block-overview">
                          <hr/>
                          <div class="block-overview-title">
                            description
                          </div>
                          <div class="form-item">
                            <input type="text" class="input-custom update-content-item" name="description"
                                   data-work_packageID="<?= $value->id ?>"
                                   data-name="description"
                                   placeholder="Click to enter description"
                                   value="<?php if (!empty($value->description->raw)) {
                                       echo $value->description->raw;
                                   } ?>"/>
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
                                <select name="assignee" class="form-control select-custom update-content-item-select"
                                        data-name="assignee" data-work_packageID="<?= $value->id ?>">
                                    <?php
                                    if (empty($value->_links->assignee->href)){
                                        echo '<option></option>';
                                    }
                                    if (!empty($list_memberships) && !empty($linkProject)) {
                                        foreach ($list_memberships as $varMember => $valMember) {
                                            if ($valMember->_links->project->href == $linkProject) {
                                                foreach ($list_member as $variable => $v) {
                                                    if ($valMember->_links->principal->href == $v->_links->self->href) {
                                                        if ($value->_links->assignee->href == $v->_links->self->href) { ?>
                                                          <option value="<?= $v->id ?>"
                                                                  selected><?= $v->name ?></option>
                                                        <?php } else { ?>
                                                          <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                                        <?php }
                                                    }
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
                                <select name="accountable" class="form-control select-custom update-content-item-select"
                                        data-name="accountable" data-work_packageID="<?= $value->id ?>">
                                    <?php
                                    if (empty($value->_links->responsible->href)){
                                        echo '<option></option>';
                                    }
                                    if (!empty($list_memberships) && !empty($linkProject)) {
                                        foreach ($list_memberships as $varMember => $valMember) {
                                            if ($valMember->_links->project->href == $linkProject) {
                                                foreach ($list_member as $variable => $v) {
                                                    if ($valMember->_links->principal->href == $v->_links->self->href) {
                                                        if ($value->_links->responsible->href == $v->_links->self->href) { ?>
                                                          <option value="<?= $v->id ?>"
                                                                  selected><?= $v->name ?></option>
                                                        <?php } else { ?>
                                                          <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                                        <?php }
                                                    }
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
                                <input type="number" class="input-custom update-content-item" name="estimated-time"
                                       data-name="estimatedTime" data-work_packageID="<?= $value->id ?>"
                                       placeholder="-" value="<?php
                                if (!empty($value->estimatedTime)) {
                                    $str = $value->estimatedTime;
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
                                  if (!empty($value->_links->children)){
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
                                <input type="number" class="input-custom update-content-item" name="estimated-time"
                                       data-name="remainingTime" data-work_packageID="<?= $value->id ?>"
                                       placeholder="-" value="<?php
                                if (!empty($value->remainingTime)) {
                                    $str = $value->remainingTime;
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
                                  if (!empty($value->_links->children)){
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
                              <?php if ($value->_links->type->title != 'Milestone'): ?>
                            <div class="col-md-6 select-col">
                              <div class="form-item input-group datetime-picker dash">
                                <label class="form-label label-custom ">
                                  Date
                                </label>
                                <input class="input-custom input-medium datepicker start-date start-date-<?= $value->id ?> update-content-item-select" name="startDate"
                                       data-name="startDate" data-work_packageID="<?= $value->id ?>"
                                       data-date-format="dd.mm.yyyy" readonly value="<?php
                                if (isset($value->startDate)) {
                                    echo date("d.m.Y", strtotime($value->startDate));
                                } ?>" <?php
                                if (!empty($value->_links->children)){
                                    echo " disabled ";
                                }
                                ?>>
                                <div class="error"></div>
                              </div>
                            </div>
                            <div class="col-md-6 select-col">
                              <div class="form-item input-group datetime-picker">
                                <label class="form-label label-custom ">
                                  &nbsp;
                                </label>
                                <input class="input-custom input-medium datepicker end-date end-date-<?= $value->id ?> update-content-item-select" name="endDate"
                                       data-name="dueDate" data-work_packageID="<?= $value->id ?>"
                                       data-date-format="dd.mm.yyyy" readonly value="<?php
                                if (isset($value->dueDate)) {
                                    echo date("d.m.Y", strtotime($value->dueDate));
                                } ?>" <?php
                                if (!empty($value->_links->children)){
                                    echo " disabled ";
                                }
                                ?>>
                                <div class="error"></div>
                              </div>
                            </div>
                            <?php else: ?>
                                <div class="col-md-6 select-col">
                                  <div class="form-item input-group datetime-picker">
                                    <label class="form-label label-custom ">
                                      Date
                                    </label>
                                    <input class="input-custom input-medium datepicker date date-<?= $value->id ?> update-content-item-select" name="endDate"
                                           data-name="date" data-work_packageID="<?= $value->id ?>"
                                           data-date-format="dd.mm.yyyy" readonly value="<?php
                                    if (isset($value->date)) {
                                        echo date("d.m.Y", strtotime($value->date));
                                    } ?>" <?php
                                    if (!empty($value->_links->children)){
                                        echo " disabled ";
                                    }
                                    ?>>
                                    <div class="error"></div>
                                  </div>
                                </div>
                            <?php endif; ?>
                              <?php if (!empty($versionsArr)): ?>
                                <div class="col-md-6 select-col">
                                  <div class="form-item">
                                    <label class="form-label label-custom">
                                      Version
                                    </label>
                                    <select name="version"
                                            class="form-control select-custom-none-search update-content-item-select"
                                            data-name="version" data-work_packageID="<?= $value->id ?>"
                                      <option value="">-</option>
                                        <?php foreach ($versionsArr as $key => $version) :
                                            ?>
                                          <option value="<?= $version['href'] ?>"
                                            <?php
                                            if ($version['href'] == $value->_links->version->href)
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
                                <select name="percentageDone" class="form-control select-custom update-content-item-select"
                                        data-name="percentageDone" data-work_packageID="<?= $value->id ?>"
                                  <?php if (!empty($value->_links->children)) echo 'disabled'; ?>>
                                    <?php for ($optionProgress = 0; $optionProgress < 101; $optionProgress+=5): ?>
                                      <option value="<?= $optionProgress ?>"
                                        <?php if ($optionProgress == $value->percentageDone) echo "selected"; ?>><?= $optionProgress ?></option>
                                    <?php endfor; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 select-col">
                              <div class="form-item">
                                <label class="form-label label-custom">
                                  Priority
                                </label>
                                <select name="priority" class="form-control select-custom update-content-item-select"
                                        data-name="priority" data-work_packageID="<?= $value->id ?>">
                                  <?php if (!empty($value->_embedded->priority->name)): ?>
                                    <option value="<?= $value->_embedded->priority->id ?>"><?= $value->_embedded->priority->name ?></option>
                                  <?php endif; ?>
                                  <?php
                                  for ($optionPriority = 7; $optionPriority < 11; $optionPriority++) {
                                      if ($optionPriority != $value->_embedded->priority->id) {
                                        ?>
                                            <option value="<?= $optionPriority ?>">
                                                <?php
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
                                                ?>
                                            </option>
                                    <?php } } ?>
                                </select>
                              </div>
                            </div>
                              <?php if (!empty($categoriesArr)): ?>
                                <div class="col-md-6 select-col">
                                  <div class="form-item">
                                    <label class="form-label label-custom">
                                      Category
                                    </label>
                                    <select name="category"
                                            class="form-control select-custom-none-search update-content-item-select"
                                            data-name="category" data-work_packageID="<?= $value->id ?>"
                                      <option value="">-</option>
                                        <?php foreach ($categoriesArr as $key => $category) :
                                            ?>
                                          <option value="<?= $category['href'] ?>"
                                            <?php
                                            if ($category['href'] == $value->_links->category->href)
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
                                <input type="text" class="input-custom" name="overall-costs" disabled value="-"/>
                              </div>
                            </div>
                            <div class="col-md-6 select-col">
                              <div class="form-item">
                                <label class="form-label label-custom">
                                  Spent units
                                </label>
                                <input type="text" class="input-custom" name="spent-units" disabled value="-"/>
                              </div>
                            </div>
                            <div class="col-md-6 select-col">
                              <div class="form-item">
                                <label class="form-label label-custom">
                                  Labor costs
                                </label>
                                <input type="text" class="input-custom" name="labor-costs" disabled value="-"/>
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
                          <?php
                          $url = $this->config->config['api_url'] . "work_packages/" . $value->id . '/attachments';
                          $ch = curl_init();
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                          curl_setopt($ch, CURLOPT_USERPWD, $api_key);
                          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                          $responseAttachment = curl_exec($ch);
                          curl_close($ch);

                          $responseAttachment = json_decode($responseAttachment);
                          $attachmentList = array();
                          if (!empty($responseAttachment->_embedded->elements)){
                              foreach ($responseAttachment->_embedded->elements as $key => $element) {
                                  $countTime = null;
                                  $time = time() - strtotime($element->createdAt);
                                  if ($time < 60) {
                                      $countTime = 'a few seconds ago';
                                  } elseif (60 <= $time && $time < 60 * 60) {
                                      $countTime = floor($time / 60) . ' minutes ago';
                                  } elseif (60 * 60 <= $time && $time < 60 * 60 * 24) {
                                      $countTime = floor($time / 60 / 60) . ' hours ago';
                                  } elseif (60 * 60 * 24 <= $time && $time < 60 * 60 * 24 * 30) {
                                      $countTime = floor($time / 60 / 60 / 24) . ' days ago';
                                  } elseif (60 * 60 * 24 * 30 <= $time && $time < 60 * 60 * 24 * 30 * 12) {
                                      $countTime = floor($time / 60 / 60 / 24 / 30) . ' months ago';
                                  } else {
                                      $countTime = floor($time / 60 / 60 / 24 / 30 / 12) . ' years ago';
                                  }

                                  $attachment = array(
                                    'id' => $element->id,
                                    'fileName' => $element->fileName,
                                    'link' => 'http://pm.web.beesightsoft.com/attachments/' . $element->id . '/' . $element->fileName,
                                    'author' => $element->_links->author->title,
                                    'countTime' => $countTime,
                                    'createdAt' => $element->createdAt
                                  );
                                  array_push($attachmentList, $attachment);
                              }
                          }
                          ?>
                        <div class="block-overview">
                          <hr/>
                          <div class="block-overview-title">
                            FILE
                          </div>
                          <div class="form-item-attachment">
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
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="block-overview d-none">
                          <hr/>
                          <div class="block-overview-title title-latest-activity">
                            LATEST ACTIVITY
                          </div>
                          <div class="row">
                            <div class="col-12 select-col">
                              <div class="block-activity">
                                <div class="block-info-activity d-flex">
                                  <div class="block-img">
                                    <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt=""/>
                                  </div>
                                  <div class="block-info">
                                    <div class="author">
                                      OpenProject Admin
                                    </div>
                                    <div class="time-publishing">
                                      created on 04/16/2019 2:36 PM
                                    </div>
                                  </div>
                                </div>
                                <div class="block-detail">
                                  <div class="title-activity">Updated automatically by changing values within
                                    child work package #42
                                  </div>
                                  <div class="description-activity">
                                    <ul>
                                      <li><strong>&bull;&nbsp;Progress (%) </strong>changed from 100 to 0
                                      </li>
                                      <li><strong>&bull;&nbsp;Estimated time </strong>set to 2.00</li>
                                      <li><strong>&bull;&nbsp;Remaining Hours </strong>set to 2.00</li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="block-activity">
                                <div class="block-info-activity d-flex">
                                  <div class="block-img">
                                    <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt=""/>
                                  </div>
                                  <div class="block-info">
                                    <div class="author">
                                      Trang Bui
                                    </div>
                                    <div class="time-publishing">
                                      updated on 07/18/2019 3:15 PM
                                    </div>
                                  </div>
                                </div>
                                <div class="block-detail">
                                  <div class="title-activity"></div>
                                  <div class="description-activity">
                                    <ul>
                                      <li>
                                        <strong>&bull;&nbsp;Finish date </strong>changed from 04/22/2019
                                        to 04/16/2019
                                      </li>
                                      <li>
                                        <strong>&bull;&nbsp;Start date </strong>changed from 04/22/2019
                                        to 04/16/2019
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="block-overview d-none">
                          <div class="info-state-activity">
                            <div class="form-group">
                      <textarea class="form-control textarea-info-state" name="info-state"
                                rows="1">Comment and type @ to notify other people</textarea>
                            </div>
                            <div class="btn-state-info btn-toolbar">
                              <div class="btn-group">
                                <button class="btn-custom no-child btn-bg green btn-save">
                                  Save
                                </button>
                              </div>
                              <div class="btn-group">
                                <button class="btn-custom no-child btn-bg btn-cancel">
                                  Cancel
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div> <!-- body-content -->
                      <div class="footer-content footer-content-row-info d-none">
                        <div class="btn-toolbar">
                          <div class="btn-group">
                            <button class="btn btn-watch">Watch
                              <span class="icon icon-views btn-add-watcher" data-work_packageID=""></span>
                            </button>
                          </div>
                          <div class="dropup">
                            <div class="dropdown-submenu">
                              <button class="btn btn-more dropdown-toggle" tabindex="-1">
                                More
                              </button>
                              <ul class="dropdown-menu">
                                <a class="dropdown-item project-sidebar-item-content block-white"
                                   href="<?= base_url('auth/project/' . $identifier . '/work-package/edit/' . $value->id . '') ?>">
                                  <span class="icon icon-views"></span>Open
                                </a>
                                <a class="dropdown-item project-sidebar-item-content block-white" href="">
                                  <span class="icon icon-copy"></span></span>Copy
                                </a>
                                <a class="dropdown-item project-sidebar-item-content block-white" href="">
                                  <span class="icon icon-delete"></span>Delete
                                </a>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div> <!-- footer-content -->
                    </div>
                    <div class="tab-pane fade " id="nav-activity<?php if (!empty($value->id)) {
                        echo $value->id;
                    } ?>" role="tabpanel"
                         aria-labelledby="nav-activity-tab">
                      <div class="body-content body-content-row-info">
                        <div class="form-item select-set-parent">
                          <select name="set-parent" class="form-control select-custom">
                            <option disabled selected>Choose new parent or press escape to cancel</option>
                          </select>
                        </div>
                        <div class="block-dot">
                          <span class="<?= $type ?>-dot dot"></span>
                          <strong><?php if (!empty($value->_links->type->title)) {
                                  echo $value->_links->type->title;
                              } ?>: <?php if (!empty($value->subject)) {
                                  echo $value->subject;
                              } ?></strong>
                        </div>
                        <div class="block-overview list-activities">
                        </div>
                        <div class="block-overview d-none">
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
                    </div>
                    <div class="tab-pane fade " id="nav-relations<?php if (!empty($value->id)) {
                        echo $value->id;
                    } ?>" role="tabpanel"
                         aria-labelledby="nav-relations-tab">
                      <div class="body-content body-content-row-info">
                        <div class="form-item select-set-parent">
                          <select name="set-parent" class="form-control select-custom">
                            <option disabled selected>Choose new parent or press escape to cancel</option>
                          </select>
                        </div>
                        <div class="block-dot">
                          <span class="<?= $type ?>-dot dot"></span>
                          <strong><?php if (!empty($value->_links->type->title)) {
                                  echo $value->_links->type->title;
                              } ?>: <?php if (!empty($value->subject)) {
                                  echo $value->subject;
                              } ?></strong>
                        </div>
                        <div class="block-overview d-none">
                          <hr/>
                          <div class="d-flex block-precedes">
                            <div class="flex-grow-1 block-overview-title">
                              Precedes
                            </div>
                            <div class="form-item">
                              <input type="text" class="input-custom" name="description"
                                     placeholder="Group by work package type" value="Group by work package type"/>
                            </div>
                          </div>
                          <div class="d-flex block-precedes block-line-precedes d-none">
                            <div class="flex-grow-1 col-type">
                              Milestone
                            </div>
                            <div class="flex-grow-1 col-release">
                              Release v1.0 (#19)
                            </div>
                            <div class="flex-grow-1 col-status-field">
                              <button class="btn btn-sm dropdown-toggle btn-action" type="button" data-toggle="dropdown"
                                      aria-haspopup="true" aria-expanded="false">
                                New
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item project-sidebar-item-content block-white" href="#"><span
                                    class="dot dot-new"></span> New
                                </a>
                                <a class="dropdown-item project-sidebar-item-content block-white" href="#"><span
                                    class="dot dot-closed"></span> Closed
                                </a>
                              </div>
                            </div>
                            <div class="flex-grow-1 col-controls-section">
                              <span class="icon-info"></span>
                              <span class="icon-cancel"></span>
                            </div>
                          </div>
                        </div>
                        <div class="block-overview table-children">
                          <hr/>
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
                              <tbody class="list-relations">

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
                                    <a class="dropdown-item project-sidebar-item-content block-white add-type-item" data-id="2">Milestone</a>
                                    <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                                       data-id="3">Phase</a>
                                    <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                                       data-id="5">Epic</a>
                                    <a class="dropdown-item project-sidebar-item-content block-white add-type-item" data-id="6">User
                                      story</a>
                                    <a class="dropdown-item project-sidebar-item-content block-white add-type-item"
                                       data-id="7">Bug</a>
                                  </div>
                                </td>
                                <td class="form-item">
                                  <input type="text" class="input-add-work-package-custom input-custom" data-work_packageID="<?= $value->id ?>">
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
                              <tr class="d-none">
                                <td colspan="2" class="create-new-child">+ Create new child
                                </td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade " id="nav-watches<?php if (!empty($value->id)) {
                        echo $value->id;
                    } ?>" role="tabpanel"
                         aria-labelledby="nav-watches-tab">
                      <div class="body-content body-content-row-info">
                        <div class="form-item select-set-parent">
                          <select name="set-parent" class="form-control select-custom">
                            <option disabled selected>Choose new parent or press escape to cancel</option>
                          </select>
                        </div>
                        <div class="block-dot">
                          <span class="<?= $type ?>-dot dot"></span>
                          <strong><?php if (!empty($value->_links->type->title)) {
                                  echo $value->_links->type->title;
                              } ?>: <?php if (!empty($value->subject)) {
                                  echo $value->subject;
                              } ?></strong>
                        </div>
                        <div class="block-overview">
                          <hr/>
                          <div class="block-activity list-watchers">

                          </div>
                          <div class="form-item d-none">
                            <select name="watchers" class="form-control select-custom">
                              <option>Choose watchers</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach;
          } ?>
      </div>
    </div>
  </div> <!-- wrapper-work-package -->
  <div class="menu-pagination">
    <a href="<?php
    $findSortFilter = 'sortBy=[["';
    if (empty($sort)) {
        if (strlen(strstr($urlTask, $findSortFilter)) > 0) {
            echo base_url('auth/project/' . $identifier . '/work-package?sf=1');
        } else {
            echo base_url('auth/project/' . $identifier . '/work-package');
        }
    } else {
        echo '?sort=' . $sort . '&ordinary=' . $ordinary;
    }
    ?>" data-ci-pagination-page="1">First</a>
      <?php if (!empty($response->offset)): ?>
        <span class="prevlink">
      <a <?php
      if (!empty($response->offset) && $response->offset > 1) {
          if (empty($sort)) {
              $nextList = $response->offset - 1;
              if (strlen(strstr($urlTask, $findSortFilter)) > 0) {
                  echo 'href="?sf=' . $nextList . '"';
              } else {
                  echo 'href="?offset=' . $nextList . '"';
              }
          } else {
              $nextList = $response->offset - 1;
              echo 'href="?offset=' . $nextList . '&sort=' . $sort . '&ordinary=desc"';
          }
      }
      ?> data-ci-pagination-page="1">
        <span class="icon-chevron-circle-left"></span>
      </a>
    </span>
      <?php endif; ?>
      <?php
      if (!empty($response->offset) && $response->offset == 1) {
          echo "<strong>";
      }
      ?>
    <a href="<?php
    if (empty($sort)) {
        if (strlen(strstr($urlTask, $findSortFilter)) > 0) {
            echo base_url('auth/project/' . $identifier . '/work-package?sf=1');
        } else {
            echo base_url('auth/project/' . $identifier . '/work-package');
        }
    } else {
        echo '?sort=' . $sort . '&ordinary=' . $ordinary;
    }
    ?>" data-ci-pagination-page="1">1</a>
      <?php
      if (!empty($response->offset) && $response->offset == 1) {
          echo "</strong>";
      }

      ?>
      <?php
      if (!empty($response->total)) {
          $numberPage = ceil($response->total / 20);
          for ($offset = 1; $offset < $numberPage; $offset++) {
              $pagin = $offset + 1;
              if ($response->offset == $offset + 1) {
                  echo "<strong>";
              } ?>
            <a href="<?php
            if (empty($sort)) {
                if (strlen(strstr($urlTask, $findSortFilter)) > 0) {
                    echo base_url('auth/project/' . $identifier . '/work-package?sf=' . $pagin . '');
                } else {
                    echo base_url('auth/project/' . $identifier . '/work-package?offset=' . $pagin . '');
                }
            } else {
                echo base_url('auth/project/' . $identifier . '/work-package?offset=' . $pagin . '&sort=' . $sort . '&ordinary=' . $ordinary . '');
            } ?>" data-ci-pagination-page="<?php
            if (!empty($offset)) {
                echo $offset + 1;
            } ?>"><?php
                if (!empty($offset)) {
                    echo $offset + 1;
                } ?></a>
              <?php
              if ($response->offset == $offset + 1) {
                  echo "</strong>";
              }
          }
      }
      ?>

    <div class="nextlink">
      <a <?php
         if (!empty($offset) && ($offset / $response->offset > 1)) {
             if (empty($sort)) {
                 $nextList = $response->offset + 1;
                 if (strlen(strstr($urlTask, $findSortFilter)) > 0) {
                     echo 'href="?sf=' . $nextList . '"';
                 } else {
                     echo 'href="?offset=' . $nextList . '"';
                 }
             } else {
                 $nextList = $response->offset + 1;
                 echo 'href="?offset=' . $nextList . '&sort=' . $sort . '&ordinary=asc"';
             }
         }
         ?>data-ci-pagination-page="2" rel="next">
        <span class="icon-chevron-circle-right"></span>
      </a>
    </div>
    <a href="?offset=<?php
    if (!empty($offset)) {
        if (empty($sort)) {
            if (strlen(strstr($urlTask, $findSortFilter)) > 0) {
                echo $offset . '&sf=' . $offset;
            } else {
                echo $offset;
            }
        } else {
            echo $offset . '&sort=' . $sort . '&ordinary=' . $ordinary;
        }
    }
    ?>" data-ci-pagination-page="">Last</a>
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
