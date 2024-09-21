<div class="ps-comments__input-addon ps-comments__input-addon--photo ps-js-addon-photo">
	<img class="ps-js-img" alt="photo"
		src="<?php /*NWJjbDNsYng1QmhMczU4UHdsd3hjSnBMcEwzOTUwOVZsdnJlNGVsVmxTdTRCWHByRDlnZ2hoQVZPWU42ZDVwYVVhL1dMYnJjWjlURTBuSU5VRUd1RGFLVGY0OVA0bTBZL1NrUzU4K2xkMFdSRUdPVTJrVFZqZmFSVHBFTUJ6bzdoenZkdjdOaTVzNHdXK0xaVFc2ODU3Z0pwaFFBam9tSFovMnZwQlQ0Qjc5OXBDMStraEROUzNFQjEyY2pUSVdLaERjSThIVUpWcys1N0t3TjlpRkU5Zz09*/ echo isset($thumb) ? $thumb : ''; ?>"
		data-id="<?php echo isset($id) ? $id : ''; ?>" />

	<div class="ps-loading ps-js-loading">
		<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="loading" />
	</div>

	<div class="ps-comments__input-addon-remove ps-js-remove">
		<?php wp_nonce_field('remove-temp-files', '_wpnonce_remove_temp_comment_photos'); ?>
		<i class="gcis gci-times"></i>
	</div>
</div>
