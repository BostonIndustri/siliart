<?php
/**
 * Forums Loop card/cover
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$layout       = get_theme_mod( 'forum_archive_layout', 'default' );
$layout_class = '';
$grid_class   = 'lg-wb-grid-1-3';

if ( $layout == 'cover' && bbp_is_forum_archive() && is_archive() ) {
	$grid_class = 'lg-wb-grid-1-4';
}

if ( $layout == 'cover' ) {
	$layout_class = 'rg-forum-details';
}
?>

<li class="wb-grid-cell sm-wb-grid-1-2 md-wb-grid-1-2 lg-wb-grid-1-3 <?php echo $grid_class; ?>">
	<div class="rg-cover-list-item">
		<?php if ( function_exists( 'bbp_get_forum_thumbnail_image' ) ) { ?>
			<a href="<?php bbp_forum_permalink(); ?>" class="rg-cover-wrap" title="<?php bbp_forum_title(); ?>">
				<?php echo bbp_get_forum_thumbnail_image( bbp_get_forum_id(), 'large', 'full' ); ?>
			</a>
		<?php } else { ?>
			<a href="<?php bbp_forum_permalink(); ?>" class="rg-cover-wrap" title="<?php bbp_forum_title(); ?>">
				<?php //echo bbp_get_forum_thumbnail_image( bbp_get_forum_id(), 'large', 'full' ); ?>
			</a>
		<?php } ?>

		<div class="rg-card-forum-details <?php echo $layout_class; ?>">
			<div class="rg-sec-header">
				<?php do_action( 'bbp_theme_before_forum_title' ); ?>
				<h3><a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h3>
				<?php do_action( 'bbp_theme_after_forum_title' ); ?>
			</div>

			<div class="rg-forum-content-wrap">
				<?php do_action( 'bbp_theme_before_forum_description' ); ?>
				<div class="rg-forum-content"><?php echo wp_trim_words( bbp_get_forum_content( bbp_get_forum_id() ), 18, '&hellip;' ); ?></div>
				<?php do_action( 'bbp_theme_after_forum_description' ); ?>
			</div>

			<div class="forums-meta rg-forums-meta">
			<?php
				do_action( 'bbp_theme_before_forum_sub_forums' );

				$r = array(
					'before'           => '',
					'after'            => '',
					'link_before'      => '<span>',
					'link_after'       => '</span>',
					'count_before'     => ' (',
					'count_after'      => ')',
					'count_sep'        => ', ',
					'separator'        => ' ',
					'forum_id'         => '',
					'show_topic_count' => false,
					'show_reply_count' => false,
				);

				bbp_list_forums( $r );

				do_action( 'bbp_theme_after_forum_sub_forums' );
				?>
				</div>

			<?php if ( $layout != 'cover' ) { ?>
				<div class="rg-timestamp">
					<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
					<?php bbp_forum_freshness_link(); ?>
					<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</li>
