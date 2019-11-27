<div class="section-project section-project-document layout-list-sort">
  <div class="project-layout-list-sort">
    <div class="d-flex">
      <div class="mr-auto">
        <a class="layout-list-status">All open</a>
      </div>
      <div>
        <a class="btn btn-custom btn-bg btn-create" href="<?= base_url('auth/project/'.$identifier.'/add-document') ?>">&#43;&nbsp;Document</a>
      </div>
    </div>
  </div>
  <div class="project-layout-documents">
    <div class="block-category">
        <?php
        if (!empty($documents)):
            foreach ($documents as $document):
                ?>
              <div class="document-item">
                <div class="block-document">
                  <a href="<?= base_url('auth/project/'. $identifier .'/document-detail/' . $document['id']) ?>" class="document-title">
                      <?= $document['title'] ?>
                  </a>
                  <div class="document-time-publishing">
                      <?php
                      $date = date_create($document['createdAt']);
                      echo date_format($date, "m/d/Y h:i A"); ?>
                  </div>
                  <div class="document-description">
                      <?php echo $document['description'] ?>
                  </div>
                </div>
              </div>
            <?php endforeach; endif; ?>
    </div>
    <!--            <div class="block-category">-->
    <!--                <button class="btn dropdown-toggle active-custom btn-category" type="button" data-toggle="collapse" data-target="#lastActivity">-->
    <!--                    Latest activity-->
    <!--                </button>-->
    <!--                <div class="collapse show" id="lastActivity">-->
    <!--                    <a href="document-detail/1">-->
    <!--                        <div class="block-document">-->
    <!--                            <div class="document-title">-->
    <!--                                Yan Bui-->
    <!--                            </div>-->
    <!--                            <div class="document-time-publishing">-->
    <!--                                06/26/2019 09:30 AM-->
    <!--                            </div>-->
    <!--                            <div class="document-description">-->
    <!--                                Visual Extension of Litchi Film on Web <br>-->
    <!--                                We are open to new projects! Please check out.-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                    <a href="document-detail/1">-->
    <!--                        <div class="block-document">-->
    <!--                            <div class="document-title">-->
    <!--                                What's Coming in 2019-->
    <!--                            </div>-->
    <!--                            <div class="document-time-publishing">-->
    <!--                                06/26/2019 09:30 AM-->
    <!--                            </div>-->
    <!--                            <div class="document-description">-->
    <!--                                2018 was a momentous year for Simpletext. The first version was launched in June as a single screen app with absolutely nothing but a blank slate for you to write on. Since then, I've introduced various improvements in subsequent updates, many of them based on your feedback, all while maintaining the simplicity that Simpletext stood for....-->
    <!--                            </div>-->
    <!--                        </div> -->
    <!--                    </a>-->
    <!--                </div>   -->
    <!--            </div> -->
    <!--            <div class="block-category">-->
    <!--                <button class="btn dropdown-toggle active-custom btn-category" type="button" data-toggle="collapse" data-target="#specification">-->
    <!--                    SPECIFICATION-->
    <!--                </button>-->
    <!--                <div class="collapse show" id="specification">-->
    <!--                    <a href="document-detail/1">-->
    <!--                        <div class="block-document">-->
    <!--                            <div class="document-title">-->
    <!--                                xuan-->
    <!--                            </div>-->
    <!--                            <div class="document-time-publishing">-->
    <!--                                06/26/2019 09:30 AM-->
    <!--                            </div>-->
    <!--                        </div> -->
    <!--                    </a>-->
    <!--                    <a href="document-detail/1">-->
    <!--                        <div class="block-document">-->
    <!--                            <div class="document-title">-->
    <!--                                Yan Bui 2-->
    <!--                            </div>-->
    <!--                            <div class="document-time-publishing">-->
    <!--                                06/26/2019 09:30 AM-->
    <!--                            </div>-->
    <!--                            <div class="document-description">-->
    <!--                                Trading module of the app with manual and AI based trading options. <br>-->
    <!--                                Undo is one of those features you don't really notice until you need it. The iPad has a built-in Undo button on the keyboard, but not the iPhone - the only way to undo on the iPhone is by shaking the device. I find that really awkward, so I decided early on that Simpletext must provide another way to undo....-->
    <!--                            </div>-->
    <!--                        </div> -->
    <!--                    </a>-->
    <!--                </div>-->
    <!--            </div> -->
  </div>
</div>