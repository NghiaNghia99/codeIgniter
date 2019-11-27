<?php
echo '<script type="text/javascript">'; 
echo "var events = ".json_encode($list_project).";"; 
echo "
    var eventsArray = [];
    events.forEach(function(element, index){
    var startDate = 0;
    var dueDate = 0;
    if(element._links.type.title === 'Milestone'){
      startDate = element.date;
      dueDate = element.date;
    }
    else{
      startDate = element.startDate;
      dueDate = element.dueDate;
    }
         eventsArray.push({
            type: element._links.type.title,
            id: element.id,
            idtask: element.id,
            title:element.subject,
            description:element.description.raw,
            start:startDate,
            end:dueDate,
            project : element._links.project.title,
            status: element._links.status.title,
            assignee: element._links.assignee.title,
            priority: element._links.priority.title,
            startDate: startDate,
            finishDate: dueDate
         })
    })";
echo "</script>";
?>
<div class="section-project section-project-calendar">
    <div class="scroll-x">
        <div class="project-layout-list-sort">
            <div class="d-flex">
                <div class="mr-auto">
                    <a class="layout-list-status">Calendar</a>
                </div>
                <div class="">
					<a scope="col" data-toggle="modal" data-target="#configureModal" class="btn btn-custom btn-bg btn-icon btn-more-vertical">
						<span class="icon icon-filter"></span>

					</a>
					<div class="modal fade configure-modal" id="configureModal">
						<div class="modal-dialog modal-xl modal-dialog-centered">
							<form method="POST">
								<div class="modal-content">
									<!-- Modal Header -->
									<div class="modal-header">
										<p class="modal-title">Work package table configuration</p>
										<button type="button" class="close" data-dismiss="modal">&times;</button>

									</div>
									<hr>
									<!-- Modal body -->
									<div class="modal-body">
										<div class="top-content">
											<div class="scroll-x">
												<nav class="sm-menu-tab">
													<div class="nav nav-tabs" id="nav-tab-column" role="tablist">
														<a class="nav-item nav-link active" id="nav-filter-tab" data-toggle="tab" href="#nav-filter"
															 role="tab" aria-controls="nav-filter" aria-selected="false">Filter</a>
													</div>
												</nav>
											</div>
										</div>
										<div class="tab-content" id="nav-tabConfigure">
											<div class="tab-pane fade active show" id="nav-filter" role="tabpanel" aria-labelledby="nav-filter-tab">
												<div class="content">
													<div class="block-filter">
														<div class="block-input-filter">
															<div class="form-item input-filter">
																<label class="form-label label-custom">
																	Filter by text
																</label>
																<input type="input" name="filter-text" class="form-control i-filter-text"
																			 placeholder="Subject, Description, Comments..." />
															</div>
															<div class="d-flex">
																<div class="form-item select-is form-status-select">
																	<label class="form-label label-custom">
																		Status
																	</label>
																	<select name="statusFilter" class="form-control select-custom"  id="statusFilter">
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
																	<select id="test" class="form-control select-custom" name="statusTask[]" multiple >
																		<option value="1">New</option>
																		<option value="7">In progress</option>
																		<option value="17">Need Review</option>
																		<option value="18">Reopen
																		</option>
																		<option value="16">Done</option>
																		<option value="13">Closed
																		</option>
																		<option value="2">In specification
																		</option>
																		<option value="3">Specified</option>
																		<option value="4">
																			Confirmed</option>
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
										</div>
									</div>

									<!-- Modal footer -->
									<div class="modal-footer">
										<div class="btn-toolbar">
											<div class="btn-group">
												<button class="btn-custom btn-bg btn-cancel" data-dismiss="modal">
													Cancel
												</button>
											</div>
											<div class="btn-group">
												<button class="btn-custom btn-bg green btn-apply">
													Apply
												</button>
											</div>
										</div>
									</div>

								</div>
						</div>
						</form>
					</div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div id='calendar'></div>
</div>
