<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 14-May-19
 * Time: 16:04
 */
//var_dump($conference);
?>


<?php if (isset($_SESSION['conference'])) : ?>
  <div class="mt-2">
    <span>Edit Conference</span>
    <a class="p-2"
       href="<?= base_url('auth/conference/' . $_SESSION['conference']['type'] . '/conference-edit/' . $_SESSION['conference']['id']) ?>">Conference
      page preview</a>
    <a class="p-2"
       href="<?= base_url('auth/conference/' . $_SESSION['conference']['type'] . '/conference-edit/basic-information/' . $_SESSION['conference']['id']) ?>">Basic
      information</a>
    <a class="p-2"
       href="<?= base_url('auth/conference/' . $_SESSION['conference']['type'] . '/conference-edit/optional-information/' . $_SESSION['conference']['id']) ?>">Optional
      information</a>
    <a class="p-2"
       href="<?= base_url('auth/conference/' . $_SESSION['conference']['type'] . '/conference-edit/file-upload/' . $_SESSION['conference']['id']) ?>">File
      upload</a>
    <a class="p-2"
       href="<?= base_url('auth/conference/' . $_SESSION['conference']['type'] . '/conference-edit/change-cid' . $_SESSION['conference']['id']) ?>">Change
      CID</a>
  </div>
<?php endif; ?>
<div class="mt-2">
  <img src="" alt="">
  <nav>
    <div class="nav nav-tabs" id="nav-tab-conference-page" role="tablist">
      <a class="nav-item nav-link active" id="nav-conference-profile-tab" data-toggle="tab"
         href="#nav-conference-profile" role="tab" aria-controls="nav-conference-profile" aria-selected="true">Conference
        profile</a>
      <a class="nav-item nav-link" id="nav-conference-programme-tab" data-toggle="tab" href="#nav-conference-programme"
         role="tab" aria-controls="nav-conference-programme" aria-selected="false">Conference programme</a>
      <a class="nav-item nav-link" id="nav-important-dates-tab" data-toggle="tab" href="#nav-important-dates" role="tab"
         aria-controls="nav-important-dates" aria-selected="false">Important dates</a>
      <a class="nav-item nav-link" id="nav-registration-payment-tab" data-toggle="tab" href="#nav-registration-payment"
         role="tab" aria-controls="nav-registration-payment" aria-selected="false">Registration and payment</a>
      <a class="nav-item nav-link" id="nav-venue-hotel-travel-tab" data-toggle="tab" href="#nav-venue-hotel-travel"
         role="tab" aria-controls="nav-venue-hotel-travel" aria-selected="false">Venue, hotel, travel</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent-conference-page">
    <div class="tab-pane fade show active" id="nav-conference-profile" role="tabpanel"
         aria-labelledby="nav-conference-profile-tab">
      <p>
        <b><?= $conference['confSeries'] ?></b> <?php if ($checkActive) echo '<span style="background-color: green; color: white; padding: 3px">Conference open</span>'; else echo '<span style="background-color: gray; color: white; padding: 3px">Conference closed</span>'; ?>
      </p>
      <h3><?= $conference['confTitle'] ?></h3>
      <p>CID: <?= $conference['CID'] ?></p>
      <p>Hosted by: <a
          href="<?= base_url('summary-profile/video/' . $conference['id_user']) ?>"><?= $conference['firstName'] ?> <?= $conference['lastName'] ?></a>
      </p>
      <p>Affiliation: <?= $conference['affiliation'] ?></p>
      <p>Organizing institutions: <?= $conference['organizingInstitutions'] ?></p>
      <p>Main category: <?= $conference['category_name'] ?> (<?= $conference['subcategory_name'] ?>)</p>
        <?php
        if (!empty($alt_category['alt_category_name'])) {
            echo '<p>Alternative category: ' . $alt_category['alt_category_name'];
            if (!empty($alt_category['alt_subcategory_name'])) {
                echo '(' . $alt_category['alt_subcategory_name'] . ')</p>';
            } else {
                echo '</p>';
            }
        }
        ?>
      <p>Conference/Workshop objectives: <?= $conference['abstract'] ?></p>
      <p>Location: <?= $conference['confLocation'] ?></p>
      <p>Date: <?= $conference['startDate'] ?> - <?= $conference['endDate'] ?></p>
      <p>Local organizing committee: </p>
      <p>Scientific organizing committee (SOC): </p>
    </div>
    <div class="tab-pane fade" id="nav-conference-programme" role="tabpanel"
         aria-labelledby="nav-conference-programme-tab">
      <p>Sessions:</p>
        <?php
        if (count($sessions) > 0) {
            echo '<ul>';
            foreach ($sessions as $session) {
                echo '<li>' . $session['name'] . '</li>';
            }
            echo '</ul>';
        }
        ?>
      <p>Invited speakers:</p>
      <p>Conference programme:</p>
      <p>Conference abstract book:</p>
    </div>
    <div class="tab-pane fade" id="nav-important-dates" role="tabpanel" aria-labelledby="nav-important-dates-tab">
        <?php
        if (!empty($conference['importantDates'])) {
            echo '<p>' . $conference['importantDates'] . '</p>';
        } else {
            echo '<p>There are no information yet!</p>';
        }
        ?>
    </div>
    <div class="tab-pane fade" id="nav-registration-payment" role="tabpanel"
         aria-labelledby="nav-registration-payment-tab">
        <?php
        if (!empty($conference['registrationPayment'])) {
            echo '<p>' . $conference['registrationPayment'] . '</p>';
        } else {
            echo '<p>There are no information yet!</p>';
        }
        ?>
    </div>
    <div class="tab-pane fade" id="nav-venue-hotel-travel" role="tabpanel" aria-labelledby="nav-venue-hotel-travel-tab">
        <?php
        if (!empty($conference['venue'])) {
            echo '<p>Conference venue: ' . $conference['venue'] . '</p>';
        } else {
            echo '<p>Conference venue: There are no information yet!</p>';
        }
        if (!empty($conference['hotelInfos'])) {
            echo '<p>Hotel information: ' . $conference['hotelInfos'] . '</p>';
        } else {
            echo '<p>Hotel information: There are no information yet!</p>';
        }
        if (!empty($conference['travelInformation'])) {
            echo '<p>Travel information: ' . $conference['travelInformation'] . '</p>';
        } else {
            echo '<p>Travel information: There are no information yet!</p>';
        }
        ?>
    </div>
  </div>
</div>
