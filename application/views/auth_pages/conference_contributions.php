<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 10-May-19
 * Time: 09:07
 */
?>
<div class="mt-2">
  <img src="" alt="">
  <nav>
    <div class="nav nav-tabs" id="nav-tab-conference-contributions" role="tablist">
        <?php foreach ($count as $key => $value) {
            if ($key == 'Presentation') {
                echo '<a class="nav-item nav-link active" id="nav-conference-presentation-tab" data-toggle="tab" href="#nav-conference-presentation" role="tab" aria-controls="nav-conference-presentation" aria-selected="true">Presentation ' . $value . '</a>';
            } elseif ($key == 'Poster') {
                echo '<a class="nav-item nav-link" id="nav-conference-poster-tab" data-toggle="tab" href="#nav-conference-poster" role="tab" aria-controls="nav-conference-poster" aria-selected="false">Poster ' . $value . '</a>';
            } elseif ($key == 'Video') {
                echo '<a class="nav-item nav-link" id="nav-conference-video-tab" data-toggle="tab" href="#nav-conference-video" role="tab" aria-controls="nav-conference-video" aria-selected="false">Video ' . $value . '</a>';
            } elseif ($key == 'Paper') {
                echo '<a class="nav-item nav-link" id="nav-conference-paper-tab" data-toggle="tab" href="#nav-conference-paper" role="tab" aria-controls="nav-conference-paper" aria-selected="false">Paper ' . $value . '</a>';
            }
        }
        ?>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent-conference-contributions">
    <div class="tab-pane fade show active" id="nav-conference-presentation" role="tabpanel"
         aria-labelledby="nav-conference-presentation-tab">
        <?php
        if (count($presentations) > 0) {
            foreach ($presentations as $post) {
                echo '<img style="width: 200px" src="/assets/images/video_avatar_default.jpg" alt="">';
                echo '<h2><a href="' . base_url('video/' . $post['id']) . '">' . $post['presTitle'] . '</a></h2>';
                echo '<p><i class="limitTextCaption">' . $post['caption'] . '</i></p>';
                echo '<p>View: ' . $post['views'] . '</p>';
            }
        } else {
            echo '<p>There are no uploaded presentations yet.</p>';
        }
        ?>
    </div>
    <div class="tab-pane fade" id="nav-conference-poster" role="tabpanel" aria-labelledby="nav-conference-poster-tab">
        <?php
        if (count($posters) > 0) {
            foreach ($posters as $post) {
                echo '<img style="width: 200px" src="/assets/images/video_avatar_default.jpg" alt="">';
                echo '<h2><a href="' . base_url('video/' . $post['id']) . '">' . $post['posterTitle'] . '</a></h2>';
                echo '<p><i class="limitTextCaption">' . $post['caption'] . '</i></p>';
                echo '<p>View: ' . $post['views'] . '</p>';
            }
        } else {
            echo '<p>There are no uploaded presentations yet.</p>';
        }
        ?>
    </div>
    <div class="tab-pane fade" id="nav-conference-video" role="tabpanel" aria-labelledby="nav-conference-video-tab">
        <?php
        if (count($videos) > 0) {
            foreach ($videos as $post) {
                echo '<img style="width: 200px" src="/assets/images/video_avatar_default.jpg" alt="">';
                echo '<h2><a href="' . base_url('video/' . $post['id']) . '">' . $post['title'] . '</a></h2>';
                echo '<p><i class="limitTextCaption">' . $post['caption'] . '</i></p>';
                echo '<p>View: ' . $post['views'] . '</p>';
            }
        } else {
            echo '<p>There are no uploaded presentations yet.</p>';
        }
        ?>
    </div>
    <div class="tab-pane fade" id="nav-conference-paper" role="tabpanel" aria-labelledby="nav-conference-paper-tab">
        <?php
        if (count($papers) > 0) {
            foreach ($papers as $post) {
                echo '<img style="width: 200px" src="/assets/images/video_avatar_default.jpg" alt="">';
                echo '<h2><a href="' . base_url('video/' . $post['id']) . '">' . $post['paperTitle'] . '</a></h2>';
                echo '<p><i class="limitTextCaption">' . $post['caption'] . '</i></p>';
                echo '<p>View: ' . $post['views'] . '</p>';
            }
        } else {
            echo '<p>There are no uploaded presentations yet.</p>';
        }
        ?>
    </div>
  </div>
</div>
