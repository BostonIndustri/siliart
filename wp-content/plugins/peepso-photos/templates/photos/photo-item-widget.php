<?php /*NWJjbDNsYng1QmhMczU4UHdsd3hjSnBMcEwzOTUwOVZsdnJlNGVsVmxTc0dJS2QzNkh5Qk40Q2kyUEpCZEFEanVZb0E0U0h0MzlVUEhHMVFaNkhJT2ZuNGtoL1QrWG1naGtxRFpBR3VXRjRqZTlmbldiZ0VSN0JBN0puWDlIbzVvUlRkeXB2cFFmOGY1dDFTL0JWWnZuajFRRjhiVXN5MnhUWGZINEJSak9Wd0VlWkRZYlFNcW5acXkvNkYwcEZBWWRLY1F6dDZzZmV6T0ZiRnZicVpPdz09*/

wp_enqueue_script('peepso-photos');
wp_enqueue_script('peepso-photos-widget');

?><div class="psw-photos__photo ps-js-photo" data-post-id="<?php echo $pho_post_id; ?>">
	<a class="psw-photos__photo-link" data-id="<?php echo $act_id; ?>" href="#" rel="post-<?php echo $pho_post_id;?>"
			onclick="ps_comments.open('<?php echo $pho_id ?>', 'photo', { <?php
				echo 'nonav: () => ps_widget.nonav(this), ';
				echo 'prev: () => ps_widget.prev(this), ';
				echo 'next: () => ps_widget.next(this)';
			?> }); return false;">
		<img src="<?php echo $pho_thumbs['s_s']; ?>" alt="<?php echo $pho_orig_name;?>" />
	</a>
</div>
