<?php
/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_topics_loop' );
?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics">

	<?php
	while ( bbp_topics() ) :
		bbp_the_topic();
		?>

		<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

	<?php endwhile; ?>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php
do_action( 'bbp_template_after_topics_loop' );
