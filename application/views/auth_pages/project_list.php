
<div class="section-project section-project-list section-project-list-package">
    <div class="scroll-x">
        <div class="project-layout-list-sort">
            <div class="d-flex">
                <div class="mr-auto btn-list-sort">
                    <a class="layout-list-status">
                        <?php 
                            if(!empty($listProject)):
                                echo 'List project';
                            endif;
                        ?></a>
                </div>
                <div class="btn-list-sort">
                    <a class="btn-border green btn-order-pid" href="<?= base_url('auth/project/work-package/order-pid') ?>">Order PID</a>
                </div>
            </div>
        </div>
        <div class="wrapper-table-list">
            <div class="table-list table-list-project">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <tbody>
                            <?php 
                                if(!empty($listProject)):
                                    $numberID = 0;
                                foreach($listProject as $variable => $value):
                                    $numberID++;
                            ?>
                            <tr>
                                <td class="ordinal-number"><?= $numberID ?></td>
                                <td class="name-project"><a class="add-spinner" href="<?= base_url('auth/project/'.$value->identifierPID.'/work-package') ?>"><?=$value->pid ?></a> </td>
                            </tr>
                            <?php endforeach; 
                            else: 
                            ?>
                            <div class="block-img-no-project">
                                <img src="<?= base_url('/assets/images/img-avatar-no-project.png') ?>" alt="" />
                                <div class="no-project">No new project</div>
                            </div>
                            <?php
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
