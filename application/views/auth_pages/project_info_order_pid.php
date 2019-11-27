<div class="section-project section-project-list section-project-info-order-pid">
    <div class="scroll-x">
        <div class="wrapper-info-order-pid">
            <div class="title-order-pid">
                <div class="type">PID</div>
                <span><?= $pid->pid ?></span>
            </div>
            <div class="wrapper-block-info">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3 block-info">
                            <div class="_block">
                                <div class="block-info-title">First name</div>
                                <div class="block-info-value"><?= $pid->contactFirstName ?></div>
                            </div>
                            <div class="_block">
                                <div class="block-info-title">Last name</div>
                                <div class="block-info-value"><?= $pid->contactLastName ?></div>
                            </div>
                            <div class="_block">
                                <div class="block-info-title">Email</div>
                                <div class="block-info-value"><?= $pid->contactEMail ?></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 block-info">
                            <div class="_block">
                                <div class="block-info-title">Affiliation</div>
                                <div class="block-info-value"><?= $pid->billingAffiliation ?></div>
                            </div>
                            <div class="_block">
                                <div class="block-info-title">Billing street</div>
                                <div class="block-info-value"><?= $pid->billingStreet ?></div>
                            </div>
                            <div class="_block">
                                <div class="block-info-title">Billing street Nr</div>
                                <div class="block-info-value"><?= $pid->billingStreetNr ?></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 block-info">
                            <div class="_block">
                                <div class="block-info-title">Billing city</div>
                                <div class="block-info-value"><?= $pid->billingCity ?></div>
                            </div>
                            <div class="_block">
                                <div class="block-info-title">Billing postal code</div>
                                <div class="block-info-value"><?= $pid->billingPostalCode ?></div>
                            </div>
                            <div class="_block">
                                <div class="block-info-title">Billing state</div>
                                <div class="block-info-value"><?php if (!empty($pid->billingState)) echo $pid->billingState; else echo 'Empty'; ?></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 block-info">
                            <div class="_block">
                                <div class="block-info-title">Billing country</div>
                                <div class="block-info-value"><?= $pid->billingCountry ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-toolbar">
                            <div class="btn-group mr-2">
                              <form class="paypal paypal_form" action="<?= base_url('auth/project/work-package/order-pid/checkout') ?>" method="post">
                                <input type="hidden" name="pid" value="<?= $pid->pid ?>" />
                                <input type="submit" class="add-spinner btn-custom btn-bg green btn-buy-project" value="Pay now"/>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>