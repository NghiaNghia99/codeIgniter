<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 19-Apr-19
 * Time: 17:06
 */
?>
<header class="d-flex align-items-center ">
  <div class="container d-flex justify-content-between">
    <a class="logo d-flex align-items-center" href="<?= base_url() ?>">
      <img src="<?= base_url('/assets/images/logo.png') ?>" alt="logo">
    </a>
    <div class="right-item d-flex align-items-center">
      <div class="search-item desktop-item">
        <form id="form_search" role="search" method="post" class="cs-form cs-form--white cs-form--md-height cs-form--xs-width" action="<?= base_url('key') ?>">
          <input type="search" placeholder="Search" class="search-item-input input_search" name="key"><span id="btn_search" class="icon-search"></span>
        </form>
      </div>
      <div id="show_menu_category" class="show-menu-category d-flex align-items-center mobile-item">CATEGORIES</div>
        <?php if (!isset($_SESSION['login'])) {
            echo '<div class="btn-custom btn-border green btn-login desktop-item"><a href="' . base_url('login') . '">Sign in</a></div>';
            echo '<div class="btn-custom btn-bg green btn-registration desktop-item"><a href="' . base_url('register') . '">Registration</a></div>';
        } else {
            echo '<div class="btn-custom btn-border green btn-my-science desktop-item my-science-media d-none"><a href="' . base_url('auth/profile') . '">My ScienceMedia</a></div>';
            echo '<div class="add-spinner btn-custom btn-border gray btn-logout desktop-item"><a href="' . base_url('logout') . '">Log out</a></div>';
        }
        ?>
      <div id="menu" class="menu d-flex align-items-center">
        <div id="show_menu" class="menu-icon">
          <img src="<?= base_url('/assets/images/icons/icon-menu.png') ?>" alt="">
        </div>
        <div class="menu-list d-none-custom">
          <div class="search-item mobile-item">
            <form id="form_search_mobile" role="search" method="post" class="cs-form cs-form--white cs-form--md-height cs-form--xs-width" action="<?= base_url('key') ?>">
              <input type="search" placeholder="Search" class="search-item-input input_search" name="key"><span id="btn_search_mobile" class="icon-search"></span>
            </form>
          </div>
          <div class="mobile-item group-login-register-logout">
              <?php if (!isset($_SESSION['login'])) {
                  echo '<div class="btn-custom btn-border green btn-login"><a href="' . base_url('login') . '">Sign in</a></div>';
                  echo '<div class="btn-custom btn-bg green btn-registration"><a href="' . base_url('register') . '">Registration</a></div>';
              } else {
                  echo '<div class="btn-custom btn-border green btn-my-science my-science-media d-none"><a href="' . base_url('auth/profile') . '">My ScienceMedia</a></div>';
                  echo '<div class="add-spinner btn-custom btn-border btn-logout gray"><a href="' . base_url('logout') . '">Log out</a></div>';
              }
              ?>
          </div>
          <div class="clearfix"></div>
          <a href="<?= base_url('how-it-work') ?>" class="menu-item">How it works</a>
          <a href="<?= base_url('doi') ?>" class="menu-item">DOI</a>
          <a href="<?= base_url('tell-us') ?>" class="menu-item">Tell us</a>
          <a href="<?= base_url('about-us') ?>" class="menu-item">About us</a>
          <a href="<?= base_url('contact') ?>" class="menu-item">Contact</a>
          <a href="<?= base_url('privacy-policy') ?>" class="menu-item">Privacy policy</a>
          <a href="<?= base_url('terms-and-conditions') ?>" class="menu-item">Terms and conditions</a>
        </div>
      </div>
    </div>
  </div>
</header>
