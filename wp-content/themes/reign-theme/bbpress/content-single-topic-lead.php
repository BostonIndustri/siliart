<?php
/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<?php do_action( 'bbp_template_before_lead_topic' ); ?>

<ul id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">

	<li class="bbp-header">

		<div class="bbp-topic-author"><?php esc_html_e( 'Creator', 'reign' ); ?></div><!-- .bbp-topic-author -->

		<div class="bbp-topic-content">

			<?php esc_html_e( 'Discussion', 'reign' ); ?>

			<div class="bbp-topic-links">
				<?php bbp_topic_subscription_link(); ?>

				<?php bbp_topic_favorite_link(); ?>
			</div>

		</div><!-- .bbp-topic-content -->

	</li><!-- .bbp-header -->

	<li class="bbp-body">

		<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
			<div class="bbp-topic-header">

				<div class="bbp-topic-author">

					<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

					<?php
					bbp_topic_author_link(
						array(
							'sep'       => '<br />',
							'show_role' => true,
						)
					);
					?>

					<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

				</div><!-- .bbp-topic-author -->

				<div class="bbp-topic__date">
					<span class="bbp-topic-post-date"><?php bbp_topic_post_date(); ?></span>	
				</div><!-- .bbp-topic-date -->

			</div><!-- .bbp-topic-header -->

			<div class="bbp-topic-content">

				<?php do_action( 'bbp_theme_before_topic_content' ); ?>

				<?php bbp_topic_content(); ?>

				<?php do_action( 'bbp_theme_after_topic_content' ); ?>

			</div><!-- .bbp-topic-content -->

			<div class="bbp-topic-footer">

				<div class="bbp-meta">

					<a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>

					<?php do_action( 'bbp_theme_before_topic_admin_links' ); ?>

					<?php bbp_topic_admin_links(); ?>

					<?php do_action( 'bbp_theme_after_topic_admin_links' ); ?>

				</div><!-- .bbp-meta -->

			</div><!-- .bbp-topic-footer -->

		</div><!-- #post-<?php bbp_topic_id(); ?> -->

	</li><!-- .bbp-body -->

	<li class="bbp-footer">

		<div class="bbp-topic-author"><?php esc_html_e( 'Creator', 'reign' ); ?></div>

		<div class="bbp-topic-content">

			<?php esc_html_e( 'Discussion', 'reign' ); ?>

		</div><!-- .bbp-topic-content -->

	</li>

</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action( 'bbp_template_after_lead_topic' ); ?>
