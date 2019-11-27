<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 07-May-19
 * Time: 16:05
 */
?>
<div class="section-attended-conference managed-conference layout-list-sort">
  <div class="section-attended-conference-title desktop-item">Managed conferences</div>
  <div class="top-content">
    <div class="sm-menu-tab">
      <ul class="menu-post-detail">
        <a class="menu-ongoing active">
          Ongoing
        </a>
        <a class="menu-closed" href="<?= base_url('auth/conference/managed-closed') ?>">
          Closed
        </a>
        <a class="menu-in-preparation" href="<?= base_url('auth/conference/managed-default') ?>">
          In preparation
        </a>
      </ul>
    </div>
  </div>
  <div class="section-attended-conference-title mobile-item">Managed conferences</div>
  <div class="layout-list-sort-content">
    <div class="layout-list-sort-content-right">
      <div class="results">
        <div class="results-list">
            <?php if (!empty($conferences)) : ?>
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
              <div class="conference-row">
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
                    <div class="post-item-custom conference-item managed">
                      <div class="front-item">
                        <div class="post-item-custom-img conference-img">
                            <?php if ($result->fee != 0) : ?>
                              <span class="brand price">&euro; <?= number_format($result->fee, 2) ?></span>
                            <?php else: ?>
                              <span class="brand free">Free</span>
                            <?php endif; ?>
                          <img src="<?= $banner_file ?>" alt="">
                        </div>
                        <div class="post-item-custom-content">
                          <div class="post-item-custom-content-title"> <?= $result->confTitle ?></div>
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
                          <div class="post-item-custom-content-role d-flex align-items-end">
                            <span class="icon-host"></span>
                            <div><?php if ($result->userID == $userID) echo "Host"; else echo "Co-editor"; ?></div>
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
                          <a href="<?= base_url('auth/conference/conference-page/' . $result->id); ?>">View more</a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
              </div>
              <div class="menu-pagination">
                  <?= $conferences['links'] ?>
              </div>
            <?php else : ?>
              <div class="search-none-item">
                <p>You have not managed any conferences hosted on our platform so far.</p>
                <div class="btn-custom btn-bg green btn-start">
                  <a href="<?= base_url('auth/conference/order-cid') ?>">Start here</a>
                </div>
              </div>
            <?php endif; ?>
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
