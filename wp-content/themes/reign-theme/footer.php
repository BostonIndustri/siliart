<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Reign
 */
?>
<?php do_action( 'reign_content_bottom' ); ?>
</div><!-- #content -->
<?php do_action( 'reign_after_content' ); ?>
<?php do_action( 'reign_before_footer' ); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>
	<?php do_action( 'reign_footer' ); ?>
<?php } ?>
<?php do_action( 'reign_after_footer' ); ?>
</div><!-- #page -->
<?php do_action( 'reign_after_page' ); ?>

<?php do_action( 'reign_body_bottom' ); ?>
<?php wp_footer(); ?>

</body>
</html>
