<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Reign
 */
?>
<?php
$download_list_layout = 'rtm-download-item-article rtm-download-layout-1';
$download_id          = get_the_ID();
$download             = edd_get_download( $download_id );
$is_variable_pricing  = $download->has_variable_prices();
$data_price           = '';
$is_single_price_mode = $download->is_single_price_mode() ? 'data-price-mode=multi' : 'data-price-mode=single';
$options              = array();
if ( edd_item_in_cart( $download_id, $options ) && ( ! $is_variable_pricing || ! $download->is_single_price_mode() ) ) {
	$button_text     = __( 'Checkout', 'reign' );
	$href            = esc_url( edd_get_checkout_uri() );
	$class_to_manage = '';

	$button_display   = 'style="display:none;"';
	$checkout_display = '';
} else {
	$button_text     = __( 'Buy Now', 'reign' );
	$href            = 'javascript:void(0);';
	$class_to_manage = 'edd_buy_now';

	$button_display   = '';
	$checkout_display = 'style="display:none;"';
}
if ( ! $is_variable_pricing ) {
	$data_price_value = $download->price;
	$price            = $download->price;
	$data_price       = 'data-price="' . $data_price_value . '"';
}

$button_html = '<a href="' . esc_url( $href ) . '" class="button button-overlay-white edd-add-to-cart ' . esc_attr( $class_to_manage ) . '" data-nonce="' . wp_create_nonce( 'edd-add-to-cart-' . $download_id ) . '" data-action="edd_add_to_cart" data-download-id="' . esc_attr( $download_id ) . '"' . $is_single_price_mode . ' ' . $data_price . ' ' . $button_display . '><span class="button edd-add-to-cart-label">' . esc_html( $button_text ) . '</span><span class="edd-loading" aria-label="' . esc_attr__( 'Loading', 'easy-digital-downloads' ) . '"></span></a>';

$rtm_edd_customization_obj = RTM_EDD_Customization::instance();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $download_list_layout ); ?> >
	<div class="rtm-download-item">
		<div class="rtm-download-item-inner">
			<div class="rtm-download-item-top">
				<div class="edd-download-default-image"></div>
				<?php edd_get_template_part( 'shortcode', 'content-image' ); ?>
				<div class="rtm-download-overlay-layout-1">
					<div class="rtm-hover-lines">
						<div class="rtm-download-action">
							<?php echo '<a href="' . esc_url( edd_get_checkout_uri() ) . '" class="button button-overlay-white edd_go_to_checkout ' . esc_attr( $class_to_manage ) . '" ' . $checkout_display . '>Checkout</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<a href="<?php echo get_the_permalink(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" class="button button-overlay-white">
								<?php esc_html_e( 'Details', 'reign' ); ?>
							</a>
							<?php $rtm_edd_customization_obj->rtm_get_edd_download_price_html(); ?>
							<?php
							if ( class_exists( 'EDD_Front_End_Submissions' ) ) {
								$vendor_store_url = EDD_FES()->vendors->get_vendor_store_url( get_the_author_meta( 'ID' ) );
							} else {
								$vendor_store_url = '';
							}
							do_action( 'edd_download_after_title' );
							?>
							<?php
							if ( ! $is_variable_pricing ) {
								echo $button_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="rtm-download-checkout-popup" style="display: none;">
				<div class="rtm-download-popup-inners">
					<span class="close_edd_popup"><i class="fa fa-times"></i></span>
					<h3 class="section-title"><span><?php esc_html_e( 'Buying Options', 'reign' ); ?></span></h3>
					<?php echo do_shortcode( '[purchase_link id="' . $download_id . '" text="Purchase"]' ); ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- #post-## -->
