<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Reign_Theme_Options_Manager' ) ) :

	/**
	 * @class Reign_Theme_Options_Manager
	 */
	class Reign_Theme_Options_Manager {

		/**
		 * The single instance of the class.
		 *
		 * @var Reign_Theme_Options_Manager
		 */
		protected static $_instance = null;
		protected static $_slug     = 'reign_pages';

		/**
		 * Main Reign_Theme_Options_Manager Instance.
		 *
		 * Ensures only one instance of Reign_Theme_Options_Manager is loaded or can be loaded.
		 *
		 * @return Reign_Theme_Options_Manager - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Reign_Theme_Options_Manager Constructor.
		 */
		public function __construct() {
			$this->init_hooks();
			$this->includes();
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {
			add_action( 'admin_menu', array( $this, 'reign_settings_page_init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'render_vertical_skeleton_scripts' ) );

			// Redirect admin after theme switch.
			add_action( 'after_switch_theme', array( $this, 'redirect_admin' ) );

			// Hide all admin notices.
			add_action( 'admin_init', array( $this, 'reign_hide_all_admin_notices_from_reign_options' ) );

			// Enqueue block editor assets.
			add_action( 'enqueue_block_editor_assets', array( $this, 'reign_block_editor_styles' ), 1 );
		}

		/**
		 * Hide Notices
		 *
		 * @since 7.3.5
		 * @access public
		 * @return void
		 */
		public function reign_hide_all_admin_notices_from_reign_options() {
			if ( is_admin() && ( isset( $_GET['page'] ) && 'reign-options' == $_GET['page'] ) ) {
				remove_all_actions( 'admin_notices' );
				remove_all_actions( 'all_admin_notices' );
			}
		}

		/**
		 * Redirect Admin
		 *
		 * @since 7.3.5
		 * @access public
		 * @return void
		 */
		public function redirect_admin() {
			if ( current_user_can( 'edit_theme_options' ) ) {
				header( 'Location:' . admin_url() . 'admin.php?page=reign-options' );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
			include_once 'get-started-options.php';
			// include_once 'reign-pages-options.php';
			include_once 'buddy-extender-options.php';
			include_once 'peepso-extender-options.php';
			include_once 'wbcom-support-tab.php';
		}

		public function reign_settings_page_init() {
			// Submenu pages.
			add_submenu_page(
				'reign-settings',
				__( 'Reign Settings', 'reign' ),
				__( 'Reign Settings', 'reign' ),
				'manage_options',
				'reign-options',
				array( $this, 'reign_settings_page' )
			);
		}

		public function reign_settings_page() {
			global $pagenow;
			?>
			<div class="wrap reign-theme-admin-wrap">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Howdy Admin', 'reign' ); ?></h2>
				<div class="reign-greetings">
					<div class="greetings-container">
						<div class="greetings-texts">
							<h1><?php esc_html_e( 'Welcome to Reign Theme!', 'reign' ); ?></h1>
							<strong class="theme-version"><?php echo sprintf( __( 'Version - %s', 'reign' ), REIGN_THEME_VERSION ); ?></strong>
							<p class="about-text"><?php esc_html_e( 'Welcome and thank you for purchasing Reign Theme, one of the most beautiful and advanced social network WordPress themes.', 'reign' ); ?></p>
						</div>
					</div>
				</div>
				<?php
				if ( isset( $_GET['updated'] ) && 'true' == esc_attr( $_GET['updated'] ) ) {
					echo '<div class="updated" ><p>' . __( ' Theme Settings updated.', 'reign' ) . '</p></div>';
				}

				$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'get_started';
				$this->reign_admin_tabs( $tab );
				?>
				<div id="rg-poststuff">
					<div class="rg-poststuff-inner">
						<div class="reign-theme-options-wrapper">
							<div class="reign-settings-loader"></div>
							<form id="reign-theme-options-form" method="post" action="<?php admin_url( 'admin.php?page=reign-options' ); ?>" style="display:none;">
								<?php
								wp_nonce_field( 'reign-options' );
								if ( $pagenow == 'admin.php' && $_GET['page'] == 'reign-options' ) {
									do_action( 'render_theme_options_page_for_' . $tab );
								}
								?>
							</form>
							<div class="reign-option-info-wrapper need-help-advice">
								<div class="reign-option-support-container">
									<h3 class="option-title"><?php esc_html_e( 'Need help or advice?', 'reign' ); ?></h3>
									<p class="option-desc"><?php esc_html_e( 'Got a question or need help with the theme? You can always submit a support ticket or ask for help in our friendly Facebook community.', 'reign' ); ?></p>
									<div class="option-link-area">
										<a class="option-link" href="<?php echo esc_url( 'https://wbcomdesigns.com/support/' ); ?>" target="_blank"><?php esc_html_e( 'Submit a Support Ticket', 'reign' ); ?></a>
										<a class="option-link reign-facebook-community" href="<?php echo esc_url( 'https://www.facebook.com/groups/191523257634994' ); ?>" target="_blank"><?php esc_html_e( 'Join Facebook Community', 'reign' ); ?></a>
									</div>						
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php do_action( 'render_content_after_form', $tab ); ?>
			</div>
			<?php
		}

		public function reign_admin_tabs( $current ) {
			$tabs = array();
			$tabs = apply_filters( 'alter_reign_admin_tabs', $tabs );

			echo '<div class="nav-tab-wrapper reign-nav-tab-wrapper">';
			foreach ( $tabs as $tab => $name ) {
				$class = ( $tab == $current ) ? 'nav-tab-active' : '';
				echo "<a class='" . esc_attr( strtolower( $name ) ) . " nav-tab $class' href='?page=reign-options&tab=$tab'>$name</a>";
			}
			echo '</div>';
		}

		public function render_vertical_skeleton_scripts() {
			// $screen = get_current_screen();
			// if ( $screen->id != 'reign-settings_page_reign-options' ) {
			// return;
			// }
			if ( ( ! isset( $_GET['page'] ) ) || ( 'reign-options' !== $_GET['page'] ) ) {
				return;
			}

			wp_register_script(
				$handle    = 'reign_vertical_tabs_skeleton_js',
				$src       = get_template_directory_uri() . '/assets/js/vertical-tabs-skeleton.js',
				$deps      = array( 'jquery' ),
				$ver       = REIGN_THEME_VERSION,
				$in_footer = true
			);

			$wb_social_links_html = '';
			ob_start();
			?>
			<div class="wbtm_social_links_container">
				<div class="wbtm_social_link_section">
					<h3 class="wbtm_social_link_toggle_head">
						<?php esc_html_e( 'New Site', 'reign' ); ?>
					</h3>
					<div class="wbtm_social_link_info_box">
						<div class="img_section">
							<?php if ( class_exists( 'PeepSo' ) ) { ?>
								<input class="reign_default_cover_image_url" type="hidden" name="reign_peepsoextender[wbtm_social_links][{{unique_key}}][img_url]" value="
								<?php
								if ( isset( $social_link['img_url'] ) ) {
									echo $social_link['img_url'];
								}
								?>
								" required="required" />
								<?php } else { ?>
								<input class="reign_default_cover_image_url" type="hidden" name="reign_buddyextender[wbtm_social_links][{{unique_key}}][img_url]" value="<?php echo isset( $social_link['img_url'] ) ? $social_link['img_url'] : ''; ?>" required="required" />
							<?php } ?>
							<img class="reign_default_cover_image" src="
							<?php
							if ( isset( $social_link['img_url'] ) ) {
								echo $social_link['img_url'];
							}
							?>
							" style="display: none;" />
							<input id="reign-upload-button" type="button" class="button reign-upload-button" value="<?php _e( 'Upload Icon', 'reign' ); ?>" />
							<a href="#" class="reign-remove-file-button" rel="avatar_default_image" style="display: none;" >
								<?php esc_html_e( 'Remove Icon', 'reign' ); ?>
							</a>
						</div>
						<div class="name_section">
							<?php if ( class_exists( 'PeepSo' ) ) { ?>
								<input type="text" class="wbtm-social-link-inp" name="reign_peepsoextender[wbtm_social_links][{{unique_key}}][name]" placeholder="<?php _e( 'New Site', 'reign' ); ?>" required="required" />
							<?php } else { ?>
								<input type="text" class="wbtm-social-link-inp" name="reign_buddyextender[wbtm_social_links][{{unique_key}}][name]" placeholder="<?php _e( 'New Site', 'reign' ); ?>" required="required" />
							<?php } ?>
						</div>
						<div class="del_section">
							<button><?php esc_html_e( 'Delete', 'reign' ); ?></button>
						</div>
					</div>
				</div>
			</div>
			<?php
			$wb_social_links_html = ob_get_clean();
			wp_localize_script(
				'reign_vertical_tabs_skeleton_js',
				'reign_vertical_tabs_skeleton_js_params',
				array(
					'ajax_url'                => admin_url( 'admin-ajax.php' ),
					'home_url'                => get_home_url(),
					'wb_social_links_html'    => $wb_social_links_html,
					'wb_social_links_default' => __( 'New Site', 'reign' ),
				)
			);
			wp_enqueue_script( 'reign_vertical_tabs_skeleton_js' );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			if ( ! wp_script_is( 'jquery-ui-accordion', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-accordion' );
			}
			if ( ! wp_script_is( 'jquery-ui-sortable', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}

			$rtl_css = is_rtl() ? '-rtl' : '';

			wp_register_style(
				$handle = 'reign-vertical-tabs-skeleton-css',
				$src    = get_template_directory_uri() . '/assets/css' . $rtl_css . '/vertical-tabs-skeleton.min.css',
				$deps   = array(),
				$ver    = REIGN_THEME_VERSION,
				$media  = 'all'
			);
			wp_enqueue_style( 'reign-vertical-tabs-skeleton-css' );
		}

		/**
		 * Block editor styles.
		 */
		public function reign_block_editor_styles() {
			$rtl_css = is_rtl() ? '-rtl' : '';

			wp_enqueue_style( 'reign-block-editor-styles', get_template_directory_uri() . '/assets/css' . $rtl_css . '/style-editor-block.css', '', REIGN_THEME_VERSION );
		}
	}

	endif;

/**
 * Main instance of Reign_Theme_Options_Manager.
 *
 * @return Reign_Theme_Options_Manager
 */
Reign_Theme_Options_Manager::instance();
?>
