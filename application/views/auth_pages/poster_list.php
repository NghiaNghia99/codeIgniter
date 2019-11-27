<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 03-May-19
 * Time: 15:21
 */
?>
<div class="section-object-list layout-list-sort">
  <div class="section-object-list-title">Shared posters</div>
  <div class="section-object-list-content results">
    <nav>
      <div class="nav nav-tabs" id="nav-tab-poster-list" role="tablist">
        <a class="nav-item nav-link active" id="nav-poster-list-tab" data-toggle="tab" href="#nav-poster-list" role="tab" aria-controls="nav-poster-list" aria-selected="true">Poster list</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabPosterList">
      <div class="results-list tab-pane fade show active" id="nav-poster-list" role="tabpanel" aria-labelledby="nav-poster-list-tab">
          <?php if (!empty($posts)) : ?>
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
            <div class="object-list-row">
                <?php foreach ($posts['results'] as $result) :
                    $banner_file = base_url('/uploads/userfiles/' . $result->idAuthor . '/posters/' . $result->id . '.jpg');
                    ?>
                  <div class="post-item-custom width-370">
                    <div class="front-item">
                      <div class="post-item-custom-img">
                        <img src="<?= $banner_file ?>" alt="">
                      </div>
                      <div class="post-item-custom-content">
                        <div class="post-item-custom-content-title"><?= $result->posterTitle ?></div>
                        <div class="post-item-custom-content-category limitTextCategory">
                            <?= $result->category_name ?> (<?= $result->subcategory_name ?>)
                        </div>
                        <div class="post-item-custom-content-views d-flex align-items-center">
                          <span class="icon-views"></span>
                          <div><?= number_format($result->views) ?> views</div>
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
                      <div class="btn-custom btn-border green">
                        <a href="<?= base_url('auth/content/poster/' . $result->id); ?>">View more</a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
            </div>
            <div class="menu-pagination">
                <?= $posts['links'] ?>
            </div>
          <?php else : ?>
            <div class="list-none-item">
              <p>You have not uploaded any posters yet.</p>
              <a class="link" href="<?= base_url('auth/content/poster/upload') ?>">Upload your first poster here.</a>
            </div>
          <?php endif; ?>
      </div>
    </div>
  </div>
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
            <div class="sort-item-title">Date</div>
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
