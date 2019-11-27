<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 26-Apr-19
 * Time: 15:51
 */

$avatar_jpg = 'uploads/userfiles/' . $user[0]->id . '/profilePhoto.jpg';
if (file_exists($avatar_jpg)) {
    $avatar = $avatar_jpg;
} else {
    $avatar = 'assets/images/img-avatar-default.png';
}
?>
<div class="section-summary-profile">
  <div class="container">
    <div class="title big-font-normal">My account</div>
    <div class="block-item">
      <div class="block-item-title">Information</div>
      <div class="block-item-content block-white-p40-100">
        <div class="img-item">
          <img src="<?= base_url($avatar) ?>" alt="">
        </div>
        <div class="info-item">
          <div class="title"><?= $user[0]->firstName ?> <?= $user[0]->lastName ?></div>
          <div class="affiliation-item"><?= $user[0]->affiliation ?></div>
          <div class="show-info-item">
            <div>Position</div>
            <div><?php if (!empty($user[0]->position)) echo $user[0]->position; else echo 'Empty'; ?></div>
          </div>
          <div class="show-info-item">
            <div>Department</div>
            <div><?php if (!empty($user[0]->department)) echo $user[0]->department; else echo 'Empty'; ?></div>
          </div>
          <div class="show-info-item">
            <div>Field of research</div>
            <div><?php if (!empty( $user[1][0]['name'])) echo $user[1][0]['name']; else echo 'Empty'; ?> (<?php if (!empty( $user[1][1]['name'])) echo $user[1][1]['name']; else echo 'Empty';  ?>)</div>
          </div>
          <div class="show-info-item">
            <div>Email</div>
            <div><?= $user[0]->email ?></div>
          </div>
        </div>
        <?php if ($checkUser) : ?>
          <div class="btn-custom btn-bg green"><a href="<?= base_url('auth/profile') ?>">Edit Profile</a></div>
        <?php endif; ?>
      </div>
    </div>
    <div class="block-item">
      <div class="block-item-title">My OpenAccess portfolio</div>
      <div class="block-item-content">
        <div class="block-item-content-tab-title">
          <ul class="nav nav-tabs" id="myTabSummaryProfile">
            <li class="nav-item <?php if ($summary_type == 'video') echo 'active-custom'; ?>">
              <a class="nav-link nav-link-summary-profile video" id="video-tab" href="<?= base_url('summary-profile/video/' . $user[0]->id) ?>">Video list</a>
              <div><?= $countVideo ?></div>
            </li>
            <li class="nav-item <?php if ($summary_type == 'poster') echo 'active-custom'; ?>">
              <a class="nav-link nav-link-summary-profile poster" id="poster-tab" href="<?= base_url('summary-profile/poster/' . $user[0]->id) ?>">Poster</a>
              <div><?= $countPoster ?></div>
            </li>
            <li class="nav-item <?php if ($summary_type == 'paper') echo 'active-custom'; ?>">
              <a class="nav-link nav-link-summary-profile paper" id="paper-tab" href="<?= base_url('summary-profile/paper/' . $user[0]->id) ?>">Paper</a>
              <div><?= $countPaper ?></div>
            </li>
            <li class="nav-item <?php if ($summary_type == 'presentation') echo 'active-custom'; ?>">
              <a class="nav-link nav-link-summary-profile presentation" id="presentation-tab" href="<?= base_url('summary-profile/presentation/' . $user[0]->id) ?>"><span class="desktop-item">Presentation</span><span class="mobile-item">Presentati...</span></a>
              <div><?= $countPresentation ?></div>
            </li>
            <li class="nav-item <?php if ($summary_type == 'conference') echo 'active-custom'; ?>">
              <a class="nav-link nav-link-summary-profile conference" id="conference-tab" href="<?= base_url('summary-profile/conference/' . $user[0]->id) ?>">Conference</a>
              <div><?= $countConference ?></div>
            </li>
          </ul>
        </div>
        <div class="tab-content tab-content-summary-profile conference-tab-content" id="myTabContentSummaryProfile">
          <div class="tab-pane fade <?php if ($summary_type == 'video') echo 'show active'; ?>" id="video" role="tabpanel" aria-labelledby="video-tab">
            <div class="list-contribution-item">
              <?php if (!empty($videos)): ?>
              <div class="row">
                  <?php
                      foreach ($videos['results'] as $post) :
                          $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '.jpg');
                          ?>
                        <div class="col-md-6">
                          <div class="post-item-custom w-100 contribution-item">
                            <div class="front-item">
                              <div class="img-contribution">
                                <img src="<?= $banner_file ?>" alt="img"/>
                              </div>
                              <div class="contribution-item-detail">
                                <div class="contribution-item-detail-title"><?= $post['title'] ?></div>
                                <div class="contribution-item-detail-category">
                                    <?= $post['category_name'] ?> (<?= $post['subcategory_name'] ?>)
                                </div>
                                <div class="view">
                                  <span class="icon-views"></span>
                                    <?= $post['views'] ?> views
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail summary-page block-white back-item">
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
                      <?php endforeach; ?>
              </div>
              <div class="menu-pagination">
                  <?= $videos['links'] ?>
              </div>
              <?php else: ?>
                <div class="search-none-item">
                  <p>There are no uploaded videos yet.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="tab-pane fade <?php if ($summary_type == 'poster') echo 'show active'; ?>" id="poster" role="tabpanel" aria-labelledby="poster-tab">
            <div class="list-contribution-item">
              <?php if (!empty($posters)): ?>
              <div class="row">
                  <?php
                      foreach ($posters['results'] as $post) :
                          $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/posters/' . $post['id'] . '.jpg');
                          ?>
                        <div class="col-md-6">
                          <div class="post-item-custom w-100 contribution-item">
                            <div class="front-item">
                              <div class="img-contribution">
                                <img src="<?= $banner_file ?>" alt="img"/>
                              </div>
                              <div class="contribution-item-detail">
                                <div class="contribution-item-detail-title"><?= $post['posterTitle'] ?></div>
                                <div class="contribution-item-detail-category">
                                    <?= $post['category_name'] ?> (<?= $post['subcategory_name'] ?>)
                                </div>
                                <div class="view">
                                  <span class="icon-views"></span>
                                    <?= $post['views'] ?> views
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail summary-page block-white back-item">
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
                              <div class="btn-custom btn-border green">
                                <a href="<?= base_url('poster/' . $post['id']); ?>">View more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
              </div>
              <div class="menu-pagination">
                  <?= $posters['links'] ?>
              </div>
              <?php else: ?>
                <div class="search-none-item">
                  <p>There are no uploaded posters yet.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="tab-pane fade <?php if ($summary_type == 'paper') echo 'show active'; ?>" id="paper" role="tabpanel" aria-labelledby="paper-tab">
            <div class="list-contribution-item">
              <?php if (!empty($papers)): ?>
              <div class="row">
                  <?php
                      foreach ($papers['results'] as $post) :
                          $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/papers/' . $post['id'] . '.jpg');
                          ?>
                        <div class="col-md-6">
                          <div class="post-item-custom w-100 contribution-item">
                            <div class="front-item">
                              <div class="img-contribution">
                                <img src="<?= $banner_file ?>" alt="img"/>
                              </div>
                              <div class="contribution-item-detail">
                                <div class="contribution-item-detail-title"><?= $post['paperTitle'] ?></div>
                                <div class="contribution-item-detail-category">
                                    <?= $post['category_name'] ?> (<?= $post['subcategory_name'] ?>)
                                </div>
                                <div class="view">
                                  <span class="icon-views"></span>
                                    <?= $post['views'] ?> views
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail summary-page block-white back-item">
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
                              <div class="btn-custom btn-border green">
                                <a href="<?= base_url('paper/' . $post['id']); ?>">View more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
              </div>
              <div class="menu-pagination">
                  <?= $papers['links'] ?>
              </div>
              <?php else: ?>
                <div class="search-none-item">
                  <p>There are no uploaded papers yet.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="tab-pane fade <?php if ($summary_type == 'presentation') echo 'show active'; ?>" id="presentation" role="tabpanel" aria-labelledby="presentation-tab">
            <div class="list-contribution-item">
              <?php if (!empty($presentations)): ?>
              <div class="row">
                  <?php
                      foreach ($presentations['results'] as $post) :
                          $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/presentations/' . $post['id'] . '.jpg');
                          ?>
                        <div class="col-md-6">
                          <div class="post-item-custom w-100 contribution-item">
                            <div class="front-item">
                              <div class="img-contribution">
                                <img src="<?= $banner_file ?>" alt="img"/>
                              </div>
                              <div class="contribution-item-detail">
                                <div class="contribution-item-detail-title"><?= $post['presTitle'] ?></div>
                                <div class="contribution-item-detail-category">
                                    <?= $post['category_name'] ?> (<?= $post['subcategory_name'] ?>)
                                </div>
                                <div class="view">
                                  <span class="icon-views"></span>
                                    <?= $post['views'] ?> views
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail summary-page block-white back-item">
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
                              <div class="btn-custom btn-border green">
                                <a href="<<?= base_url('presentation/' . $post['id']); ?>">View more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
              </div>
              <div class="menu-pagination">
                  <?= $presentations['links'] ?>
              </div>
                  <?php else: ?>
                <div class="search-none-item">
                  <p>There are no uploaded presentations yet.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="tab-pane fade <?php if ($summary_type == 'conference') echo 'show active'; ?>" id="conference" role="tabpanel" aria-labelledby="conference-tab">
            <div class="list-contribution-item">
              <?php if (!empty($conferences)): ?>
              <div class="row">
                  <?php
                      foreach ($conferences['results'] as $post) :
                          $relativeDir = base_url('/uploads/userfiles/' . $post['userID'] . '/conferences/' . $post['id']);
                          if (!empty($post['filenameBanner_original'])) {
                              $ext_ = pathinfo($post['filenameBanner_original']);
                              $ext = $ext_['extension'];
                              $banner_file = $relativeDir . '/ConferenceBanner.' . $ext;
                          } else {
                              $banner_file = base_url('/assets/images/img-conference.png');
                          }
                          ?>
                        <div class="col-md-6">
                          <div class="post-item-custom w-100 contribution-item">
                            <div class="front-item">
                              <div class="img-contribution">
                                <img src="<?= $banner_file ?>" alt="img"/>
                              </div>
                              <div class="contribution-item-detail">
                                <div class="contribution-item-detail-title"><?= $post['confTitle'] ?></div>
                                <div class="contribution-item-detail-category">
                                    <?= $post['category_name'] ?> (<?= $post['subcategory_name'] ?>)
                                </div>
                                <div class="view">
                                  <span class="icon-views"></span>
                                    <?= $post['views'] ?> views
                                </div>
                              </div>
                            </div>
                            <div class="post-item-custom-detail summary-page block-white back-item">
                              <div class="show-info-item-mr-8 conference-item">
                                <span>CID: </span>
                                <span><?= $post['CID'] ?></span>
                              </div>
                                <?php if (isset($_SESSION['login'])) : ?>
                                  <input type="hidden" value="">
                                <?php endif; ?>
                              <div class="btn-custom btn-border green">
                                <a href="<?= base_url('conference/' . $post['id']); ?>">View more</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
              </div>
              <div class="menu-pagination">
                  <?= $conferences['links'] ?>
              </div>
              <?php else: ?>
                <div class="search-none-item">
                  <p>There are no uploaded conferences yet.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>