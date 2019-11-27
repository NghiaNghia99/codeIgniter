<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 17:24
 */

$avatar_jpg = 'uploads/userfiles/' . $post['idAuthor'] . '/profilePhoto.jpg';
if (file_exists($avatar_jpg)) {
    $avatar = $avatar_jpg;
} else {
    $avatar = '/assets/images/small-avatar.jpg';
}
$banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '.jpg');

$filename = FCPATH . '/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '_converted.flv';
if (filesize($filename) > 0 ) $src = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '_converted.flv');
$filename = FCPATH . '/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '_converted.webm';
if (filesize($filename) > 0 ) $src = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '_converted.webm');
$filename = FCPATH . '/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '_converted.mp4';
if (filesize($filename) > 0 ) $src = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/videos/' . $post['id'] . '_converted.mp4');
?>
<div class="section-post-page video-page">
  <div class="container">
    <div class="block-white">
      <div class="scroll-x">
        <div class="navigation-list">
          <div class="navigation-list-item">Home</div>
          <div class="navigation-list-item"><?= $post['category_name'] ?></div>
          <div class="navigation-list-item"><?= $post['subcategory_name'] ?></div>
          <div class="navigation-list-item"><?= $post['title'] ?></div>
        </div>
      </div>
      <div class="video-item">
        <video src="<?= $src ?>" width="100%" height="100%"
               class="mejs__player desktop-item"
               data-mejsoptions='{"pluginPath": "/path/to/shims/", "alwaysShowControls": "true"}'
               poster="<?= $banner_file ?>" controls webkit-playsinline playsinline>
        </video>
        <video src="<?= $src ?>" width="100%" height="212"
               class="mejs__player mobile-item"
               data-mejsoptions='{"pluginPath": "/path/to/shims/", "alwaysShowControls": "true"}'
               poster="<?= $banner_file ?>" controls webkit-playsinline playsinline>
        </video>
      </div>
      <div class="post-page-info">
        <div class="title small-title"><?= $post['title'] ?></div>
        <div class="desc-list">
          <div class="desc-list-item views-item"><span class="icon-views"></span><?= $post['views'] ?> views</div>
          <div class="desc-list-item social-item desktop-item">
            <div style="margin-right: 3px" class="fb-like" data-href="<?= base_url('video/' . $post['id']) ?>"
                 data-width="47"
                 data-layout="button" data-action="like" data-size="small" data-show-faces="false"
                 data-share="true"></div>
            <div style="margin-bottom: -1px; margin-right: 4px">
              <a href="http://twitter.com/share" class="twitter-share-button" data-count="none"
                 data-via="">Tweet</a>
              <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </div>
            <div class="btn-share-linked">
              <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
              <script type="IN/Share" data-url="<?= base_url('video/' . $post['id']) ?>"></script>
            </div>
          </div>
        </div>
        <div class="content-item">
          <div class="show-info-item-mr-8 author-item">
            <div class="author-item-img">
              <img src="<?= base_url($avatar); ?>" alt="Avatar"/>
            </div>
            <div class="author-item-name">
                <?php echo '<a class="link" href="' . base_url('summary-profile/video/' . $post['id_user']) . '">' . $post['firstName'] . ' ' . $post['lastName'] . '</a>' ?>
            </div>
          </div>
          <div class="show-info-item-mr-8 date-item">
            <span class="icon-calendar"></span>
            <div>
                <?php
                if (!empty($post['dateOfUpload'])) {
                    echo date('d.m.Y', $post['dateOfUpload']);
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
          <div class="show-info-item-mr-8">
            <div>Co-author</div>
              <?php
              if (!empty($post['coAuthors'])) {
                  echo '<a>'. $post['coAuthors'] .'</a>';
              } else {
                  echo 'Empty';
              }
              ?>
          </div>
          <div class="show-info-item-mr-8 <?php if (!empty($post['videoAffiliation'])) {
              echo 'display-block';
          } ?>">
            <div>Affiliation</div>
            <div>
                <?php
                if (!empty($post['videoAffiliation'])) {
                    echo $post['videoAffiliation'];
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
          <div class="show-info-item-mr-8 <?php if (!empty($post['category_name'])) {
              echo 'display-block';
          } ?>">
            <div>Main category</div>
            <div>
                <?php
                if (!empty($post['category_name'])) {
                    echo $post['category_name'] . ' (' . $post['subcategory_name'] . ')';
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
            <?php if (!empty($alt_category['alt_category_name'])) { ?>
              <div class="show-info-item-mr-8 display-block">
                <div>Alternative category</div>
                <div>
                    <?php echo $alt_category['alt_category_name'] . ' (' . $alt_category['alt_subcategory_name'] . ')'; ?>
                </div>
              </div>
            <?php } ?>
          <div class="show-info-item-mr-8 <?php if (!empty($post['caption'])) {
              echo 'display-block';
          } ?>">
            <div>Caption</div>
            <div>
                <?php
                if (!empty($post['caption'])) {
                    echo $post['caption'];
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
          <div class="show-info-item-mr-8 <?php if (!empty($post['description'])) {
              echo 'd-block';
          } ?>">
            <div>Further information</div>
            <div>
                <?php
                if (!empty($post['description'])) {
                    echo $post['description'];
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
          <div class="show-info-item-mr-8 <?php if (!empty($post['furtherReading'])) {
              echo 'd-block';
          } ?>">
            <div>Further reading</div>
            <div>
                <?php
                if (!empty($post['furtherReading'])) {
                    echo $post['furtherReading'];
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
          <div class="show-info-item-mr-8">
            <div>Language</div>
            <div>
                <?php
                if (!empty($post['language'])) {
                    echo $post['language'];
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
          <div class="show-info-item-mr-8 <?php if (!empty($post['doi'])) {
              echo 'display-block';
          } ?>">
            <div>DOI</div>
            <div>
                <?php
                if (!empty($post['doi'])) {
                    echo $post['doi'];
                } else {
                    echo 'Empty';
                }
                ?>
            </div>
          </div>
            <?php if (!empty($listConference)):?>
              <div class="show-info-item-mr-8 display-block">
                <div>Conference</div>
                <div>
                    <?php
                    $index = 1;
                    foreach ($listConference as $conference):
                        if ($index == 1):
                            ?>
                          <a href="<?= base_url('conference/' . $conference->id) ?>" class="link" ><?= $conference->CID ?></a>
                        <?php else: ?>
                          , <a href="<?= base_url('conference/' . $conference->id) ?>" class="link" ><?= $conference->CID ?></a>
                        <?php endif; $index++; endforeach;?>
                </div>
              </div>
            <?php endif; ?>
          <div class="show-info-item-mr-8 display-block">
            <div>Link this video</div>
            <div>
                <?php
                echo '<a class="link" href="' . $this->config->base_url() . 'video/' . $post['id'] . '">' . $this->config->base_url() . 'video/' . $post['id'] . '</a>';
                ?>
            </div>
          </div>
          <div class="report-post-item">
            If the video contains inappropriate content, please <a class="link" href="<?= base_url('report/' . 'video/' . $post['id']) ?>">report</a> the video. You will be redirected to the landing page.
          </div>
          <div class="qr-item desktop-item">
            <img
              src="http://chart.apis.google.com/chart?chs=90x90&cht=qr&chl=<?= base_url('video/' . $post['id']) ?>">
          </div>
        </div>
        <div class="social-qr-item mobile-item">
          <div class="social-item">
            <div style="margin-right: 3px" class="fb-like" data-href="<?= base_url('video/' . $post['id']) ?>"
                 data-width="47"
                 data-layout="button" data-action="like" data-size="small" data-show-faces="false"
                 data-share="true"></div>
            <div style="margin-bottom: -2px; margin-right: 4px">
              <a href="http://twitter.com/share" class="twitter-share-button" data-count="none"
                 data-via="">Tweet</a>
              <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </div>
            <div class="btn-share-linked">
              <script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
              <script type="IN/Share" data-url="<?= base_url('video/' . $post['id']) ?>"></script>
            </div>
          </div>
          <div class="qr-item">
            <img
              src="http://chart.apis.google.com/chart?chs=90x90&cht=qr&chl=<?= base_url('video/' . $post['id']) ?>">
          </div>
        </div>
        <?php if ($checkAuthor): ?>
          <div class="edit-add-to-conference">
            <div class="btn-custom btn-border green special">
              <a href="<?= base_url('auth/content/video/edit/' . $post['id']) ?>">Edit Video</a>
            </div>
            <div class="btn-custom btn-border green special">
              <a href="<?= base_url('auth/content/video/link-to-conference/' . $post['id']) ?>">Add to conference</a>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>