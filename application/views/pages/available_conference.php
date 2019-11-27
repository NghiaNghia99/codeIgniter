<div class="section-post-category layout-list-sort available-conference">
  <div class="container">
    <div class="scroll-x mobile-item">
      <div class="navigation-list">
        <div class="navigation-list-item">Home</div>
        <div class="navigation-list-item">Available Conferences</div>
      </div>
    </div>
    <div class="layout-list-sort-content">
      <div class="results">
        <div class="scroll-x desktop-item">
          <div class="navigation-list">
            <div class="navigation-list-item">Home</div>
            <div class="navigation-list-item">Available Conferences</div>
          </div>
        </div>
        <div class="tab-content" id="search_results_tabContent">
          <div class="results-list tab-pane face show active" id="search-results-conference" role="tabpanel"
               aria-labelledby="search_results_conference_tab">
              <?php if (!empty($conferences)) : ?>
                <div class="results-title available-conference"><span>Available Conferences</span><span><?= $category[0]['name'] ?></span></div>
                <div class="sort desktop-item">
                  <div class="sort-item">
                    <div class="sort-item-title">Sort by</div>
                    <div class="dropdown dropdown-sort-custom dropdown-mobile-custom">
                      <button class="btn dropdown-toggle" type="button" id="dropdownSortView" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">
                        View
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownSortView">
                        <a
                          class="dropdown-item sort-item-content get-sort <?php if ($active_sort == 'Max') {
                              echo ' active-custom';
                          } ?>">Max</a>
                        <a
                          class="dropdown-item sort-item-content get-sort <?php if ($active_sort == 'Min') {
                              echo ' active-custom';
                          } ?>">Min</a>
                      </div>
                    </div>
                  </div>
                  <div class="sort-item">
                    <div class="sort-item-title">Sort by</div>
                    <div class="dropdown dropdown-sort-custom dropdown-mobile-custom">
                      <button class="btn dropdown-toggle" type="button" id="dropdownSortView" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">
                        End date
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownSortView">
                        <a
                          class="dropdown-item sort-item-content get-sort <?php if ($active_sort == 'Youngest') {
                              echo ' active-custom';
                          } ?>">Youngest</a>
                        <a
                          class="dropdown-item sort-item-content get-sort <?php if ($active_sort == 'Oldest') {
                              echo ' active-custom';
                          } ?>">Oldest</a>
                      </div>
                    </div>
                  </div>
                  <div class="sort-item">
                    <div class="sort-item-title">Sort by</div>
                    <div class="dropdown dropdown-sort-custom dropdown-mobile-custom">
                      <button class="btn dropdown-toggle" type="button" id="dropdownSortView" data-toggle="dropdown"
                              aria-haspopup="true" aria-expanded="false">
                        Alphabetical
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownSortView">
                        <a
                          class="dropdown-item sort-item-content get-sort <?php if ($active_sort == 'A-Z') {
                              echo ' active-custom';
                          } ?>">A-Z</a>
                        <a
                          class="dropdown-item sort-item-content get-sort <?php if ($active_sort == 'Z-A') {
                              echo ' active-custom';
                          } ?>">Z-A</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="sort mobile-item">
                  <div class="btn-custom btn-border btn-sort" data-toggle="modal" data-target="#sortModal">
                    Sort
                  </div>
                </div>
                <div class="row conference-row-custom">
                    <?php foreach ($conferences['results'] as $result) :
                        $relativeDir = base_url('/uploads/userfiles/' . $result->userID . '/conferences/' . $result->id);
                        if (!empty($result->filenameBanner_original)) {
                            $ext_ = pathinfo($result->filenameBanner_original);
                            $ext = $ext_['extension'];
                            $banner_file = $relativeDir . '/ConferenceBanner.' . $ext;
                        } else {
                            $banner_file = base_url('/assets/images/img-conference.png');
                        }
                        ?>
                    <div class="col-md-4">
                      <div class="post-item-custom conference-item">
                        <div class="front-item">
                          <div class="post-item-custom-img conference-img">
                            <span class="group-label card-item">
                              <?php if ($result->fee != 0) : ?>
                                <span class="brand-item price">&euro; <?= number_format($result->fee, 2) ?></span>
<!--                                --><?php //if ($result->status == 'Unpaid') : ?>
<!--                                  <span class="brand-item status not-paid">Unpaid</span>-->
<!--                                  --><?php //elseif($result->status == 'completed'): ?>
<!--                                  <span class="brand-item status paid">Paid</span>-->
<!--                                  --><?php //elseif($result->status == 'pending' || $result->status == 'unclaimed'): ?>
<!--                                  <span class="brand-item status pending">Pending</span>-->
<!--                                  --><?php //else: ?>
<!--                                  <span class="brand-item status refund">Others</span>-->
<!--                                  --><?php //endif; ?>
                              <?php else: ?>
                                <span class="brand-item free">Free</span>
                              <?php endif; ?>
                            </span>
                            <img src="<?= $banner_file ?>" alt="">
                          </div>
                          <div class="post-item-custom-content">
                            <div class="post-item-custom-content-title"><?= $result->confTitle ?></div>
                            <div class="post-item-custom-content-cid d-flex align-items-end">
                              <span class="icon-cid"></span>
                              <div>
                                  <?php
                                  if (!empty($result->CID)) {
                                      echo $result->CID;
                                  } else {
                                      echo 'Empty';
                                  }
                                  ?>
                              </div>
                            </div>
                            <div class="post-item-custom-content-location">
                              <span class="icon-location"></span>
                              <div>
                                  <?php
                                  if (!empty($result->confLocation)) {
                                      echo $result->confLocation;
                                  } else {
                                      echo '<p>Empty</p>';
                                  }
                                  ?>
                              </div>
                            </div>
                            <div class="post-item-custom-content-date d-flex align-items-end">
                              <span class="icon-calendar"></span>
                              <div>
                                  <?php
                                  if (!empty($result->startDate) && !empty($result->endDate)) {
                                      echo date('d.m.Y', $result->startDate) . ' - ' . date('d.m.Y', $result->endDate);
                                  } else {
                                      echo 'Empty';
                                  }
                                  ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="post-item-custom-detail block-white back-item">
                          <div class="show-info-item-mr-8 conference-item">
                            <span>Website host by: </span>
                            <span><?= $result->firstName ?> <?= $result->lastName ?></span>
                          </div>
                          <div class="show-info-item-mr-8 conference-item">
                            <span>Main Category: </span>
                            <span><?= $result->category_name ?> (<?= $result->subcategory_name ?>)</span>
                          </div>
                          <div class="show-info-item-mr-8 conference-item">
                            <span>Views: </span>
                            <span><?= $result->views ?></span>
                          </div>
                            <?php if (isset($_SESSION['login'])) : ?>
                              <input type="hidden" value="">
                            <?php endif; ?>
                          <div class="btn-custom btn-border green">
                            <a href="<?= base_url('conference/' . $result->id); ?>">View more</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="menu-pagination">
                    <?= $conferences['links'] ?>
                </div>
              <?php else : ?>
                <div>
                  <div class="results-title available-conference"><span>Available Conferences</span><span><?= $category[0]['name'] ?></span></div>

                  <p>There are no conferences within this category so far.</p>
                </div>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade modal-sort" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content modal-sort-content">
        <div class="modal-body">
          <div class="title small-title">Sort</div>
          <div class="sort-item">
            <div class="sort-item-title">View</div>
            <div class="checkbox-custom">
              <input type="radio" class="input get-sort" name="sort-views"
                     value="1" <?php if ($active_sort == 'Max') {
                  echo 'checked';
              } ?>>
              <label></label>
              <a class="checkbox-custom-text sort-item-content <?php if ($active_sort == 'Max') {
                  echo ' active-custom';
              } ?>">Max</a>
            </div>
            <div class="checkbox-custom">
              <input type="radio" class="input get-sort" name="sort-views"
                     value="1" <?php if ($active_sort == 'Min') {
                  echo 'checked';
              } ?>>
              <label></label>
              <a class="checkbox-custom-text sort-item-content <?php if ($active_sort == 'Min') {
                  echo ' active-custom';
              } ?>">Min</a>
            </div>
          </div>
          <div class="sort-item">
            <div class="sort-item-title">End date</div>
            <div class="checkbox-custom">
              <input type="radio" class="input get-sort" name="sort-date"
                     value="1" <?php if ($active_sort == 'Youngest') {
                  echo 'checked';
              } ?>>
              <label></label>
              <a class="checkbox-custom-text sort-item-content <?php if ($active_sort == 'Youngest') {
                  echo ' active-custom';
              } ?>">Youngest</a>
            </div>
            <div class="checkbox-custom">
              <input type="radio" class="input get-sort" name="sort-date"
                     value="1" <?php if ($active_sort == 'Oldest') {
                  echo 'checked';
              } ?>>
              <label></label>
              <a class="checkbox-custom-text sort-item-content <?php if ($active_sort == 'Oldest') {
                  echo ' active-custom';
              } ?>">Oldest</a>
            </div>
          </div>
          <div class="sort-item">
            <div class="sort-item-title">Alphabetical</div>
            <div class="checkbox-custom">
              <input type="radio" class="input get-sort" name="sort-alpha"
                     value="1" <?php if ($active_sort == 'A-Z') {
                  echo 'checked';
              } ?>>
              <label></label>
              <a class="checkbox-custom-text sort-item-content <?php if ($active_sort == 'A-Z') {
                  echo ' active-custom';
              } ?>">A-Z</a>
            </div>
            <div class="checkbox-custom">
              <input type="radio" class="input get-sort" name="sort-alpha"
                     value="1" <?php if ($active_sort == 'Z-A') {
                  echo 'checked';
              } ?>>
              <label></label>
              <a class="checkbox-custom-text sort-item-content <?php if ($active_sort == 'Z-A') {
                  echo ' active-custom';
              } ?>">Z-A</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>