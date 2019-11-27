<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 10-May-19
 * Time: 09:07
 */

$relativeDir = base_url('/uploads/userfiles/' . $conference['userID'] . '/conferences/' . $conference['id']);

if (!empty($conference['filenameBanner_original'])) {
    $ext_ = pathinfo($conference['filenameBanner_original']);
    $ext = $ext_['extension'];
    $banner_file = $relativeDir . '/ConferenceBanner.' . $ext . '?' . time();
} else {
    $banner_file = base_url('/assets/images/img-conference.png');
}
if (!empty($conference['filenamePoster_original'])) {
    $poster_file = $relativeDir . '/ConferencePoster.pdf';
}
if (!empty($conference['filenameProgramme_original'])) {
    $programme_file = $relativeDir . '/ConferenceProgramme.pdf';
}
if (!empty($conference['filenameAbstractBook_original'])) {
    $abstractBook_file = $relativeDir . '/ConferenceAbstractBook.pdf';
}
if (!empty($conference['filenameConfPhoto_original'])) {
    $ext_ = pathinfo($conference['filenameConfPhoto_original']);
    $ext = $ext_['extension'];
    $conferencePhoto_file = $relativeDir . '/ConferencePictureParticipants.' . $ext . '?' . time();
}
?>
<div class="section-detail-conference">
    <?php if (!empty($conferenceInfo)) : ?>
      <!-- <div class="title-section">
          <?php
          if ($conferenceInfo['type'] == 'managed') {
              echo 'Managed conferences';
          } else {
              echo 'Attended conferences';
          }
          ?>
      </div> -->
      <div class="block-white">
        <div class="block-conference-content">
          <ul class="nav nav-tabs conference-tab-menu top-menu  menu-desktop" role="tablist">
            <li class="nav-item active">
              <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab"
                 aria-controls="overview" aria-selected="true">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="upload-content-tab" data-toggle="tab" href="#submit-abstract" role="tab"
                 aria-controls="submit-abstract" aria-selected="false">Submit abstract</a>
            </li>
              <?php if (true) : ?>
                <li class="nav-item dropdown dropdown-menu-custom">
                  <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                    Upload content
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a data-href="video" class="dropdown-item upload-content-item">
                      Video
                    </a>
                    <a data-href="presentation" class="dropdown-item upload-content-item">
                      Presentation
                    </a>
                    <a data-href="poster" class="dropdown-item upload-content-item">
                      Posters
                    </a>
                    <a data-href="paper" class="dropdown-item upload-content-item">
                      Papers
                    </a>
                  </div>
                </li>
              <?php endif; ?>
          </ul>
          <ul class="nav nav-tabs conference-tab-menu top-menu  menu-mobile-with-popup" role="tablist">
            <li class="nav-item active">
              <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab"
                 aria-controls="overview" aria-selected="true">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="upload-content-tab" data-toggle="tab" href="#submit-abstract" role="tab"
                 aria-controls="submit-abstract" aria-selected="false">Submit abstract</a>
            </li>
              <?php if ($conferenceInfo['type'] == 'attended') : ?>
                <li class="nav-item ">
                  <a class="nav-link" role="button" data-toggle="modal" data-target="#upload-content-menu">
                    Upload content
                  </a>
                </li>
              <?php endif; ?>
          </ul>
          <div class="tab-content conference-tab-content" id="myTabContent">
            <div class="tab-pane conference-tab-pane active" id="overview" role="tabpanel"
                 aria-labelledby="overview-tab">
              <div class="img-conference">
                <img src="<?= $banner_file ?>">
              </div>
              <div class="sub-tab-menu-conference">
                <ul class="nav nav-tabs conference-tab-menu" role="tablist">
                  <li class="nav-item active">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                       aria-controls="profile" aria-selected="true">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#programme" role="tab"
                       aria-controls="programme" aria-selected="false">Programme</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="dates-tab" data-toggle="tab" href="#dates" role="tab" aria-controls="dates"
                       aria-selected="false">Dates</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="registration-payment-tab" data-toggle="tab" href="#registration-payment"
                       role="tab" aria-controls="registration-payment" aria-selected="false">Registration and
                      payment</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="venue-tab" data-toggle="tab" href="#venue" role="tab" aria-controls="venue"
                       aria-selected="false">Venue/ Hotel/ Travel</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="contributions-tab" data-toggle="tab" href="#sub-contributions" role="tab"
                       aria-controls="sub-contributions" aria-selected="false">Contributions</a>
                  </li>
                    <?php if ($conference['showParticipation'] == 1): ?>
                      <li class="nav-item">
                        <a class="nav-link" id="participantion-tab" data-toggle="tab" href="#participantion" role="tab"
                           aria-controls="participantion" aria-selected="false">Participants</a>
                      </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content conference-tab-content" id="myTabContent">
                  <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <?php
                      if (!empty($conference['confSeries'])) {
                          echo '<div class="series-item">' . $conference['confSeries'] . '</div>';
                      }
                      ?>
                    <div class="title-label-item">
                      <div class="title">
                          <?= $conference['confTitle'] ?>
                          <span class="group-label">
                              <?php if ($conference['fee'] != 0) : ?>
                                <span class="brand-item price">&euro; <?= number_format($conference['fee'], 2) ?></span>
                              <?php if (!empty($registeredUser)): ?>
                                      <?php if ($registeredUser->status == 'Unpaid') : ?>
                                    <span class="brand-item status not-paid">Unpaid</span>
                                      <?php elseif($registeredUser->status == 'completed'): ?>
                                    <span class="brand-item status paid">Paid</span>
                                      <?php elseif($registeredUser->status == 'pending' || $registeredUser->status == 'unclaimed'): ?>
                                    <span class="brand-item status pending">Pending</span>
                                      <?php else: ?>
                                    <span class="brand-item status refund">Others</span>
                                      <?php endif; ?>
                                  <?php endif; ?>
                              <?php else: ?>
                                <span class="brand-item free">Free</span>
                              <?php endif; ?>
                              <?php if (!empty($checkActive) && $checkActive == 'opening'): ?>
                                <span class="brand-item status conference in-progress mobile-item">Conference in progress</span>
                              <?php elseif (!empty($checkActive) && $checkActive == 'closed') : ?>
                                <span class="brand-item status conference closed mobile-item">Conference is closed</span>
                              <?php endif; ?>
                          </span>
                      </div>
                      <div class="desktop-item">
                          <?php if (!empty($checkActive) && $checkActive == 'opening'): ?>
                            <span class="brand-item status conference in-progress">
                            Conference in progress
                          </span>
                          <?php elseif (!empty($checkActive) && $checkActive == 'closed') : ?>
                            <span class="brand-item status conference closed">
                            Conference is closed
                          </span>
                          <?php endif; ?>
                      </div>
                    </div>
                    <div class="profile-detail">
                      <div class="gr-icon-text cid">
                        <span class="icon-cid"></span>
                        <?= $conference['CID'] ?>
                      </div>
                      <div class="show-info-item-mr-8 hosted">
                        <span>Hosted by</span>
                        <a class="link" href="<?= base_url('summary-profile/video/' . $conference['userID']) ?>">
                          <?= $conference['firstName'] ?> <?= $conference['lastName'] ?>
                        </a>
                        
                      </div>
                      <div class="show-info-item-mr-8">
                        <span>Affiliation</span>
                        <?php
                        if (!empty($conference['affiliation'])) {
                            echo $conference['affiliation'];
                        } else {
                            echo 'Empty';
                        }
                        ?>
                      </div>
                      <div class="gr-icon-text location-item">
                        <span class="icon-location"></span>
                          <?php
                          if (!empty($conference['confLocation'])) {
                              echo $conference['confLocation'];
                          } else {
                              echo 'Empty';
                          }
                          ?>
                      </div>
                      <div class="gr-icon-text date-time">
                        <span class="icon-calendar"></span>

                          <?php
                          if (!empty($conference['startDate']) && !empty($conference['endDate'])) {
                              echo date('d.m.Y', $conference['startDate']) . ' - ' . date('d.m.Y',
                                  $conference['endDate']);
                          } else {
                              echo 'Empty';
                          }
                          ?>

                      </div>
                      <hr>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Organizing institutions</span>
                        <?php
                        if (!empty($conference['organizingInstitutions'])) {
                            echo $conference['organizingInstitutions'];
                        } else {
                            echo 'Empty';
                        }
                        ?>
                      </div>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Main category</span>
                        <?= $conference['category_name'] ?> (<?= $conference['subcategory_name'] ?>)
                      </div>
                      <?php if (!empty($conference['altCategory1'])): ?>
                        <div class="show-info-item-mr-8 display-block">
                          <span>Alternative category</span>
                            <?= $alt_category['alt_category_name'] ?> (<?= $alt_category['alt_subcategory_name'] ?>)
                        </div>
                      <?php endif; ?>
                      <div class="show-info-item-mr-8 mb-0 display-block">
                        <span>Conference/Workshop objectives</span>
                        
                        <?php
                        if (!empty($conference['abstract'])) {
                            echo $conference['abstract'];
                        } else {
                            echo 'Empty';
                        }
                        ?>
                        
                      </div>
                    </div>
                      <?php if (!empty($conferencePhoto_file)) : ?>
                        <div class="img-conference">
                          <img src="<?= $conferencePhoto_file ?>">
                        </div>
                      <?php endif; ?>
                    <div class="sm-content-text">
                        <?php if (!empty($poster_file)) : ?>
                          <div class="btn-custom btn-border green btn-download">
                            <a href="<?= $poster_file ?>" download="conference_poster.pdf">Download poster</a>
                          </div>
                        <?php endif; ?>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Local organizing committee</span>
                        
                        <?php
                        if (!empty($conference['LOC'])) {
                            echo $conference['LOC'];
                        } else {
                            echo 'Empty';
                        }
                        ?>
                        
                      </div>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Scientific organizing committee (SOC)</span>
                        
                        <?php
                        if (!empty($conference['SOC'])) {
                            echo $conference['SOC'];
                        } else {
                            echo 'Empty';
                        }
                        ?>
                        
                      </div>
                      <div class="gr-btn-conference d-flex flex-wrap">
                          <?php
                          if (empty($registeredUser)) :
                              if (!empty($checkRegistrationActive)) :
                                  ?>
                                <div class="btn-custom btn-bg green btn-register">
                                  <a class="btn-register-conference"
                                     href="<?= base_url('register/conference/' . $conference['id']) ?>">Register for
                                    conference</a>
                                </div>
                              <?php else: ?>
                                <div class="btn-custom btn-bg green btn-register disabled">
                                  <a>Register for conference</a>
                                </div>
                              <?php endif; else: ?>
                            <div class="btn-custom btn-bg green btn-register label">
                              <a>You registered for this conference</a>
                            </div>
                            <?php if ($registeredUser->status == 'Unpaid'): ?>
                              <form class="paypal paypal_form" action="<?= base_url('auth/conference/pay-cid/checkout') ?>" method="post">
                                <input type="hidden" class="getCID" name="item_number" value="<?= $conference['CID'] ?>" />
                                <input type="hidden" name="conference_fee" value="<?= $conference['fee'] ?>" />
                                <input type="hidden" name="conference_id" value="<?= $conference['id'] ?>" />
                                <input type="hidden" name="conference_paypalEmail" value="<?= $conference['paypalEmail'] ?>" />
                                <input type="hidden" name="conference_title" value="<?= $conference['confTitle'] ?>" />
                                <input type="button" class="add-spinner btn-custom btn-bg green btn-buy btnBuyNowOrderCID" value="Pay now"/>
                              </form>
                            <?php endif; ?>
                          <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="programme" role="tabpanel" aria-labelledby="programme-tab">
                    <div class="sm-content-text">
                      <div class="show-info-item-mr-8 display-block">
                        <span>Sessions</span>
                          <?php
                          if (count($sessions) > 0) {
                              echo '<ul>';
                              foreach ($sessions as $session) {
                                  echo '<li>' . $session['name'] . '</li>';
                              }
                              echo '</ul>';
                          }
                          ?>
                      </div>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Programme</span>

                          <?php
                          if (!empty($conference['programme'])) {
                              echo $conference['programme'];
                          } else {
                              echo 'Empty';
                          }
                          ?>

                      </div>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Invited speakers</span>
                          <?php
                          if (!empty($conference['keynoteSpeakers'])) {
                              echo $conference['keynoteSpeakers'];
                          } else {
                              echo 'Empty';
                          }
                          ?>
                      </div>
                      <div class="gr-btn-programme">
                          <?php if (!empty($programme_file)) : ?>
                            <div class="btn-custom btn-border green btn-download">
                              <a href="<?= $programme_file ?>" download="conference_programme.pdf">Download
                                programme</a>
                            </div>
                          <?php endif; ?>
                          <?php if (!empty($abstractBook_file)) : ?>
                            <div class="btn-custom btn-border green btn-download">
                              <a href="<?= $abstractBook_file ?>" download="conference_abstract.pdf">Download abstract
                                book</a>
                            </div>
                          <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="dates" role="tabpanel" aria-labelledby="dates-tab">
                    <div class="sm-content-text">
                      <div class="show-info-item-mr-8 display-block">
                        <span>Important dates</span>
                        
                        <?php
                        if (!empty($conference['importantDates'])) {
                            echo $conference['importantDates'];
                        } else {
                            echo 'Empty';
                        }
                        ?>
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="registration-payment" role="tabpanel"
                       aria-labelledby="registration-payment-tab">
                    <div class="sm-content-text">
                      <div class="show-info-item-mr-8 display-block">
                        <span>Registration and payment information</span>
                        
                            <?php
                            if (!empty($conference['registrationPayment'])) {
                                echo $conference['registrationPayment'];
                            } else {
                                echo 'Empty';
                            }
                            ?>
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="venue" role="tabpanel" aria-labelledby="venue-tab">
                    <div class="sm-content-text">
                      <div class="show-info-item-mr-8 display-block">
                        <span>Conference venue</span>
                        
                            <?php
                            if (!empty($conference['venue'])) {
                                echo $conference['venue'];
                            } else {
                                echo 'Empty';
                            }
                            ?>
                        
                      </div>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Hotel information</span>
                        
                            <?php
                            if (!empty($conference['hotelInfos'])) {
                                echo $conference['hotelInfos'];
                            } else {
                                echo 'Empty';
                            }
                            ?>
                        
                      </div>
                      <div class="show-info-item-mr-8 display-block">
                        <span>Travel information</span>
                        
                            <?php
                            if (!empty($conference['travelInformation'])) {
                                echo $conference['travelInformation'];
                            } else {
                                echo 'Empty';
                            }
                            ?>
                        
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="sub-contributions" role="tabpanel" aria-labelledby="contributions-tab">
                    <div class="sub-tab-menu-conference contributions-tab-content">
                      <ul class="nav nav-tabs conference-tab-menu contributions-menu" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link dropdown-item-contribution <?php if ($postType == 'Videos') echo 'active'; ?>" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="true">
                            <span class="contribution-type">Videos</span>
                            <span class="number"><?= $countVideo ?></span>
                          </a>
                        </li><li class="nav-item">
                          <a class="nav-link dropdown-item-contribution <?php if ($postType == 'Presentations') echo 'active'; ?>" id="presentations-tab" data-toggle="tab" href="#presentations" role="tab" aria-controls="presentations" aria-selected="true">
                            <span class="contribution-type">Presentations</span>
                            <span class="number"><?= $countPresentation ?></span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link dropdown-item-contribution <?php if ($postType == 'Posters') echo 'active'; ?>" id="poster-tab" data-toggle="tab" href="#poster" role="tab" aria-controls="poster" aria-selected="true">
                            <span class="contribution-type">Posters</span>
                            <span class="number"><?= $countPoster ?></span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link dropdown-item-contribution <?php if ($postType == 'Papers') echo 'active'; ?>" id="paper-tab" data-toggle="tab" href="#paper" role="tab" aria-controls="paper" aria-selected="true">
                            <span class="contribution-type">Papers</span>
                            <span class="number"><?= $countPaper ?></span>
                          </a>
                        </li>
                      </ul>
                      <div class="contributions-menu-mobile">
                        <div class="dropdown dropdown-menu-custom">
                          <button class="btn dropdown-toggle" id="show_contribution_menu" type="button" data-toggle="dropdown"
                                  aria-haspopup="true" aria-expanded="false"><span class="contribution-type"><?= $postType ?></span>
                            <span class="number">
                            <?php
                            if ($postType == 'Videos') {
                                echo $countVideo;
                            } elseif ($postType == 'Presentations') {
                                echo $countPresentation;
                            } elseif ($postType == 'Posters') {
                                echo $countPoster;
                            } elseif ($postType == 'Papers') {
                                echo $countPaper;
                            }
                            ?>
                            </span>
                          </button>
                          <div class="dropdown-menu dropdown-menu-contribution" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item dropdown-item-contribution <?php if ($postType == 'Videos') echo 'd-none'; ?>" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="true"><span class="contribution-type">Videos</span> <span class="number"><?= $countVideo ?></span></a>
                            <a class="dropdown-item dropdown-item-contribution <?php if ($postType == 'Presentations') echo 'd-none'; ?>" id="presentations-tab" data-toggle="tab" href="#presentations" role="tab" aria-controls="presentations" aria-selected="true"><span class="contribution-type">Presentations</span> <span class="number"><?= $countPresentation ?></span></a>
                            <a class="dropdown-item dropdown-item-contribution <?php if ($postType == 'Posters') echo 'd-none'; ?>" id="poster-tab" data-toggle="tab" href="#poster" role="tab" aria-controls="poster" aria-selected="true"><span class="contribution-type">Posters</span> <span class="number"><?= $countPoster ?></span></a>
                            <a class="dropdown-item dropdown-item-contribution <?php if ($postType == 'Papers') echo 'd-none'; ?>" id="paper-tab" data-toggle="tab" href="#paper" role="tab" aria-controls="paper" aria-selected="true"><span class="contribution-type">Papers</span> <span class="number"><?= $countPaper ?></span></a>
                          </div>
                        </div>
                      </div>
                      <div class="tab-content conference-tab-content contribution-tab" id="myTabContent">
                        <div class="tab-pane <?php if ($postType == 'Videos') echo 'active'; ?>" id="video" role="tabpanel" aria-labelledby="video-tab">
                          <div class="list-contribution-item">
                              <?php
                              if (count($videos) > 0) {
                                  foreach ($videos as $post) :
                                      $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                                      if (file_exists($avatar_jpg)) {
                                          $avatar = $avatar_jpg;
                                      } else {
                                          $avatar = '/assets/images/small-avatar.jpg';
                                      }
                                      $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '.jpg');
                                      ?>
                                    <div class="post-item-custom width-370 contribution-item">
                                      <div class="front-item">
                                        <div class="img-contribution">
                                          <img src="<?= $banner_file ?>" alt="img"/>
                                        </div>
                                        <div class="contribution-item-detail">
                                          <div class="author">
                                            <div class="avatar-author">
                                              <img src="<?= base_url($avatar) ?>" alt="img"/>
                                            </div>
                                            <div class="name">
                                                <?= $post['firstName'] ?> <?= $post['lastName'] ?>
                                            </div>
                                          </div>
                                          <p>
                                            Session: <?= $post['sessionName'] ?>
                                          </p>
                                          <div class="view">
                                            <span class="icon-views"></span>
                                              <?= $post['views'] ?> views
                                          </div>
                                        </div>
                                      </div>
                                      <div class="post-item-custom-detail back-item">
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
                                  <?php endforeach;
                              } else {
                                  echo 'There are no uploaded videos yet.';
                              }
                              ?>
                          </div>
                        </div>
                        <div class="tab-pane <?php if ($postType == 'Presentations') echo 'active'; ?>" id="presentations" role="tabpanel"
                             aria-labelledby="presentations-tab">
                          <div class="list-contribution-item">
                              <?php
                              if (count($presentations) > 0) {
                                  foreach ($presentations as $post) :
                                      $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                                      if (file_exists($avatar_jpg)) {
                                          $avatar = $avatar_jpg;
                                      } else {
                                          $avatar = '/assets/images/small-avatar.jpg';
                                      }
                                      $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/presentations/' . $post['id'] . '.jpg');
                                      ?>
                                    <div class="post-item-custom width-370 contribution-item">
                                      <div class="front-item">
                                        <div class="img-contribution">
                                          <img src="<?= $banner_file ?>" alt="img"/>
                                        </div>
                                        <div class="contribution-item-detail">
                                          <div class="author">
                                            <div class="avatar-author">
                                              <img src="<?= base_url($avatar) ?>" alt="img"/>
                                            </div>
                                            <div class="name">
                                                <?= $post['firstName'] ?> <?= $post['lastName'] ?>
                                            </div>
                                          </div>
                                          <p>
                                            Session: <?= $post['sessionName'] ?>
                                          </p>
                                          <div class="view">
                                            <span class="icon-views"></span>
                                              <?= $post['views'] ?> views
                                          </div>
                                        </div>
                                      </div>
                                      <div class="post-item-custom-detail back-item">
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
                                          <a href="<?= base_url('presentation/' . $post['id']); ?>">View more</a>
                                        </div>
                                      </div>
                                    </div>
                                  <?php endforeach;
                              } else {
                                  echo 'There are no uploaded presentations yet.';
                              }
                              ?>
                          </div>
                        </div>
                        <div class="tab-pane <?php if ($postType == 'Posters') echo 'active'; ?>" id="poster" role="tabpanel" aria-labelledby="poster-tab">
                          <div class="list-contribution-item">
                              <?php
                              if (count($posters) > 0) {
                                  foreach ($posters as $post) :
                                      $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                                      if (file_exists($avatar_jpg)) {
                                          $avatar = $avatar_jpg;
                                      } else {
                                          $avatar = '/assets/images/small-avatar.jpg';
                                      }
                                      $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/posters/' . $post['id'] . '.jpg');
                                      ?>
                                    <div class="post-item-custom width-370 contribution-item">
                                      <div class="front-item">
                                        <div class="img-contribution">
                                          <img src="<?= $banner_file ?>" alt="img"/>
                                        </div>
                                        <div class="contribution-item-detail">
                                          <div class="author">
                                            <div class="avatar-author">
                                              <img src="<?= base_url($avatar) ?>" alt="img"/>
                                            </div>
                                            <div class="name">
                                                <?= $post['firstName'] ?> <?= $post['lastName'] ?>
                                            </div>
                                          </div>
                                          <p>
                                            Session: <?= $post['sessionName'] ?>
                                          </p>
                                          <div class="view">
                                            <span class="icon-views"></span>
                                              <?= $post['views'] ?> views
                                          </div>
                                        </div>
                                      </div>
                                      <div class="post-item-custom-detail back-item">
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
                                  <?php endforeach;
                              } else {
                                  echo 'There are no uploaded posters yet.';
                              }
                              ?>
                          </div>
                        </div>
                        <div class="tab-pane <?php if ($postType == 'Papers') echo 'active'; ?>" id="paper" role="tabpanel" aria-labelledby="paper-tab">
                          <div class="list-contribution-item">
                              <?php
                              if (count($papers) > 0) {
                                  foreach ($papers as $post) :
                                      $avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
                                      if (file_exists($avatar_jpg)) {
                                          $avatar = $avatar_jpg;
                                      } else {
                                          $avatar = '/assets/images/small-avatar.jpg';
                                      }
                                      $banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/papers/' . $post['id'] . '.jpg');
                                      ?>
                                    <div class="post-item-custom width-370 contribution-item">
                                      <div class="front-item">
                                        <div class="img-contribution">
                                          <img src="<?= $banner_file ?>" alt="img"/>
                                        </div>
                                        <div class="contribution-item-detail">
                                          <div class="author">
                                            <div class="avatar-author">
                                              <img src="<?= base_url($avatar) ?>" alt="img"/>
                                            </div>
                                            <div class="name">
                                                <?= $post['firstName'] ?> <?= $post['lastName'] ?>
                                            </div>
                                          </div>
                                          <p>
                                            Session: <?= $post['sessionName'] ?>
                                          </p>
                                          <div class="view">
                                            <span class="icon-views"></span>
                                              <?= $post['views'] ?> views
                                          </div>
                                        </div>
                                      </div>
                                      <div class="post-item-custom-detail back-item">
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
                                  <?php endforeach;
                              } else {
                                  echo 'There are no uploaded papers yet.';
                              }
                              ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    <?php if ($conference['showParticipation'] == 1): ?>
                      <div class="tab-pane fade" id="participantion" role="tabpanel"
                           aria-labelledby="participantion-tab">
                        <div class="sm-table-item">
                          <table class="table-custom">
                            <thead>
                            <tr>
                              <th>
                                First Name
                              </th>
                              <th>
                                Last Name
                              </th>
                              <th>
                                Affiliation
                              </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($userParticipation)) : foreach ($userParticipation as $user) : if ($user->publishName == 1): ?>
                              <tr>
                                <td>
                                    <?= $user->firstName ?>
                                </td>
                                <td>
                                    <?= $user->lastName ?>
                                </td>
                                <td>
                                    <?= $user->affiliation ?>
                                </td>
                              </tr>
                            <?php endif; endforeach; endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="tab-pane conference-tab-pane" id="contributions" role="tabpanel"
                 aria-labelledby="contributions-tab">
              <div class="img-conference">
                <img src="<?= base_url('/assets/images/img-conference.png') ?>">
              </div>
              <div class="sub-tab-menu-conference contributions-tab-content">
                <ul class="nav nav-tabs conference-tab-menu contributions-menu" role="tablist">
                  <li class="nav-item active">
                    <a class="nav-link active" id="video-tab" data-toggle="tab" href="#video" role="tab"
                       aria-controls="video" aria-selected="true">
                      Videos
                      <span class="number">
                      4
                    </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="presentations-tab" data-toggle="tab" href="#presentations" role="tab"
                       aria-controls="presentations" aria-selected="false">Presentations
                      <span class="number">
                      0
                    </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="poster-tab" data-toggle="tab" href="#poster" role="tab"
                       aria-controls="poster" aria-selected="false">
                      Posters
                      <span class="number">
                      4
                    </span>
                    </a>

                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="paper-tab" data-toggle="tab" href="#paper" role="tab" aria-controls="paper"
                       aria-selected="false">
                      Papers
                      <span class="number">
                      4
                    </span>
                    </a>
                  </li>
                </ul>
                <div class="contributions-menu-mobile">
                  <div class="dropdown dropdown-menu-custom">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                      Video
                      <span class="number">
                      4
                    </span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item" href="#">
                        Videos
                        <span class="number">
                        4
                      </span>
                      </a>
                      <a class="dropdown-item" href="#">
                        Presentations
                        <span class="number">
                        4
                      </span>
                      </a>
                      <a class="dropdown-item" href="#">
                        Posters
                        <span class="number">
                        4
                      </span>
                      </a>
                      <a class="dropdown-item" href="#">
                        Papers
                        <span class="number">4</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="tab-content conference-tab-content" id="myTabContent">
                  <div class="tab-pane active" id="video" role="tabpanel" aria-labelledby="video-tab">
                    <div class="list-contribution-item">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="contribution-item">
                            <div class="img-contribution">
                              <img src="<?= base_url('/assets/images/img-post-detail.jpg') ?>" alt="img"/>
                            </div>
                            <div class="contribution-item-detail">
                              <div class="author">
                                <div class="avatar-author">
                                  <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt="img"/>
                                </div>
                                <div class="name">
                                  Euronews Knowledge
                                </div>
                              </div>
                              <p>
                                Session:Testing abc
                              </p>
                              <div class="view">
                                <span class="icon-views"></span>
                                23,255 views
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="contribution-item">
                            <div class="img-contribution">
                              <img src="<?= base_url('/assets/images/img-post-detail.jpg') ?>" alt="img"/>
                            </div>
                            <div class="contribution-item-detail">
                              <div class="author">
                                <div class="avatar-author">
                                  <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt="img"/>
                                </div>
                                <div class="name">
                                  Euronews Knowledge
                                </div>
                              </div>
                              <p>
                                Session:Testing abc
                              </p>
                              <div class="view">
                                <span class="icon-views"></span>
                                23,255 views
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="contribution-item">
                            <div class="img-contribution">
                              <img src="<?= base_url('/assets/images/img-post-detail.jpg') ?>" alt="img"/>
                            </div>
                            <div class="contribution-item-detail">
                              <div class="author">
                                <div class="avatar-author">
                                  <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt="img"/>
                                </div>
                                <div class="name">
                                  Euronews Knowledge
                                </div>
                              </div>
                              <p>
                                Session:Testing abc
                              </p>
                              <div class="view">
                                <span class="icon-views"></span>
                                23,255 views
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="contribution-item">
                            <div class="img-contribution">
                              <img src="<?= base_url('/assets/images/img-post-detail.jpg') ?>" alt="img"/>
                            </div>
                            <div class="contribution-item-detail">
                              <div class="author">
                                <div class="avatar-author">
                                  <img src="<?= base_url('/assets/images/small-avatar.jpg') ?>" alt="img"/>
                                </div>
                                <div class="name">
                                  Euronews Knowledge
                                </div>
                              </div>
                              <p>
                                Session:Testing abc
                              </p>
                              <div class="view">
                                <span class="icon-views"></span>
                                23,255 views
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="presentations" role="tabpanel" aria-labelledby="presentations-tab">
                    You have not attended any conferences hosted by our platform so far.
                  </div>
                  <div class="tab-pane fade" id="poster" role="tabpanel" aria-labelledby="poster-tab">
                    You have not attended any conferences hosted by our platform so far.
                  </div>
                  <div class="tab-pane fade" id="paper" role="tabpanel" aria-labelledby="paper-tab">
                    You have not attended any conferences hosted by our platform so far.
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane conference-tab-pane" id="submit-abstract" role="tabpanel"
                 aria-labelledby="submit-abstract-tab">
                <?php if (!empty($checkAbstractActive)): ?>
                  <form id="submit_abstract_form" class="submit-abstract-form">
                    <div class="title">
                      Abstract Submission for CID: <?= $conference['CID'] ?>
                    </div>
                    <div class="form-item">
                      <label class="label-custom">
                        Please select, if you submit a talk or a poster
                        <span class="req">*</span>
                      </label>
                      <div class="checkbox-inline d-flex">
                        <div class="form-item check-terms-item checkbox-register">
                          <input type="radio" class="input abstract-talk" name="choose_talk_poster" value="talk" checked>
                          <label></label>
                          <div class="check-terms-item-text">Talk</div>
                        </div>
                        <div class="form-item check-terms-item checkbox-register">
                          <input type="radio" class="input abstract-poster" name="choose_talk_poster" value="poster">
                          <label></label>
                          <div class="check-terms-item-text">Poster</div>
                        </div>
                      </div>
                      <div class="error"></div>
                    </div>
                    <div class="form-item">
                      <label class="label-custom">
                        Title
                        <span class="req">*</span>
                      </label>
                      <input type="text" placeholder="Abstract title" class="input-custom abstract-title" name="title">
                      <div class="error"></div>
                    </div>
                    <div class="form-item">
                      <label class="label-custom">
                        Author
                        <span class="req">*</span>
                      </label>
                      <input type="text" placeholder="Author" class="input-custom" disabled value="<?= $username ?>"/>
                    </div>
                    <div class="form-item">
                      <label class="label-custom">
                        Co Authors
                      </label>
                      <input type="text" placeholder="Co Authors" class="input-custom abstract-co-authors"
                             name="co-authors">
                    </div>
                    <div class="form-item">
                      <label class="label-custom">
                        Affiliations
                      </label>
                      <input type="text" placeholder="Affiliations" class="input-custom abstract-affiliations"
                             name="affiliations">
                    </div>
                    <div class="form-item">
                      <label class="label-custom">
                        Abstract text
                        <span class="req">*</span>
                      </label>
                      <textarea class="textarea-custom abstract-text" placeholder="The text of your abstract"
                                name="text"></textarea>
                      <div class="error"></div>
                    </div>
                    <div class="gr-btn-bottom d-flex">
                      <div class="btn-custom btn-bg gray btn-back">
                        <a class="btn-reload-page">
                          Back
                        </a>
                      </div>
                      <div class="btn-custom btn-bg green btn-submit ml-auto <?php if (!empty($checkSpamAbstract)) {
                          echo 'disabled';
                      } ?>">
                        <a class="btn-submit-abstract-conference auth">
                          Submit
                        </a>
                      </div>
                    </div>
                  </form>
                  <div id="submit_abstract_success" class="d-none">
                    <div class="title" style="margin-bottom: 0.625rem">Abstract submission</div>
                    <p>You have successfully submitted an abstract. You will also receive an email shortly.</p>
                    <div class="gr-button" style="margin-top: 5rem">
                      <div class="btn-custom btn-bg gray btn-back">
                        <a class="btn" href="javascript:window.history.go(0)">Back to Conference Page</a>
                      </div>
                    </div>
                  </div>
              <?php else: ?>
                <div>The abstract submission is closed.</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
</div>
<input type="hidden" id="get_id_conference" value="<?= $conference['id'] ?>">
<input type="hidden" id="get_cid_conference" value="<?= $conference['CID'] ?>">

<!-- popup menu -->
<div class="modal sm-modal modal-upload-content-menu" id="upload-content-menu" tabindex="-1" role="dialog"
     aria-labelledby="upload-content-menu" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">Upload content</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <ul>
          <li>
            <a data-href="video" class="upload-content-item">
              Video
            </a>
          </li>
          <li>
            <a data-href="presentation" class="upload-content-item">
              Presentation
            </a>
          </li>
          <li>
            <a data-href="poster"  class="upload-content-item">
              Posters
            </a>
          </li>
          <li>
            <a data-href="paper" class="upload-content-item">
              Papers
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
