<div class="section-active-cid">
	<div class="block-white tab-menu-content section-active-cid-content">
		<div class="title">
			Choose CID
		</div>
      <?php if (!empty($listCid)) : ?>
		<div class="list-cid">
			<div class="row">
        <?php foreach ($listCid as $cid) : ?>
				<div class="col-md-6">
					<div class="cid-item">
						<div class="title small-title">
              <?= $cid->cid ?>
						</div>
            <form class="paypal paypal_form" action="<?= base_url('auth/conference/pay-cid/checkout') ?>" method="post">
              <input type="hidden" class="getCID" name="item_number" value="<?= $cid->cid ?>" />
              <input type="button" class="add-spinner btn-custom btn-border green btn-pay btnBuyNowOrderCID" value="Pay now"/>
            </form>
					</div>
				</div>
        <?php endforeach;?>
			</div>
		</div>
    <?php else : ?>
    <div class="search-none-item pb-5">
      <p>There are no cid within this category so far.</p>
    </div>
      <?php endif; ?>
	</div>
</div>