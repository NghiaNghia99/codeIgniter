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
        <a class="menu-ongoing" href="<?= base_url('auth/conference/managed') ?>">
          Ongoing
        </a>
        <a class="menu-closed" href="<?= base_url('auth/conference/managed-closed') ?>">
          Closed
        </a>
        <a class="menu-in-preparation active">
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
              <div class="conference-row">
                  <?php foreach ($conferences['results'] as $result) : ?>
                    <div class="post-item-custom conference-item managed">
                      <div class="front-item">
                        <div class="post-item-custom-img conference-img">
                          <img class="desktop-item" src="<?= base_url('/assets/images/img-conference.jpg') ?>" alt="">
                          <img class="mobile-item" src="<?= base_url('/assets/images/img-conference-mobile.jpg') ?>" alt="">
                        </div>
                        <div class="post-item-custom-content">
                          <div class="post-item-custom-content-title">
                              <?php
                              if (!empty($result->confTitle)) {
                                  echo $result->confTitle;
                              } else {
                                  echo 'Empty';
                              }
                              ?>
                          </div>
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
                            <div>Host</div>
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
                          <a href="<?= base_url('auth/conference/managed/conference-edit/basic-information/' . $result->id); ?>">View more</a>
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
                <p>You are not having any in preparation conference on our platform so far</p>
                <div class="btn-custom btn-bg green btn-start">
                  <a href="<?= base_url('auth/conference/order-cid') ?>">Start here</a>
                </div>
              </div>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
