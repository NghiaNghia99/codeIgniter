<?php
if(!empty($idProject))
$linkProject =  "/api/v3/projects/".$idProject;
if (!empty($list_member)) {
    if (!empty($list_memberships) && !empty($linkProject)) {
        foreach ($list_memberships as $varMember => $valMember) {
            if ($valMember->_links->project->href == $linkProject) {
                foreach ($list_member as $variable => $value) {
                    if ($valMember->_links->principal->title == $value->name) {
                        $alreadyMember[] = $value->name;
                    }
                }
            }
        }
    }

    $list_add_member = array();

    foreach ($list_member as $key => $value) {
        $list_add_member[$key] = clone $value;
    }
    if (!empty($alreadyMember)) {
        foreach ($list_add_member as $variable => $value) {
            foreach ($alreadyMember as $already) {
                if ($value->name == $already) {
                    $value->name = null;
                }
            }
        }
    }
}
?>
<div class="section-project section-project-list section-project-member">
    <div class="scroll-x">
        <div class="project-layout-list-sort">
            <div class="d-flex">
                <div class="mr-auto btn-list-sort">
                    <a class="layout-list-status">Member</a>
                </div>
										<?php
											if(!empty($list_memberships) && !empty($linkProject) && !isset($adminProject)) {
												foreach ($list_memberships as $varMember => $valMember) {
													if ($valMember->_links->project->href == $linkProject) {
														foreach ($list_member as $variable => $value) {
															if ($value->name == $nameUser && $valMember->_links->principal->title == $value->name) {
																foreach ($valMember->_links->roles as $roleVariable => $roleValue) {
																	if ($roleValue->title == "Project admin" || isset($adminProject)) {
																		?>
																		<div class="btn-list-sort">
																			<a class="btn btn-custom btn-bg btn-create" data-toggle="collapse"
																				 data-target="#member">&#43;&nbsp;Member</a>
																		</div>
																		<?php
                                      break;
																	}
																}
                                  break;
															}
														}
													}
												}
											}
											if(isset($adminProject)) {
												?>
												<div class="btn-list-sort">
													<a class="btn btn-custom btn-bg btn-create" data-toggle="collapse"
														 data-target="#member">&#43;&nbsp;Member</a>
												</div>
												<?php
											}
							?>
                <div class="btn-list-sort">
                    <a scope="col" data-toggle="modal" data-target="#configureModal" class="btn btn-custom btn-bg btn-icon btn-more-vertical">
                        <span class="icon icon-filter"></span>

                    </a>
                    <div class="modal fade configure-modal" id="configureModal">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <form method="GET">
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
                                                                    Name
                                                                </label>
                                                                <input type="input" name="filter-text" class="form-control i-filter-text"
                                                                             placeholder="Subject, Description, Comments..."
                                                                  <?php
                                                                  if (isset($_GET['filter-text'])){
                                                                      echo 'value="'.$_GET['filter-text'].'"';
                                                                  }
                                                                  ?>/>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="form-item select-is form-status-select">
                                                                    <label class="form-label label-custom">
                                                                        Status
                                                                    </label>
                                                                    <select name="statusFilter" class="form-control select-custom"  id="statusFilter">
                                                                        <?php
                                                                        $status = 'selected';
                                                                        if (isset($_GET['statusFilter'])){
                                                                          $status = $_GET['statusFilter'];
                                                                        }
                                                                        ?>
                                                                        <option value="active" <?php if ($status == 'active'){ echo 'selected'; } ?> >Active</option>
                                                                        <option value="selected" <?php if ($status == 'selected'){ echo 'selected'; } ?> >All</option>
                                                                        <option value="invited" <?php if ($status == 'invited'){ echo 'selected'; } ?> >Invited</option>
                                                                        <option value="locked" <?php if ($status == 'locked'){ echo 'selected'; } ?> >Locked permanently</option>
                                                                        <option value="blocked" <?php if ($status == 'blocked'){ echo 'selected'; } ?> >Locked temporarily</option>
                                                                        <option value="registered" <?php if ($status == 'registered'){ echo 'selected'; } ?> >Registered</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                                <div class="form-item select-is form-status-select">
                                                                    <label class="form-label label-custom">
                                                                        Role:
                                                                    </label>
                                                                    <select name="rolesMember" class="form-control select-custom"  id="statusFilter">
                                                                        <?php
                                                                        $role = 'all';
                                                                        if (isset($_GET['rolesMember'])){
                                                                            $role = $_GET['rolesMember'];
                                                                        }
                                                                        ?>
                                                                        <option value="all" <?php if ($role == 'all'){ echo 'selected'; } ?> >All</option>
                                                                        <option value="Qa" <?php if ($role == 'Qa'){ echo 'selected'; } ?> >Qa</option>
                                                                        <option value="Member" <?php if ($role == 'Member'){ echo 'selected'; } ?> >Member</option>
                                                                        <option value="Internship" <?php if ($role == 'Internship'){ echo 'selected'; } ?> >Internship</option>
                                                                        <option value="Project admin" <?php if ($role == 'Project admin'){ echo 'selected'; } ?> >Project admin</option>
                                                                        <option value="Developer" <?php if ($role == 'Developer'){ echo 'selected'; } ?> >Developer</option>
                                                                    </select>
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
                                                <?php if (isset($_GET['filter-text']) || isset($_GET['statusFilter']) ||isset($_GET['rolesMember'])): ?>
                                                  <button class="btn-custom btn-bg btn-cancel d-flex">
                                                    <a href="<?= base_url('auth/project/'.$identifier.'/member') ?>">Clear</a>
                                                  </button>
                                                <?php else: ?>
                                                <button class="btn-custom no-child btn-bg btn-cancel" data-dismiss="modal">
                                                   Cancel
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn-custom no-child btn-bg green btn-apply">
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
    <div class="container-fluid wrapper-work-package">
        <div class="row">
            <div class="col-12 p0 wrapper-table-list">
                <div class="table-list table-list-member">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="th-last-name">Last name
<!--                                            <span class="icon icon-dropdown"></span>-->
                                        </th>
                                        <th scope="col" class="th-first-name">first name</th>
                                        <th scope="col" class="th-email">email</th>
                                        <th scope="col" class="th-role">roles</th>
                                        <th scope="col" class="th-status">status</th>
                                        <th scope="col" class="th-action"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="block-add-member" >
                                            <form method = "POST" action="<?= base_url('auth/project/' . $identifier . '/member/add-member')?>">
                                            <div id="member" class="collapse">
                                                <div class="block-group">
                                                    <div class="form-item block-add block-add-member-user-groups">
                                                        <label class="form-label label-custom">
                                                            Add existing users or groups
                                                        </label>
                                                        <select name="add-member" class="form-control select-custom">
                                                            <?php 
                                                                    foreach($list_add_member as $variable => $value){
                                                                        if($value->name !=null){
                                                            ?>
                                                            <option value= "<?= $value->id ?>"><?= $value->name ?></option>
                                                        <?php  }
                                                    } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-item block-add block-add-member-role">
                                                        <label class="form-label label-custom">
                                                        Assign role to new members
                                                        </label>
                                                        <select name="roles-member" class="form-control select-custom">
                                                            <option value= "8">Qa</option>
                                                            <option value= "3">Project Admin</option>
                                                            <option value= "5">Internship</option>
                                                            <option value= "4">Member</option>
                                                            <option value= "7">Developer</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-item block-add block-add-member-btn">
                                                    <label class="form-label label-custom">
                                                                &nbsp;
                                                                </label>
                                                        <div class="d-flex">
                                                            <div class="btn-toolbar">
                                                                <div class="btn-group mr-2">
                                                                    <button class="btn-custom no-child btn-bg green btn-add add-spinner" type="submit">
                                                                    Add
                                                                    </button>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <button class="btn-custom no-child btn-bg btn-cancel btn-cancel-add-member" type="button">
                                                                    Cancel
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                    if(isset($_GET['filter-text']) && $_GET['filter-text'] == "" && isset($_GET['statusFilter']) && isset($_GET['rolesMember'])){
                                        $statusMember = $_GET['statusFilter'];
                                        $rolesMember = $_GET['rolesMember'];
                                        if($statusMember == "selected"){
                                            $statusMember = "activeselectedlockedblockedregistered";
                                        }
                                        if($rolesMember == "all"){
                                            $rolesMember = "DeveloperProject adminMemberQaInternship";
                                        }
                                            if(!empty($list_memberships) && !empty($linkProject)){
                                            $cntUser = 0;
                                        foreach($list_memberships as $varMember => $valMember){
                                            if($valMember->_links->project->href == $linkProject){
                                                foreach($list_member as $variable => $value){
                                                    if($valMember->_links->principal->title == $value->name
                                                        && strlen(strpos($statusMember,$value->status)) > 0
                                                        && ( strlen(strpos($rolesMember,$valMember->_links->roles[0]->title)) > 0
																														|| (isset($rolesMember,$valMember->_links->roles[1]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[1]->title)))
																														|| (isset($rolesMember,$valMember->_links->roles[2]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[2]->title)))
																														|| (isset($rolesMember,$valMember->_links->roles[3]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[3]->title)))
																														|| (isset($rolesMember,$valMember->_links->roles[4]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[4]->title)))
																													)
                                                ){
                                                        $cntUser++;
                                    ?>
                                    <tr class="info-member">
                                        <td class="last-name">
                                            <span class="handle-column limitTextMenu"><?= $value->lastName ?> </span>
                                            <input type="text" class="form-control input-last-name limitTextMenu" value="pham" />
                                        </td>
                                        <td class="first-name">
                                            <span class="handle-column limitTextMenu"><?= $value->firstName ?></span>
                                            <input type="text" class="form-control input-first-name limitTextMenu" value="loi" />
                                        </td>
                                        <td class="email">
                                            <span class="handle-column limitTextMenu"><?= $value->login ?></span>
                                            <input type="text" class="form-control input-email limitTextMenu" value="loiphamvn@yahoo.com" />    
                                        </td>
                                        <td class="role">
                                            <span class="handle-column limitTextMenu"><?php
																							if(!empty($valMember->_links->roles[0]->title)){
																								echo $valMember->_links->roles[0]->title;
																								if(!empty($valMember->_links->roles[1]->title)){
																									echo ", ".$valMember->_links->roles[1]->title;
																								}
																								if(!empty($valMember->_links->roles[2]->title)){
																									echo ", ".$valMember->_links->roles[2]->title;
																								}
																								if(!empty($valMember->_links->roles[3]->title)){
																									echo ", ".$valMember->_links->roles[3]->title;
																								}
																								if(!empty($valMember->_links->roles[4]->title)){
																									echo ", ".$valMember->_links->roles[4]->title;
																								}
																							}
                                            ?></span>
                                            <form method = "POST">                                         
                                            <div class="block-checkbox-role">

                                                <input type="hidden" value = "<?= $valMember->id ?>" name ="id-membership" >
                                                <input type="hidden" value = "<?= $value->id ?>" name ="id-user" >
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic" value="8">
                                                    <label></label>
                                                    <div class="check-terms-item-text">Qa</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic" value="3">
                                                    <label></label>
                                                    <div class="check-terms-item-text">Project admin</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic" value="5">
                                                    <label></label>
                                                    <div class="check-terms-item-text">Internship</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic" value="4">
                                                    <label></label>
                                                    <div class="check-terms-item-text">Member</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic" value="7">
                                                    <label></label>
                                                    <div class="check-terms-item-text">Developer</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="status"><?= $value->status ?></td>
                                        <td class="btn-member">
																					<?php
																					if($value->name == $nameUser && !isset($adminProject)){
																						foreach($valMember->_links->roles as $roleVariable => $roleValue){
																							if($roleValue->title == "Project admin"){
																					?>
																								<a class="a-action edit-member"><span class="icon-edit"></span></span></a>
																							<?php
																							$idUser = $valMember->_links->principal->href;
																							$idUser = str_replace("/api/v3/users/","",$idUser);
																							?>
                                            <a href="<?= base_url('auth/project/'.$identifier.'/member/delete/'.$valMember->id.'/users/'.$idUser.'') ?>"
																							 class="a-action add-spinner"><span class="icon-delete"></span>
																						</a>
																								<?php
																								}
																							}
																						}
																					elseif(isset($adminProject)) {
																						?>
																						<a class="a-action edit-member"><span class="icon-edit"></span></span></a>
																						<?php
																						$idUser = $valMember->_links->principal->href;
																						$idUser = str_replace("/api/v3/users/", "", $idUser);
																						?>
																						<a
																							href="<?= base_url('auth/project/' . $identifier . '/member/delete/' . $valMember->id . '/users/' . $idUser . '') ?>"
																							class="a-action add-spinner"><span class="icon-delete"></span>
																						</a>
																						<?php
																					}
																						?>
                                        </td>
                                    </tr>
                                    <tr class="info-member block-btn-edit">
                                        <td colspan="8">
                                            <div class="btn-toolbar">
                                                <div class="btn-group mr-2">
                                                    <button class="btn-custom no-child btn-bg green btn-update add-spinner" type="submit">
                                                    Update
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn-custom no-child btn-bg btn-cancel btn-cancel-edit-member" type="button">
                                                    Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </form>
                                    <?php 
                                                     }
                                                 }
                                            }
                                        }
                                    }
                                    }
                                    ?>
                                    <?php
                                    if(isset($_GET['filter-text']) && $_GET['filter-text'] != "" && isset($_GET['statusFilter']) && isset($_GET['rolesMember'])){
                                        $filterName = $_GET['filter-text'];
                                        $statusMember = $_GET['statusFilter'];
                                        $rolesMember = $_GET['rolesMember'];
                                        if($statusMember == "selected"){
                                            $statusMember = "activeselectedlockedblockedregistered";
                                        }
                                        if($rolesMember == "all"){
                                            $rolesMember = "DeveloperProject adminMemberQaInternship";
                                        }
                                            if(!empty($list_memberships) && !empty($linkProject)){
                                            $cntUser = 0;
                                        foreach($list_memberships as $varMember => $valMember){
                                            if($valMember->_links->project->href == $linkProject){
                                                foreach($list_member as $variable => $value){
                                                    if($valMember->_links->principal->title == $value->name && strlen(strpos(strtoupper($value->name),strtoupper($filterName))) > 0
                                                        && strlen(strpos($statusMember,$value->status)) > 0
																												&& ( strlen(strpos($rolesMember,$valMember->_links->roles[0]->title)) > 0
																													|| (isset($rolesMember,$valMember->_links->roles[1]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[1]->title)))
																													|| (isset($rolesMember,$valMember->_links->roles[2]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[2]->title)))
																													|| (isset($rolesMember,$valMember->_links->roles[3]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[3]->title)))
																													|| (isset($rolesMember,$valMember->_links->roles[4]->title) && strlen(strpos($rolesMember,$valMember->_links->roles[4]->title)))
																												)
                                                ){
                                                        $cntUser++;
                                    ?>
                                    <tr class="info-member">
                                        <td class="last-name">
                                            <span class="handle-column limitTextMenu"><?= $value->lastName ?> </span>
                                            <input type="text" class="form-control input-last-name limitTextMenu" value="pham" />
                                        </td>
                                        <td class="first-name">
                                            <span class="handle-column limitTextMenu"><?= $value->firstName ?></span>
                                            <input type="text" class="form-control input-first-name limitTextMenu" value="loi" />
                                        </td>
                                        <td class="email">
                                            <span class="handle-column limitTextMenu"><?= $value->login ?></span>
                                            <input type="text" class="form-control input-email limitTextMenu" value="loiphamvn@yahoo.com" />    
                                        </td>
                                        <td class="role">
																					<?php
																					if(!empty($valMember->_links->roles[0]->title)){
																						echo $valMember->_links->roles[0]->title;
																						if(!empty($valMember->_links->roles[1]->title)){
																							echo ", ".$valMember->_links->roles[1]->title;
																						}
																						if(!empty($valMember->_links->roles[2]->title)){
																							echo ", ".$valMember->_links->roles[2]->title;
																						}
																						if(!empty($valMember->_links->roles[3]->title)){
																							echo ", ".$valMember->_links->roles[3]->title;
																						}
																						if(!empty($valMember->_links->roles[4]->title)){
																							echo ", ".$valMember->_links->roles[4]->title;
																						}
																					}
																					?>
                                            <span class="handle-column limitTextMenu"></span>
                                        <td class="status"><?= $value->status ?></td>
                                        <td class="btn-member">
																					<?php
																					if($value->name == $nameUser && !isset($adminProject)){
																						foreach($valMember->_links->roles as $roleVariable => $roleValue){
																							if($roleValue->title == "Project admin" || isset($adminProject)){
																								?>
																								<a class="a-action edit-member"><span class="icon-edit"></span></span></a>
																								<?php
																								$idUser = $valMember->_links->principal->href;
																								$idUser = str_replace("/api/v3/users/","",$idUser);
																								?>
																								<a href="<?= base_url('auth/project/'.$identifier.'/member/delete/'.$valMember->id.'/users/'.$idUser.'') ?>"
																									 class="a-action add-spinner"><span class="icon-delete"></span>
																								</a>
																								<?php
																							}
																						}
																					}
																					elseif(isset($adminProject)) {
																						?>
																						<a class="a-action edit-member"><span class="icon-edit"></span></span></a>
																						<?php
																						$idUser = $valMember->_links->principal->href;
																						$idUser = str_replace("/api/v3/users/", "", $idUser);
																						?>
																						<a
																							href="<?= base_url('auth/project/' . $identifier . '/member/delete/' . $valMember->id . '/users/' . $idUser . '') ?>"
																							class="a-action add-spinner"><span class="icon-delete"></span>
																						</a>
																						<?php
																					}
																					?>
                                        </td>
                                    </tr>
                                    <tr class="info-member block-btn-edit">
                                        <td colspan="8">
                                            <div class="btn-toolbar">
                                                <div class="btn-group mr-2">
                                                    <button class="btn-custom no-child btn-bg green btn-update add-spinner" type="submit">
                                                    Update
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn-custom no-child btn-bg btn-cancel btn-cancel-edit-member" type="button">
                                                    Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </form>
                                    <?php 
                                                     }
                                                 }
                                            }
                                        }
                                    }
                                    }
                                    ?>
                                    <?php 
                                    if(!isset($_GET['filter-text'])  && !isset($_GET['statusFilter']) && !isset($_GET['rolesMember'])){
                                        if(!empty($list_memberships) && !empty($linkProject)){
                                            $cntUser = 0;
                                        foreach($list_memberships as $varMember => $valMember){
                                            if($valMember->_links->project->href == $linkProject){
                                                foreach($list_member as $variable => $value){
                                                    if($valMember->_links->principal->href == "/api/v3/users/".$value->id){
                                                        $cntUser++;
                                    ?>
                                    <tr class="info-member">
                                        <td class="last-name">
                                            <span class="handle-column limitTextMenu"><?= $value->lastName ?> </span>
                                            <input type="text" class="form-control input-last-name limitTextMenu" value="pham" />
                                        </td>
                                        <td class="first-name">
                                            <span class="handle-column limitTextMenu"><?= $value->firstName ?></span>
                                            <input type="text" class="form-control input-first-name limitTextMenu" value="loi" />
                                        </td>
                                        <td class="email">
                                            <span class="handle-column limitTextMenu"><?= $value->login ?></span>
                                            <input type="text" class="form-control input-email limitTextMenu" value="loiphamvn@yahoo.com" />    
                                        </td>
                                        <td class="role">
																					<?php
																					if(!empty($valMember->_links->roles[0]->title)){
																						echo $valMember->_links->roles[0]->title;
																						if(!empty($valMember->_links->roles[1]->title)){
																							echo ", ".$valMember->_links->roles[1]->title;
																						}
																						if(!empty($valMember->_links->roles[2]->title)){
																							echo ", ".$valMember->_links->roles[2]->title;
																						}
																						if(!empty($valMember->_links->roles[3]->title)){
																							echo ", ".$valMember->_links->roles[3]->title;
																						}
																						if(!empty($valMember->_links->roles[4]->title)){
																							echo ", ".$valMember->_links->roles[4]->title;
																						}
																					}
																					?>
                                            <span class="handle-column limitTextMenu"></span>
                                            <form method = "POST">                                         
                                            <div class="block-checkbox-role">
                                                <input type="hidden" value = "<?= $valMember->id ?>" name ="id-membership" >
                                                <input type="hidden" value = "<?= $value->id ?>" name ="id-user" >
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic[]" value="8"
																													 <?php
																													 if($valMember->_links->roles[0]->title == "Qa"){
																														 echo "checked ";
																													 }
																													 if(!empty($valMember->_links->roles[1]->title) && $valMember->_links->roles[1]->title == "Qa"){
																														 echo "checked ";;
																													 }
																													 if(!empty($valMember->_links->roles[2]->title) && $valMember->_links->roles[2]->title == "Qa"){
																														 echo "checked ";;
																													 }
																													 if(!empty($valMember->_links->roles[3]->title) && $valMember->_links->roles[3]->title == "Qa"){
																														 echo "checked ";;
																													 }
																													 if(!empty($valMember->_links->roles[4]->title) && $valMember->_links->roles[4]->title == "Qa") {
																														 echo "checked ";;
																													 }
																										?>
																										>
                                                    <label></label>
                                                    <div class="check-terms-item-text">Qa</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic[]" value="3"
																											<?php
																											if($valMember->_links->roles[0]->title == "Project admin"){
																												echo "checked ";
																											}
																											if(!empty($valMember->_links->roles[1]->title) && $valMember->_links->roles[1]->title == "Project admin"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[2]->title) && $valMember->_links->roles[2]->title == "Project admin"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[3]->title) && $valMember->_links->roles[3]->title == "Project admin"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[4]->title) && $valMember->_links->roles[4]->title == "Project admin") {
																												echo "checked ";;
																											}
																											?>
																										>
                                                    <label></label>
                                                    <div class="check-terms-item-text">Project admin</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic[]" value="5"
																											<?php
																											if($valMember->_links->roles[0]->title == "Internship"){
																												echo "checked ";
																											}
																											if(!empty($valMember->_links->roles[1]->title) && $valMember->_links->roles[1]->title == "Internship"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[2]->title) && $valMember->_links->roles[2]->title == "Internship"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[3]->title) && $valMember->_links->roles[3]->title == "Internship"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[4]->title) && $valMember->_links->roles[4]->title == "Internship") {
																												echo "checked ";;
																											}
																											?>
																										>
                                                    <label></label>
                                                    <div class="check-terms-item-text">Internship</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic[]" value="4"
																											<?php
																											if($valMember->_links->roles[0]->title == "Member"){
																												echo "checked ";
																											}
																											if(!empty($valMember->_links->roles[1]->title) && $valMember->_links->roles[1]->title == "Member"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[2]->title) && $valMember->_links->roles[2]->title == "Member"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[3]->title) && $valMember->_links->roles[3]->title == "Member"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[4]->title) && $valMember->_links->roles[4]->title == "Member") {
																												echo "checked ";;
																											}
																											?>
																										>
                                                    <label></label>
                                                    <div class="check-terms-item-text">Member</div>
                                                </div>
                                                <div class="form-item check-terms-item checkbox-custom checkbox-square checkbox-role">
                                                    <input type="checkbox" class="input" name="sharePublic[]" value="7"
																											<?php
																											if($valMember->_links->roles[0]->title == "Developer"){
																												echo "checked ";
																											}
																											if(!empty($valMember->_links->roles[1]->title) && $valMember->_links->roles[1]->title == "Developer"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[2]->title) && $valMember->_links->roles[2]->title == "Developer"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[3]->title) && $valMember->_links->roles[3]->title == "Developer"){
																												echo "checked ";;
																											}
																											if(!empty($valMember->_links->roles[4]->title) && $valMember->_links->roles[4]->title == "Developer") {
																												echo "checked ";;
																											}
																											?>
																										>
                                                    <label></label>
                                                    <div class="check-terms-item-text">Developer</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="status"><?= $value->status ?></td>
                                        <td class="btn-member">
																					<?php
																					if($value->name == $nameUser){
																						foreach($valMember->_links->roles as $roleVariable => $roleValue){
																							if($roleValue->title == "Project admin" || isset($adminProject)){
																								?>
																								<a class="a-action edit-member"><span class="icon-edit"></span></span></a>
																								<?php
																								$idUser = $valMember->_links->principal->href;
																								$idUser = str_replace("/api/v3/users/","",$idUser);
																								?>
																								<a href="<?= base_url('auth/project/'.$identifier.'/member/delete/'.$valMember->id.'/users/'.$idUser.'') ?>"
																									 class="a-action add-spinner"><span class="icon-delete"></span>
																								</a>
																								<?php
																							}
																						}
																					}
																					elseif(isset($adminProject)) {
																						?>
																						<a class="a-action edit-member"><span class="icon-edit"></span></span></a>
																						<?php
																						$idUser = $valMember->_links->principal->href;
																						$idUser = str_replace("/api/v3/users/", "", $idUser);
																						?>
																						<a
																							href="<?= base_url('auth/project/' . $identifier . '/member/delete/' . $valMember->id . '/users/' . $idUser . '') ?>"
																							class="a-action add-spinner"><span class="icon-delete"></span>
																						</a>
																						<?php
																					}
																					?>
                                        </td>
                                    </tr>
                                    <tr class="info-member block-btn-edit">
                                        <td colspan="8">
                                            <div class="btn-toolbar">
                                                <div class="btn-group mr-2">
                                                    <button class="btn-custom no-child btn-bg green btn-update add-spinner" type="submit">
                                                    Update
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn-custom no-child btn-bg btn-cancel btn-cancel-edit-member" type="button">
                                                    Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </form>
                                    <?php 
                                                     }
                                                }
                                            }
                                         }
                                        }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div> <!-- wrapper-table-project-list -->
        </div>
    </div> <!-- wrapper-work-package -->
    </div>
    <div class="menu-pagination">
        <a href="<?= base_url('auth/project/' . $identifier . '/member') ?>" data-ci-pagination-page="1">First  </a>
        <span class="prevlink default">
            <a>
                <span class="icon-chevron-circle-left"></span>
            </a>
        </span>
        <strong>1</strong>
        <div class="nextlink">
            <a data-ci-pagination-page="2" rel="next">
                <span class="icon-chevron-circle-right"></span>
            </a>
        </div>
        <a  data-ci-pagination-page="">Last</a>
    </div>
</div>
