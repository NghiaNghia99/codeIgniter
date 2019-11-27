<?php

    /**
     * Created by PhpStorm.
     * User: bssdev
     * Date: 22-Apr-19
     * Time: 13:48
     */
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="<?= base_url('/assets/images/favicon.ico') ?>">

  <title>Science Media</title>

  <link rel="stylesheet" href="<?= base_url('/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/node_modules/datatables/media/css/jquery.dataTables.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/assets/css/buttons.dataTables.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/node_modules/select2/dist/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/node_modules/mediaelement/build/mediaelementplayer.min.css') ?>">
  <link rel="stylesheet"
        href="<?= base_url('/node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
  <!-- calendar -->
  <link rel="stylesheet" href="<?= base_url('node_modules/@fullcalendar/core/main.css') ?>">
  <link rel="stylesheet" href="<?= base_url('node_modules/@fullcalendar/daygrid/main.css') ?>">
  <link rel="stylesheet" href="<?= base_url('node_modules/@fullcalendar/timegrid/main.css') ?>">
  <link rel="stylesheet" href="<?= base_url('node_modules/@fullcalendar/list/main.css') ?>">
  <!-- gantt chart -->
  <!--  <link rel="stylesheet" href="-->
    <? //= base_url('/assets/css/gantt-chart/jquery-ui-1.8.4.css')
    ?>
  <!--">-->
  <link rel="stylesheet" href="<?= base_url('/assets/css/gantt-chart/jsgantt.css') ?>">


  <!-- select multiple options -->
  <link rel="stylesheet" href="<?= base_url('/node_modules/bootstrap-select/dist/css/bootstrap-select.min.css') ?>">

  <link rel="stylesheet" href="<?= base_url('/assets/css/styles.css') ?>">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <!--MathJax-->
  <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
      tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
    });



  </script>
  <script type="text/javascript" async
          src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML">
  </script>
  <script src="<?= base_url('/assets/js/gantt-chart/jsgantt.js') ?>"></script>
</head>

<body class="<?php if (isset($bodyClass)) {
    echo $bodyClass;
}
    if (isset($_SESSION['auth_page'])) {
        echo ' auth-page';
    } ?>">
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script>
<?php
    if (!empty($header)) {
        echo $header;
    }
    if (!empty($menu_category)) {
        echo $menu_category;
    }
    if (!empty($auth_top_header)) {
        echo $auth_top_header;
    }
    echo '<div class="wrapper-content container-custom setHeightContent">';
    echo '<div>';
    if (!empty($auth_profile_sidebar)) {
        echo $auth_profile_sidebar;
    }
    if (!empty($auth_content_sidebar)) {
        echo $auth_content_sidebar;
    }
    if (!empty($auth_conference_sidebar)) {
        echo $auth_conference_sidebar;
    }
    if (!empty($auth_project_sidebar)) {
        echo $auth_project_sidebar;
    }
    echo '<div class="section">';
    if (!empty($page)) {
        echo $page;
    }
    if (!empty($auth_page)) {
        echo $auth_page;
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
    if (!empty($footer)) {
        echo $footer;
    }
?>
<div class="spinner-block d-none">
  <div class="spinner-item">
    <img src="/assets/images/icon-loading.gif">
  </div>
</div>
<div class="modal fade progressBarModal" id="progressBarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title small-title" id="exampleModalCenterTitle">File upload</h5>
      </div>
      <div class="modal-body">
        <div class="img-item">
          <img src="/assets/images/ScienceMedia_Ball_02_Scaled100px.gif" alt="">
        </div>
        <div class="text-item">
          Please wait, while we are uploading (progress bar) and processing the file(s).
          The processing of the files may take some additional minutes...
        </div>
        <progress id="progressBar" value="0" max="100"></progress>
        <h3 id="status" class="status-item">abc</h3>
      </div>
    </div>
  </div>
</div>
<div class="notification-modal d-none"></div>
<input type="hidden" id="get_base_url" value="<?= base_url() ?>"/>
<script src="<?= base_url('/node_modules/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?= base_url('/node_modules/popper.js/dist/umd/popper.min.js') ?>"></script>
<script src="<?= base_url('/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('/node_modules/bootstrap-3-typeahead/bootstrap3-typeahead.min.js') ?>"></script>
<script src="<?= base_url('/node_modules/datatables/media/js/jquery.dataTables.js') ?>"></script>
<script src="<?= base_url('/assets/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/buttons.print.js') ?>"></script>
<script src="<?= base_url('/assets/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('/node_modules/select2/dist/js/select2.min.js') ?>"></script>
<script src="<?= base_url('/node_modules/mediaelement/build/mediaelement-and-player.min.js') ?>"></script>

<!-- select multiple options -->
<script src="<?= base_url('/node_modules/bootstrap-select/dist/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/country-state-select.js') ?>"></script>
<script src="<?= base_url('/assets/js/ckeditor/ckeditor.js') ?>"></script>

<?php
    if (!empty($active_project_sidebar) && $active_project_sidebar == "Calendar") {
        echo '<script src="' . base_url("/assets/js/calendar/core-main.js") . '"></script>';
        echo '<script src="' . base_url("/assets/js/calendar/interaction-main.js") . '"></script>';
        echo '<script src="' . base_url("/assets/js/calendar/daygrid-main.js") . '"></script>';
        echo '<script src="' . base_url("/assets/js/calendar/data-calendar.js") . '"></script>';
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="<?= base_url('/node_modules/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/split.js/1.5.11/split.min.js"></script>
<script src="<?= base_url('/assets/js/jquery.sorttable.js') ?>"></script>
<script src="<?= base_url('/assets/js/custom.js') ?>"></script>
<script src="<?= base_url('/assets/js/co_author.js') ?>"></script>
<script src="<?= base_url('/assets/js/project.js') ?>"></script>
</body>

</html>