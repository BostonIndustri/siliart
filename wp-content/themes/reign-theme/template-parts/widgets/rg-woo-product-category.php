<?php
/**
 * Reign WooCommerce Product Category Widget
 *
 * @package reign
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cat_args = apply_filters(
	'widget_rg_woo_product_categories_args',
	array(
		'orderby'    => 'name',
		'hide_empty' => true,
	)
);

if ( $atts['show_parent_categories_only'] ) {
	$cat_args['parent'] = 0;
}

if ( ! empty( $atts['count'] ) ) {
	$cat_args['number'] = $atts['count'];
}

$selected_categories = $atts['selected_categories'];
if ( ! empty( $selected_categories ) ) {
	$selected_categories = trim( $selected_categories );
	$selected_categories = explode( ',', $selected_categories );
	if ( is_array( $selected_categories ) ) {
		$cat_args['include'] = $selected_categories;
	}
}

$categories         = get_terms( 'product_cat', $cat_args );
$ul_wrapper_class   = ( $atts['enable_slider'] ) ? 'rg-woo-category-slider-wrap' : '';
$li_wb_grid_classes = 'wb-grid-cell sm-wb-grid-1-2 md-wb-grid-1-' . $atts['per_row'];
$data_slick         = '{"slidesToShow": ' . $atts['per_row'] . ', "slidesToScroll": 1}';
?>
<ul class="wb-grid woocommerce rg-woo-category-wrap <?php echo esc_attr( $atts['layout'] ); ?> <?php echo esc_attr( $ul_wrapper_class ); ?>" data-slick='{"slidesToShow": <?php echo esc_attr( $atts['per_row'] ); ?>, "slidesToScroll": 1}'>
<?php
foreach ( $categories as $category ) {
	if ( 'uncategorized' === $category->slug ) {
		continue;
	}

	$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
	$cat_image    = wp_get_attachment_url( $thumbnail_id );
	if ( ! $cat_image ) {
		$cat_image = wc_placeholder_img_src();
	}
	$style = "background-image: url( '" . esc_url( $cat_image ) . "');";
	if ( ( 'layout-type-3' === $atts['layout'] ) || ( 'layout-type-4' === $atts['layout'] ) || ( 'layout-type-5' === $atts['layout'] ) || ( 'layout-type-6' === $atts['layout'] ) ) {
		$style = '';
	}

	ob_start();
	?>
	<div class="rg-woo-category-img-wrap">
		<img src="<?php echo esc_url( $cat_image ); ?>" loading="lazy" />
	</div>
	<?php
	$rg_woo_category_image = ob_get_clean();

	ob_start();
	?>
	<div class="rg-woo-category-name">
		<a href="<?php echo esc_attr( get_term_link( $category ) ); ?>">
			<h3 class="category-name"><?php echo esc_html( $category->name ); ?></h3>
		</a>
	</div>
	<?php
	$rg_woo_category_name = ob_get_clean();

	ob_start();
	?>
	<div class="rg-woo-category-shop-now">
		<a href="<?php echo esc_attr( get_term_link( $category ) ); ?>" class="button rg-woo-shop-now">
			<?php apply_filters( 'widget_rg_woo_product_categories_shop_now_text', esc_html_e( 'Shop Now', 'reign' ) ); ?>
		</a>
	</div>
	<?php
	$rg_woo_category_shop_now = ob_get_clean();

	if ( $atts['show_count'] ) {
		ob_start();
		?>
		<div class="rg-woo-category-pro-count">
			<span class="rg-woo-pro-circle">
				<?php
				$count = $category->count;
				if ( $count === 1 ) {
					echo esc_attr( $count ) . ' <span class="count-text">' . esc_html__( 'Item', 'reign' ) . '</span>';
				} else {
					echo esc_attr( $count ) . ' <span class="count-text">' . esc_html__( 'Items', 'reign' ) . '</span>';
				}
				?>
			</span>
		</div>
		<?php
		$rg_woo_product_count = ob_get_clean();
	} else {
		$rg_woo_product_count = '';
	}

	echo '<li class="rg-woo-category-item-wrap ' . esc_attr( $atts['layout'] ) . ' ' . esc_attr( $li_wb_grid_classes ) . '">';
	echo '<div class="rg-woo-category-data" style="' . esc_attr( $style ) . '">';
	echo '<div class="rg-woo-category-data-wrapper">';
	switch ( $atts['layout'] ) {
		case 'layout-type-1':
			echo wp_kses_post( $rg_woo_category_name );
			echo wp_kses_post( $rg_woo_product_count );
			echo wp_kses_post( $rg_woo_category_shop_now );
			break;

		case 'layout-type-2':
			echo wp_kses_post( $rg_woo_category_name );
			echo wp_kses_post( $rg_woo_product_count );
			break;

		case 'layout-type-3':
		case 'layout-type-4':
			echo wp_kses_post( $rg_woo_category_image );
			echo wp_kses_post( $rg_woo_category_shop_now );
			echo wp_kses_post( $rg_woo_category_name );
			echo wp_kses_post( $rg_woo_product_count );
			break;

		case 'layout-type-5':
			echo wp_kses_post( $rg_woo_category_image );
			echo wp_kses_post( $rg_woo_category_name );
			echo wp_kses_post( $rg_woo_product_count );
			echo wp_kses_post( $rg_woo_category_shop_now );
			break;

		case 'layout-type-6':
			echo wp_kses_post( $rg_woo_product_count );
			echo wp_kses_post( $rg_woo_category_image );
			echo wp_kses_post( $rg_woo_category_name );
			echo wp_kses_post( $rg_woo_category_shop_now );
			break;

		default:
			break;
	}
	echo '</div>';
	echo '</div>';
	echo '</li>';
}
echo '</ul>';
