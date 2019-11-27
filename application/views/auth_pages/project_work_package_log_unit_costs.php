<div class="section-project section-project-work-package-more-option">
    <div class="scroll-x">
        <div class="title-page">
            <div class="prev-page">
                <span class="icon icon-arrow-down"></span>Log unit costs  
            </div>
            <hr>
        </div>
        <div class="project-layout-content project-layout-new-task">
            <form method="post">
                <div class="body-content">
                    <div class="title-move">
                        &nbsp;
                    </div>
                    <div class="form-item">
                        <div class="block-change-properties block-overview">
                            <div class="block-overview-title">
                            &nbsp;
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6 select-col">
                                    <div class="form-item block-work-package">
                                        <label class="form-label label-custom">
                                        Work package *
                                        </label>
                                        <input type="input" name="work-package" class="form-control" placeholder="" value=""/>
                                        <small id="helpId" class="form-text text-muted">Phase #18: Develop v1.0</small>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item input-group datetime-picker">
                                        <label class="form-label label-custom">
                                        Date*
                                        </label>
                                        <input class="input-custom input-medium datepicker startDate" 
                                        name="startDate" data-date-format="dd.mm.yyyy"
                                        value="12.08.2019">
                                        <div class="error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        User*
                                        </label>
                                        <select name="user" class="form-control select-custom">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item">
                                        <label class="form-label label-custom">
                                        Cost type
                                        </label>
                                        <select name="cost-type" class="form-control select-custom">
                                        <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item block-hours">
                                        <label class="form-label label-custom">
                                        Units*
                                        </label>
                                        <div class="input-group input-cost" title="Click here to edit">
                                            <input type="number" class="form-control input-hours" name="units" placeholder="" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text block-white hours">hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 select-col">
                                    <div class="form-item block-edit-costs">
                                        <label class="form-label label-custom">
                                        Costs
                                        </label>
                                        <div class="input-group input-cost cost" title="Click here to edit">
                                            <input type="text" class="form-control input-cost" name="cost" placeholder="" value="0.00USD" readOnly>
                                            <div class="input-group-append">
                                                <span class="btn icon-edit"></span>  
                                            </div>
                                        </div>
                                        <div class="input-group input-cost edit-cost">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text icon-cancel icon-cancel-save-edit"></span>
                                            </div>
                                            <input type="number" class="form-control input-edit-cost" name="edit-cost" value="s">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text currency">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <div class="block-overview">
                            <label class="form-label label-custom">
                            Comment
                            </label>
                            <input type="text" class="form-control input-comment" name="comment" placeholder="" value="">
                        </div>
                    </div>
                </div>
                <div class="footer-content">
                    <div class="btn-toolbar">
                        <div class="btn-group mr-2">
                            <button class="btn-custom btn-bg green btn-save">
                                Save
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