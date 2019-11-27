<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 19-Apr-19
 * Time: 17:26
 */

?>
<div class="section-intro">
  <div class="section-intro-slide">
    <div class="container">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?= base_url('/assets/images/img-home-slider.jpg') ?>" class="d-block w-100 desktop-item"
                 alt="...">
            <img src="<?= base_url('/assets/images/img-home-slider-mobile.jpg') ?>" class="d-block w-100 mobile-item"
                 alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= base_url('/assets/images/img-home-slider.jpg') ?>" class="d-block w-100 desktop-item"
                 alt="...">
            <img src="<?= base_url('/assets/images/img-home-slider-mobile.jpg') ?>" class="d-block w-100 mobile-item"
                 alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= base_url('/assets/images/img-home-slider.jpg') ?>" class="d-block w-100 desktop-item"
                 alt="...">
            <img src="<?= base_url('/assets/images/img-home-slider-mobile.jpg') ?>" class="d-block w-100 mobile-item"
                 alt="...">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-intro-description">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="item">
            <div class="item-img">
              <img src="<?= base_url('/assets/images/img-home-intro-1.png') ?>" alt="introduction">
            </div>
            <div class="item-text">
                <?php echo lang('home_intro_research'); ?>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="item">
            <div class="item-img">
              <img src="<?= base_url('/assets/images/img-home-intro-2.png') ?>" alt="introduction">
            </div>
            <div class="item-text">
                <?php echo lang('home_intro_network'); ?>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="item">
            <div class="item-img">
              <img src="<?= base_url('/assets/images/img-home-intro-3.png') ?>" alt="introduction">
            </div>
            <div class="item-text">
                <?php echo lang('home_intro_upload'); ?>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="item">
            <div class="item-img">
              <img src="<?= base_url('/assets/images/img-home-intro-4.png') ?>" alt="introduction">
            </div>
            <div class="item-text">
                <?php echo lang('home_intro_share'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="section-make-conference">
  <div class="section-make-conference-content">
    <div class="title">Make your conference world-wide visible</div>
    <div class="desc">Full conference: <span>299&euro; + VAT only!</span></div>
    <div class="btn btn-custom btn-bg white"><a href="<?php
        echo base_url('auth/conference/order-cid');
        ?>">Order Conference ID</a></div>
  </div>
</div>
<div class="section-feature">
  <div class="container">
    <div class="title big-title">Featured</div>
    <ul class="nav nav-tabs post-type" id="listPostHomeTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link post-type-item active" id="video-tab" data-toggle="tab" href="#video" role="tab"
           aria-controls="video" aria-selected="true">Videos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link post-type-item" id="poster-tab" data-toggle="tab" href="#poster" role="tab"
           aria-controls="poster" aria-selected="false">Posters</a>
      </li>
      <li class="nav-item">
        <a class="nav-link post-type-item" id="presentation-tab" data-toggle="tab" href="#presentation" role="tab"
           aria-controls="presentation" aria-selected="false">Presentations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link post-type-item" id="paper-tab" data-toggle="tab" href="#paper" role="tab"
           aria-controls="paper" aria-selected="false">Papers</a>
      </li>
    </ul>
    <div class="tab-content" id="listPostTabContent">
      <div class="tab-pane fade show active" id="video" role="tabpanel" aria-labelledby="video-tab">
        <div class="row" id="video_list_home">
            <?php if (!empty($movies)): foreach ($movies as $post):
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '.jpg');
                ?>
              <div class="col-md-3">
                <div class="post-item-custom post-item-home">
                  <div class="front-item">
                    <div class="post-item-custom-img">
                      <img src="<?= $banner_file ?>" alt="">
                    </div>
                    <div class="post-item-custom-content">
                      <div class="post-item-custom-content-title"><?= $post['title']; ?></div>
                      <div class="post-item-custom-content-desc cate-desc "><?= $post['category_name'] ?>
                        (<?= $post['subcategory_name'] ?>)
                      </div>
                      <div class="post-item-custom-content-author d-flex align-items-center">
                        <div class="post-item-custom-content-author-avatar">
                          <img src="<?= base_url($avatar) ?>" alt="">
                        </div>
                        <div class="post-item-custom-content-author-name">
                            <?= $post['firstName'] . ' ' . $post['lastName'] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-item-custom-detail block-white back-item">
                    <div class="item">
                      <div class="item-label">Date of upload:</div>
                        <?php if (!empty($post['dateOfUpload'])): ?>
                          <div><?= date('d.m.Y', $post['dateOfUpload']) ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Co-author:</div>
                        <?php if (!empty($post['coAuthors'])): ?>
                          <div class="limitTextFurther"><?= $post['coAuthors'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Caption:</div>
                        <?php if (!empty($post['caption'])): ?>
                          <div class="limitTextFurther"><?= $post['caption'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                      <?php if (isset($_SESSION['login'])) : ?>
                        <input type="hidden" value="<?= $post['idAuthor'] ?>">
                      <?php endif; ?>
                    <div class="btn-custom btn-border green">
                      <a href="<?= base_url('video/' . $post['id']); ?>">View more</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; else: echo 'There are no uploaded videos yet'; endif; ?>
        </div>
          <?php
          if (!empty($countVideos) && $countVideos > 8): ?>
            <div class="btn-custom btn-bg green btn-explore-more">
              <input type="hidden" id="start_video" value="8">
              <input type="hidden" id="total_video" value="<?= $countVideos ?>">
              <a id="explore_more_video">Explore more</a>
            </div>
          <?php endif; ?>
      </div>
      <div class="tab-pane fade" id="poster" role="tabpanel" aria-labelledby="poster-tab">
        <div class="row" id="poster_list_home">
            <?php if (!empty($posters)): foreach ($posters as $post):
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/posters/' . $post['id'] . '.jpg');
                ?>
              <div class="col-md-3">
                <div class="post-item-custom post-item-home">
                  <div class="front-item">
                    <div class="post-item-custom-img">
                      <img src="<?= $banner_file ?>" alt="">
                    </div>
                    <div class="post-item-custom-content">
                      <div class="post-item-custom-content-title"><?= $post['posterTitle']; ?></div>
                      <div class="post-item-custom-content-desc cate-desc "><?= $post['category_name'] ?>
                        (<?= $post['subcategory_name'] ?>)
                      </div>
                      <div class="post-item-custom-content-author d-flex align-items-center">
                        <div class="post-item-custom-content-author-avatar">
                          <img src="<?= base_url($avatar) ?>" alt="">
                        </div>
                        <div class="post-item-custom-content-author-name">
                            <?= $post['firstName'] . ' ' . $post['lastName'] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-item-custom-detail block-white back-item">
                    <div class="item">
                      <div class="item-label">Date of upload:</div>
                        <?php if (!empty($post['dateOfUpload'])): ?>
                          <div><?= date('d.m.Y', $post['dateOfUpload']) ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Co-author:</div>
                        <?php if (!empty($post['coAuthors'])): ?>
                          <div class="limitTextFurther"><?= $post['coAuthors'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Abstract:</div>
                        <?php if (!empty($post['caption'])): ?>
                          <div class="limitTextFurther"><?= $post['caption'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                      <?php if (isset($_SESSION['login'])) : ?>
                        <input type="hidden" value="<?= $post['idAuthor'] ?>">
                      <?php endif; ?>
                    <div class="btn-custom btn-border green"><a href="<?= base_url('poster/' . $post['id']); ?>">View
                        more</a></div>
                  </div>
                </div>
              </div>
            <?php endforeach; else: echo 'There are no uploaded posters yet'; endif; ?>
        </div>
          <?php
          if (!empty($countPosters) && $countPosters > 8): ?>
            <div class="btn-custom btn-bg green btn-explore-more">
              <input type="hidden" id="start_poster" value="8">
              <input type="hidden" id="total_poster" value="<?= $countPosters ?>">
              <a id="explore_more_poster">Explore more</a>
            </div>
          <?php endif; ?>
      </div>
      <div class="tab-pane fade" id="presentation" role="tabpanel" aria-labelledby="presentation-tab">
        <div class="row" id="presentation_list_home">
            <?php if (!empty($presentations)): foreach ($presentations as $post):
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/presentations/' . $post['id'] . '.jpg');
                ?>
              <div class="col-md-3">
                <div class="post-item-custom post-item-home">
                  <div class="front-item">
                    <div class="post-item-custom-img">
                      <img src="<?= $banner_file ?>" alt="">
                    </div>
                    <div class="post-item-custom-content">
                      <div class="post-item-custom-content-title"><?= $post['presTitle']; ?></div>
                      <div class="post-item-custom-content-desc cate-desc "><?= $post['category_name'] ?>
                        (<?= $post['subcategory_name'] ?>)
                      </div>
                      <div class="post-item-custom-content-author d-flex align-items-center">
                        <div class="post-item-custom-content-author-avatar">
                          <img src="<?= base_url($avatar) ?>" alt="">
                        </div>
                        <div class="post-item-custom-content-author-name">
                            <?= $post['firstName'] . ' ' . $post['lastName'] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-item-custom-detail block-white back-item">
                    <div class="item">
                      <div class="item-label">Date of upload:</div>
                        <?php if (!empty($post['dateOfUpload'])): ?>
                          <div><?= date('d.m.Y', $post['dateOfUpload']) ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Co-author:</div>
                        <?php if (!empty($post['coAuthors'])): ?>
                          <div class="limitTextFurther"><?= $post['coAuthors'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Abstract:</div>
                        <?php if (!empty($post['caption'])): ?>
                          <div class="limitTextFurther"><?= $post['caption'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                      <?php if (isset($_SESSION['login'])) : ?>
                        <input type="hidden" value="<?= $post['idAuthor'] ?>">
                      <?php endif; ?>
                    <div class="btn-custom btn-border green"><a href="<?= base_url('presentation/' . $post['id']); ?>">View
                        more</a></div>
                  </div>
                </div>
              </div>
            <?php endforeach; else: echo 'There are no uploaded presentations yet'; endif; ?>
        </div>
          <?php
          if (!empty($countPresentations) && $countPresentations > 8): ?>
            <div class="btn-custom btn-bg green btn-explore-more">
              <input type="hidden" id="start_presentation" value="8">
              <input type="hidden" id="total_presentation" value="<?= $countPresentations ?>">
              <a id="explore_more_presentation">Explore more</a>
            </div>
          <?php endif; ?>
      </div>
      <div class="tab-pane fade" id="paper" role="tabpanel" aria-labelledby="paper-tab">
        <div class="row" id="paper_list_home">
            <?php if (!empty($papers)): foreach ($papers as $post):
                $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                if (file_exists($avatar_jpg)) {
                    $avatar = $avatar_jpg;
                } else {
                    $avatar = 'assets/images/small-avatar.jpg';
                }
                $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/papers/' . $post['id'] . '.jpg');
                ?>
              <div class="col-md-3">
                <div class="post-item-custom post-item-home">
                  <div class="front-item">
                    <div class="post-item-custom-img">
                      <img src="<?= $banner_file ?>" alt="">
                    </div>
                    <div class="post-item-custom-content">
                      <div class="post-item-custom-content-title"><?= $post['paperTitle']; ?></div>
                      <div class="post-item-custom-content-desc cate-desc "><?= $post['category_name'] ?>
                        (<?= $post['subcategory_name'] ?>)
                      </div>
                      <div class="post-item-custom-content-author d-flex align-items-center">
                        <div class="post-item-custom-content-author-avatar">
                          <img src="<?= base_url($avatar) ?>" alt="">
                        </div>
                        <div class="post-item-custom-content-author-name">
                            <?= $post['firstName'] . ' ' . $post['lastName'] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="post-item-custom-detail block-white back-item">
                    <div class="item">
                      <div class="item-label">Date of upload:</div>
                        <?php if (!empty($post['dateOfUpload'])): ?>
                          <div><?= date('d.m.Y', $post['dateOfUpload']) ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Co-author:</div>
                        <?php if (!empty($post['coAuthors'])): ?>
                          <div class="limitTextFurther"><?= $post['coAuthors'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                    <div class="item">
                      <div class="item-label">Abstract:</div>
                        <?php if (!empty($post['caption'])): ?>
                          <div class="limitTextFurther"><?= $post['caption'] ?></div>
                        <?php else: ?>
                          <div>Empty</div>
                        <?php endif; ?>
                    </div>
                      <?php if (isset($_SESSION['login'])) : ?>
                        <input type="hidden" value="<?= $post['idAuthor'] ?>">
                      <?php endif; ?>
                    <div class="btn-custom btn-border green"><a href="<?= base_url('paper/' . $post['id']); ?>">View
                        more</a></div>
                  </div>
                </div>
              </div>
            <?php endforeach; else: echo 'There are no uploaded papers yet'; endif; ?>
        </div>
          <?php
          if (!empty($countPapers) && $countPapers > 8): ?>
            <div class="btn-custom btn-bg green btn-explore-more">
              <input type="hidden" id="start_paper" value="8">
              <input type="hidden" id="total_paper" value="<?= $countPapers ?>">
              <a id="explore_more_paper">Explore more</a>
            </div>
          <?php endif; ?>
      </div>
      <!-- <div class="sm-flip-card">
        <div class="inner">
          <div class="flip-card-front">
            <div class="img-flip-card">
              <img src="<?= base_url('/assets/images/img-post.jpg') ?>" alt="img" />
            </div>
            <div class="content-flip-card">
              <div class="title-card">
                A global reference tool to fight Alzheimer's
              </div>
              <div class="sub-title-card">
                Medicine (Neurology)
              </div>
              <div class="author">
                <div class="avatar-author">
                  <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt="img" />
                </div>
                <div class="name-author">
                  Euronews Knowledge
                </div>
              </div>
            </div>
          </div>
          <div class="flip-card-back">
            <div class="sm-text-item">
              <div class="title-sm-text-item">
                Further information:
              </div>
              <div class="content-sm-text-item">
                Scientists developed a global reference tool for the early diagnosis of Alzheimer's. Scientists developed a global reference tool for the early diagnosis of Alzheimer's. Scientists developed a global reference tool for the...
              </div>
            </div> 
            <div class="btn-custom btn-border green btn-view-more">
              <a>
                View more
              </a>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>
<div class="section-our-users">
  <div class="container">
    <div class="title big-title">Some of our users</div>
    <div class="image-item">
      <img class="desktop-item" src="<?= base_url('/assets/images/img-our-users.jpg') ?>" alt="">
      <img class="mobile-item" src="<?= base_url('/assets/images/img-our-users.jpg') ?>" alt="">
    </div>
  </div>
</div>