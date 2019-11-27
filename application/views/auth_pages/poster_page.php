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
$banner_file = base_url('/uploads/userfiles/' . $post['idAuthor'] . '/posters/' . $post['id'] . '.jpg');

?>
<div class="section-post-page">
  <div class="top-content">
    <div class="title-section">
      Poster content
    </div>
    <div class="sm-menu-tab">
      <ul class="menu-post-detail">
        <a class="menu-view active" href="<?= base_url('auth/content/poster/' . $post['id']) ?>">
          Poster
        </a>
        <a class="menu-edit" href="<?= base_url('auth/content/poster/edit/' . $post['id']) ?>">
          Edit
        </a>
        <a class="menu-request-doi" href="<?= base_url('auth/content/poster/request-doi/' . $post['id']) ?>">
          Request DOI
        </a>
        <a class="menu-link-to-conference" href="<?= base_url('auth/content/poster/link-to-conference/' . $post['id']) ?>">
          Link to conference
        </a>
      </ul>
      <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
      <button class="btn btn-popup delete-menu btn-delete-poster">
        Delete Poster
      </button>
    </div>
  </div>
  <div class="block-white tab-menu-content view-tab-content">
    <a href="<?= base_url($post['path'] . '.pdf') ?>" target="_blank" class="banner-item">
      <img src="<?= $banner_file ?>" alt="">
    </a>
    <div class="post-page-info">
      <div class="title small-title"><?= $post['posterTitle'] ?></div>
      <div class="desc-list">
        <div class="desc-list-item views-item"><span class="icon-views"></span><?= $post['views'] ?> views</div>
        <div class="desc-list-item social-item desktop-item">
          <div style="margin-right: 3px" class="fb-like" data-href="<?= base_url('poster/' . $post['id']) ?>"
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
            <script type="IN/Share" data-url="<?= base_url('poster/' . $post['id']) ?>"></script>
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
                echo '<a>' . $post['coAuthors'] . '</a>';
            } else {
                echo 'Empty';
            }
            ?>
        </div>
        <div class="show-info-item-mr-8 <?php if (!empty($post['posterAffiliation'])) {
            echo 'display-block';
        } ?>">
          <div>Affiliation</div>
          <div>
              <?php
              if (!empty($post['posterAffiliation'])) {
                  echo $post['posterAffiliation'];
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
          <div>Abstract</div>
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
          <div>Link this poster</div>
          <div>
              <?php
              echo '<a class="link" href="' . $this->config->base_url() . 'poster/' . $post['id'] . '">' . $this->config->base_url() . 'poster/' . $post['id'] . '</a>';
              ?>
          </div>
        </div>
        <div class="download-item">Do you have problems viewing the pdf-file? Download poster
            <a href="<?= base_url($post['path'] . '.pdf') ?>" download="poster.pdf">here</a>
        </div>
        <div class="qr-item desktop-item">
          <img
            src="http://chart.apis.google.com/chart?chs=90x90&cht=qr&chl=<?= base_url('poster/' . $post['id']) ?>">
        </div>
      </div>
      <div class="social-qr-item mobile-item">
        <div class="social-item">
          <div style="margin-right: 3px" class="fb-like" data-href="<?= base_url('poster/' . $post['id']) ?>"
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
            <script type="IN/Share" data-url="<?= base_url('poster/' . $post['id']) ?>"></script>
          </div>
        </div>
        <div class="qr-item">
          <img
            src="http://chart.apis.google.com/chart?chs=90x90&cht=qr&chl=<?= base_url('poster/' . $post['id']) ?>">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete poster
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="title">
            <?= $post['posterTitle'] ?>
        </div>
        <div class="modal-description">
        </div>
      </div>
      <div class="sm-modal-footer d-none">
        <input type="hidden" class="get-id-post" value="<?= $post['id'] ?>">
        <button class="btn-custom btn-bg green btn-delete btn-delete-poster-confirm" data-dismiss="modal">Delete poster</button>
      </div>
    </div>
  </div>
</div>
<div class="modal sm-modal" id="deleteStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content sm-modal-content">
      <div class="sm-modal-header">
        <h5 class="sm-modal-title" id="exampleModalLabel">
          Delete poster
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="icon-cancel"></span>
        </button>
      </div>
      <div class="sm-modal-body">
        <div class="modal-description">
        </div>
      </div>
    </div>
  </div>
</div>