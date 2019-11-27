<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 17-May-19
 * Time: 16:35
 */
?>
<div class="section-register-conference">
	<div class="block-conference-content block-white sm-block-text">
		<div class="title">
			Registration for conference
		</div>
		<p><?= $text ?></p>
		<div class="gr-button">
			<div class="btn-custom btn-bg gray btn-back">
				<a href="<?= base_url('conference/' . $conference->id) ?>">
					Back to Conference Page
				</a>
			</div>
      <?php
      if (!empty($checkAbstractActive)): ?>
        <div class="btn-custom btn-bg green btn-submit">
          <a href="<?= base_url('abstract/' . $conference->id) ?>">
            Submit an Abstract now
          </a>
        </div>
      <?php else: ?>
        <div class="btn-custom btn-bg green btn-submit disabled">
          <a>
            Submit an Abstract now
          </a>
        </div>
      <?php endif; ?>
		</div>
	</div>
</div>
