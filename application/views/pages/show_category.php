<div class="section-post-category layout-list-sort">
  <div class="container">
    <div class="scroll-x mobile-item">
      <div class="navigation-list">
        <div class="navigation-list-item">Home</div>
        <div class="navigation-list-item"><?= $category[0]['name'] ?></div>
        <div class="navigation-list-item"><?= $category[1]['name'] ?></div>
      </div>
    </div>
    <div class="layout-list-sort-content">
      <div class="layout-list-sort-content-left">
        <div class="sidebar">
          <div class="sidebar-item active mobile-item" id="show_category_menu">
            <span class="sidebar-item-text"><?= $postType ?></span><span class="quantity-number <?php
              if ($postType == 'videos') {
                  echo 'videos';
              } elseif ($postType == 'presentations') {
                  echo 'presentations';
              } elseif ($postType == 'posters') {
                  echo 'posters';
              } elseif ($postType == 'papers') {
                  echo 'papers';
              } else {
                  echo 'conferences';
              }
              ?>">
                  <?php
                  if ($postType == 'videos') {
                      echo $countVideo;
                  } elseif ($postType == 'presentations') {
                      echo $countPresentation;
                  } elseif ($postType == 'posters') {
                      echo $countPoster;
                  } elseif ($postType == 'papers') {
                      echo $countPaper;
                  } else {
                      echo $countConference;
                  }
                  ?>
            </span>
          </div>
          <div id="category_results_tab" class="nav nav-pills">
            <a class="sidebar-item category-menu-item <?php if ($postType == 'conferences') {
                echo 'active';
            } ?>" id="search_results_conference_tab"
               href="<?= base_url('show-category/conference/' . $category[0]['id'] . '/' . $category[1]['id']) ?>">
              <span class="sidebar-item-text">conferences</span><span
                class="quantity-number conferences"><?= $countConference ?></span>
            </a>
            <a class="sidebar-item category-menu-item <?php if ($postType == 'videos') {
                echo 'active';
            } ?>" id="search_results_video_tab"
               href="<?= base_url('show-category/video/' . $category[0]['id'] . '/' . $category[1]['id']) ?>">
              <span class="sidebar-item-text">videos</span><span class="quantity-number videos"><?= $countVideo ?></span>
            </a>
            <a class="sidebar-item category-menu-item <?php if ($postType == 'presentations') {
                echo 'active';
            } ?>" id="search_results_presentation_tab"
               href="<?= base_url('show-category/presentation/' . $category[0]['id'] . '/' . $category[1]['id']) ?>">
              <span class="sidebar-item-text">presentations</span><span
                class="quantity-number presentations"><?= $countPresentation ?></span>
            </a>
            <a class="sidebar-item category-menu-item <?php if ($postType == 'posters') {
                echo 'active';
            } ?>" id="search_results_poster_tab"
               href="<?= base_url('show-category/poster/' . $category[0]['id'] . '/' . $category[1]['id']) ?>">
              <span class="sidebar-item-text">posters</span><span class="quantity-number posters"><?= $countPoster ?></span>
            </a>
            <a class="sidebar-item category-menu-item <?php if ($postType == 'papers') {
                echo 'active';
            } ?>" id="search_results_paper_tab"
               href="<?= base_url('show-category/paper/' . $category[0]['id'] . '/' . $category[1]['id']) ?>">
              <span class="sidebar-item-text">papers</span><span class="quantity-number papers"><?= $countPaper ?></span>
            </a>
          </div>
        </div>
      </div>
      <div class="layout-list-sort-content-right">
        <div class="results">
          <div class="scroll-x desktop-item">
            <div class="navigation-list">
              <div class="navigation-list-item">Home</div>
              <div class="navigation-list-item"><?= $category[0]['name'] ?></div>
              <div class="navigation-list-item"><?= $category[1]['name'] ?></div>
            </div>
          </div>
          <div class="tab-content" id="search_results_tabContent">
            <div class="results-list tab-pane face <?php if ($postType == 'conferences') {
                echo ' show active';
            } ?>" id="search-results-conference" role="tabpanel"
                 aria-labelledby="search_results_conference_tab">
                <?php if (!empty($conferences)) : ?>
                  <div class="results-title"><?= $category[1]['name'] ?></div>
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
                      <?php endforeach;?>
                  </div>
                  <div class="menu-pagination">
                      <?= $conferences['links'] ?>
                  </div>
                <?php else : ?>
                  <div class="search-none-item">
                    <?php if ($countVideo > 0 || $countPresentation > 0 || $countPoster > 0 || $countPaper > 0): ?>
                      <p>Results were found under
                        <?php
                        if ($countVideo > 0){
                            echo ' videos';
                        }
                        if ($countVideo > 0 && $countPresentation){
                            echo ',';
                        }
                        if ($countPresentation > 0){
                            echo ' presentations';
                        }
                        if ($countPresentation > 0 && $countPoster){
                            echo ',';
                        }
                        if ($countPoster > 0){
                            echo ' posters';
                        }
                        if ($countPoster > 0 && $countPaper){
                            echo ',';
                        }
                        if ($countPaper > 0){
                            echo ' papers';
                        }
                        ?>
                        .</p>
                    <?php else: ?>
                    <p>There are no conferences within this category so far.</p>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
            </div>
            <div class="results-list tab-pane face <?php if ($postType == 'videos') {
                echo ' show active';
            } ?>" id="search-results-video" role="tabpanel"
                 aria-labelledby="search_results_video_tab">
                <?php if (!empty($videos)) : ?>
                  <div class="results-title"><?= $category[1]['name'] ?></div>
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
                          Date
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
                  <div class="row">
                      <?php
                      foreach ($videos['results'] as $result) :
                          $avatar_jpg = 'uploads/userfiles/' . $result->idAuthor . '/profilePhoto.jpg';
                          if (file_exists($avatar_jpg)) {
                              $avatar = $avatar_jpg;
                          } else {
                              $avatar = 'assets/images/small-avatar.jpg';
                          }
                          $banner_file = base_url('/uploads/userfiles/' . $result->idAuthor . '/videos/' . $result->id . '.jpg');
                          ?>
                        <div class="col-md-4">
                          <div class="post-item-custom ">
                            <div class="front-item">
                              <div class="post-item-custom-img">
                                <img src="<?= $banner_file ?>" alt="">
                              </div>
                              <div class="post-item-custom-content">
                                <div class="post-item-custom-content-title"><?= $result->title ?>
                                </div>
                                <div class="post-item-custom-content-desc cate-desc limitTextCategory">
                                    <?= $result->category_name ?> (<?= $result->subcategory_name ?>)
                                </div>
                                <div class="post-item-custom-content-author d-flex align-items-center">
                                  <div class="post-item-custom-content-author-avatar">
                                    <img src="<?= base_url($avatar) ?>" alt="">
                                  </div>
                                  <div class="post-item-custom-content-author-name">
                                      <?= $result->firstName ?> <?= $result->lastName ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail block-white back-item">
                              <div class="item">
                                <div class="item-label">Date of upload:</div>
                                  <?php if (!empty($result->dateOfUpload)): ?>
                                    <div><?= date('d.m.Y', $result->dateOfUpload) ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Co-author:</div>
                                  <?php if (!empty($result->coAuthors)): ?>
                                    <div class="limitTextFurther"><?= $result->coAuthors ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Caption:</div>
                                  <?php if (!empty($result->caption)): ?>
                                    <div class="limitTextFurther"><?= $result->caption ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                                <?php if (isset($_SESSION['login'])) : ?>
                                  <input type="hidden" value="">
                                <?php endif; ?>
                              <div class="btn-custom btn-border green"><a
                                  href="<?= base_url('video/' . $result->id); ?>">View
                                  more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                  </div>
                  <div class="menu-pagination">
                      <?= $videos['links'] ?>
                  </div>
                <?php else : ?>
                  <div class="search-none-item">
                    <p>There are no videos within this category so far.</p>
                  </div>
                <?php endif; ?>
            </div>
            <div class="results-list tab-pane face <?php if ($postType == 'presentations') {
                echo ' show active';
            } ?>" id="search-results-presentation" role="tabpanel"
                 aria-labelledby="search_results_presentation_tab">
                <?php if (!empty($presentations)) : ?>
                  <div class="results-title"><?= $category[1]['name'] ?></div>
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
                          Date
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
                  <div class="row">
                      <?php foreach ($presentations['results'] as $result) :
                          $avatar_jpg = 'uploads/userfiles/' . $result->idAuthor . '/profilePhoto.jpg';
                          if (file_exists($avatar_jpg)) {
                              $avatar = $avatar_jpg;
                          } else {
                              $avatar = 'assets/images/small-avatar.jpg';
                          }
                          $banner_file = base_url('/uploads/userfiles/' . $result->idAuthor . '/presentations/' . $result->id . '.jpg');
                          ?>
                        <div class="col-md-4">
                          <div class="post-item-custom ">
                            <div class="front-item">
                              <div class="post-item-custom-img">
                                <img src="<?= $banner_file ?>" alt="">
                              </div>
                              <div class="post-item-custom-content">
                                <div class="post-item-custom-content-title"><?= $result->presTitle ?>
                                </div>
                                <div class="post-item-custom-content-desc cate-desc limitTextCategory">
                                    <?= $result->category_name ?> (<?= $result->subcategory_name ?>)
                                </div>
                                <div class="post-item-custom-content-author d-flex align-items-center">
                                  <div class="post-item-custom-content-author-avatar">
                                    <img src="<?= base_url($avatar) ?>" alt="">
                                  </div>
                                  <div class="post-item-custom-content-author-name">
                                      <?= $result->firstName ?> <?= $result->lastName ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail block-white back-item">
                              <div class="item">
                                <div class="item-label">Date of upload:</div>
                                  <?php if (!empty($result->dateOfUpload)): ?>
                                    <div><?= date('d.m.Y', $result->dateOfUpload) ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Co-author:</div>
                                  <?php if (!empty($result->coAuthors)): ?>
                                    <div class="limitTextFurther"><?= $result->coAuthors ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Abstract:</div>
                                  <?php if (!empty($result->caption)): ?>
                                    <div class="limitTextFurther"><?= $result->caption ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                                <?php if (isset($_SESSION['login'])) : ?>
                                  <input type="hidden" value="">
                                <?php endif; ?>
                              <div class="btn-custom btn-border green"><a
                                  href="<?= base_url('presentation/' . $result->id); ?>">View
                                  more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                  </div>
                  <div class="menu-pagination">
                      <?= $presentations['links'] ?>
                  </div>
                <?php else : ?>
                  <div class="search-none-item">
                    <p>There are no presentations within this category so far.</p>
                  </div>
                <?php endif; ?>
            </div>
            <div class="results-list tab-pane face <?php if ($postType == 'posters') {
                echo ' show active';
            } ?>" id="search-results-poster" role="tabpanel"
                 aria-labelledby="search_results_poster_tab">
                <?php if (!empty($posters)) : ?>
                  <div class="results-title"><?= $category[1]['name'] ?></div>
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
                          Date
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
                  <div class="row">
                      <?php foreach ($posters['results'] as $result) :
                          $avatar_jpg = 'uploads/userfiles/' . $result->idAuthor . '/profilePhoto.jpg';
                          if (file_exists($avatar_jpg)) {
                              $avatar = $avatar_jpg;
                          } else {
                              $avatar = 'assets/images/small-avatar.jpg';
                          }
                          $banner_file = base_url('/uploads/userfiles/' . $result->idAuthor . '/posters/' . $result->id . '.jpg');
                          ?>
                        <div class="col-md-4">
                          <div class="post-item-custom ">
                            <div class="front-item">
                              <div class="post-item-custom-img">
                                <img src="<?= $banner_file ?>" alt="">
                              </div>
                              <div class="post-item-custom-content">
                                <div class="post-item-custom-content-title"><?= $result->posterTitle ?>
                                </div>
                                <div class="post-item-custom-content-desc cate-desc limitTextCategory">
                                    <?= $result->category_name ?> (<?= $result->subcategory_name ?>)
                                </div>
                                <div class="post-item-custom-content-author d-flex align-items-center">
                                  <div class="post-item-custom-content-author-avatar">
                                    <img src="<?= base_url($avatar) ?>" alt="">
                                  </div>
                                  <div class="post-item-custom-content-author-name">
                                      <?= $result->firstName ?> <?= $result->lastName ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail block-white back-item">
                              <div class="item">
                                <div class="item-label">Date of upload:</div>
                                  <?php if (!empty($result->dateOfUpload)): ?>
                                    <div><?= date('d.m.Y', $result->dateOfUpload) ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Co-author:</div>
                                  <?php if (!empty($result->coAuthors)): ?>
                                    <div class="limitTextFurther"><?= $result->coAuthors ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Abstract:</div>
                                  <?php if (!empty($result->caption)): ?>
                                    <div class="limitTextFurther"><?= $result->caption ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                                <?php if (isset($_SESSION['login'])) : ?>
                                  <input type="hidden" value="">
                                <?php endif; ?>
                              <div class="btn-custom btn-border green"><a
                                  href="<?= base_url('poster/' . $result->id); ?>">View
                                  more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                  </div>
                  <div class="menu-pagination">
                      <?= $posters['links'] ?>
                  </div>
                <?php else : ?>
                  <div class="search-none-item">
                    <p>There are no posters within this category so far.</p>
                  </div>
                <?php endif; ?>
            </div>
            <div class="results-list tab-pane face <?php if ($postType == 'papers') {
                echo ' show active';
            } ?>" id="search-results-paper" role="tabpanel"
                 aria-labelledby="search_results_paper_tab">
                <?php if (!empty($papers)) : ?>
                  <div class="results-title"><?= $category[1]['name'] ?></div>
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
                          Date
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
                  <div class="row">
                      <?php foreach ($papers['results'] as $result) :
                          $avatar_jpg = 'uploads/userfiles/' . $result->idAuthor . '/profilePhoto.jpg';
                          if (file_exists($avatar_jpg)) {
                              $avatar = $avatar_jpg;
                          } else {
                              $avatar = 'assets/images/small-avatar.jpg';
                          }
                          $banner_file = base_url('/uploads/userfiles/' . $result->idAuthor . '/papers/' . $result->id . '.jpg');
                          ?>
                        <div class="col-md-4">
                          <div class="post-item-custom ">
                            <div class="front-item">
                              <div class="post-item-custom-img">
                                <img src="<?= $banner_file ?>" alt="">
                              </div>
                              <div class="post-item-custom-content">
                                <div class="post-item-custom-content-title"><?= $result->paperTitle ?>
                                </div>
                                <div class="post-item-custom-content-desc cate-desc limitTextCategory">
                                    <?= $result->category_name ?> (<?= $result->subcategory_name ?>)
                                </div>
                                <div class="post-item-custom-content-author d-flex align-items-center">
                                  <div class="post-item-custom-content-author-avatar">
                                    <img src="<?= base_url($avatar) ?>" alt="">
                                  </div>
                                  <div class="post-item-custom-content-author-name">
                                      <?= $result->firstName ?> <?= $result->lastName ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail block-white back-item">
                              <div class="item">
                                <div class="item-label">Date of upload:</div>
                                  <?php if (!empty($result->dateOfUpload)): ?>
                                    <div><?= date('d.m.Y', $result->dateOfUpload) ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Co-author:</div>
                                  <?php if (!empty($result->coAuthors)): ?>
                                    <div class="limitTextFurther"><?= $result->coAuthors ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                              <div class="item">
                                <div class="item-label">Abstract:</div>
                                  <?php if (!empty($result->caption)): ?>
                                    <div class="limitTextFurther"><?= $result->caption ?></div>
                                  <?php else: ?>
                                    <div>Empty</div>
                                  <?php endif; ?>
                              </div>
                                <?php if (isset($_SESSION['login'])) : ?>
                                  <input type="hidden" value="">
                                <?php endif; ?>
                              <div class="btn-custom btn-border green"><a
                                  href="<?= base_url('paper/' . $result->id); ?>">View
                                  more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                  </div>
                  <div class="menu-pagination">
                      <?= $papers['links'] ?>
                  </div>
                <?php else : ?>
                  <div class="search-none-item">
                    <p>There are no papers within this category so far.</p>
                  </div>
                <?php endif; ?>
            </div>
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