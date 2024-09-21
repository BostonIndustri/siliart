<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Reign_Get_Started_Options' ) ) :

	/**
	 * @class Reign_Get_Started_Options
	 */
	class Reign_Get_Started_Options {

		/**
		 * The single instance of the class.
		 *
		 * @var Reign_Get_Started_Options
		 */
		protected static $_instance = null;
		protected static $_slug     = 'get_started';

		/**
		 * Main Reign_Get_Started_Options Instance.
		 *
		 * Ensures only one instance of Reign_Get_Started_Options is loaded or can be loaded.
		 *
		 * @return Reign_Get_Started_Options - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Reign_Get_Started_Options Constructor.
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {
			add_filter( 'alter_reign_admin_tabs', array( $this, 'alter_reign_admin_tabs' ), 10, 1 );
			add_action( 'render_content_after_form', array( $this, 'render_get_started_with_customization_section' ), 10, 1 );
		}

		public function alter_reign_admin_tabs( $tabs ) {
			$tabs[ self::$_slug ] = __( 'Getting Started', 'reign' );
			return $tabs;
		}

		public function render_get_started_with_customization_section( $tab ) {
			if ( $tab != self::$_slug ) {
				return;
			}

			?>
			<style type="text/css">
				div#rg-poststuff {
					display: none;
				}
			</style>
			<?php
			if ( class_exists( 'WBCOM_Elementor_Global_Header_Footer' ) ) {
				$global_header_footer = WBCOM_Elementor_Global_Header_Footer::instance();
				$header_pid           = $global_header_footer->get_hf_post_id( 'reign-elemtr-header' );
				$footer_pid           = $global_header_footer->get_hf_post_id( 'reign-elemtr-footer' );
			}

			$theme_options_quick_links               = array();
			$theme_options_quick_links['site_logo']  = array(
				'option_icon'  => '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 17L12 10M12 10L15 13M12 10L9 13" stroke="#1d76da" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M16 7H12H8" stroke="#1d76da" stroke-width="1.5" stroke-linecap="round"/>
				<path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1d76da" stroke-width="1.5" stroke-linecap="round"/>
				</svg>',
				'option_title' => __( 'Upload Logo', 'reign' ),
				'option_desc'  => __( 'Add your own logo here.', 'reign' ),
				'link_title'   => __( 'Go to option', 'reign' ),
				'link_url'     => esc_url( admin_url( 'customize.php?autofocus[control]=custom_logo&return=' . admin_url( 'admin.php?page=reign-options' ) ) ),
			);
			$theme_options_quick_links['typography'] = array(
				// 'option_icon'  => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M15.8,5.9L10,0L4.2,5.9C1,9.1,1,14.3,4.2,17.6C5.8,19.2,7.9,20,10,20s4.2-0.8,5.8-2.4C19,14.3,19,9.1,15.8,5.9z M10,17.9c-1.6,0-3.2-0.6-4.4-1.8c-1.2-1.2-1.8-2.7-1.8-4.4s0.6-3.2,1.8-4.4L10,2.9V17.9z"></path></svg>',
				'option_icon'  => '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-labelledby="typographyIconTitle" stroke="#1d76da" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" color="#1d76da"><path d="M4 8L5 4H12M20 8L19 4H12M12 4V20M12 20H8M12 20H16"/> </svg>',
				'option_title' => __( 'Set Typography', 'reign' ),
				'option_desc'  => __( 'Choose your own typography for any parts of your website.', 'reign' ),
				'link_title'   => __( 'Go to option', 'reign' ),
				'link_url'     => esc_url( admin_url( 'customize.php?autofocus[section]=reign_typography&return=' . admin_url( 'admin.php?page=reign-options' ) ) ),
			);

			$theme_options_quick_links['page_mapping'] = array(
				'option_icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="#1d76da"><path d="M18,2h-2v16h2c1.1,0,2-0.9,2-2V4C20,2.9,19.1,2,18,2z"></path><path d="M13.1,0H1.9C0.8,0,0,0.9,0,2v16c0,1.1,0.8,2,1.9,2h11.2c1,0,1.9-0.9,1.9-2V2C15,0.9,14.2,0,13.1,0zM13,16c0,0.5-0.5,1-1,1H3c-0.5,0-1-0.5-1-1v-2c0-0.5,0.5-1,1-1h9c0.5,0,1,0.5,1,1V16zM12.5,11h-10C2.2,11,2,10.8,2,10.5C2,10.2,2.2,10,2.5,10h10c0.3,0,0.5,0.2,0.5,0.5C13,10.8,12.8,11,12.5,11z M12.5,8h-10C2.2,8,2,7.8,2,7.5C2,7.2,2.2,7,2.5,7h10C12.8,7,13,7.2,13,7.5C13,7.8,12.8,8,12.5,8zM12.5,5h-10C2.2,5,2,4.8,2,4.5C2,4.2,2.2,4,2.5,4h10C12.8,4,13,4.2,13,4.5C13,4.8,12.8,5,12.5,5z"></path></svg>',
				'option_title' => __( 'Page Mapping', 'reign' ),
				'option_desc'  => __( 'Map login, register and 404 page with custom pages.', 'reign' ),
				'link_title'   => __( 'Go to option', 'reign' ),
				'link_url'     => esc_url( admin_url( 'customize.php?autofocus[section]=reign_page_mapping&return=' . admin_url( 'admin.php?page=reign-options' ) ) ),
			);

			$theme_options_quick_links['colors'] = array(
				'option_icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="#1d76da"><path d="M15.8,5.9L10,0L4.2,5.9C1,9.1,1,14.3,4.2,17.6C5.8,19.2,7.9,20,10,20s4.2-0.8,5.8-2.4C19,14.3,19,9.1,15.8,5.9z M10,17.9c-1.6,0-3.2-0.6-4.4-1.8c-1.2-1.2-1.8-2.7-1.8-4.4s0.6-3.2,1.8-4.4L10,2.9V17.9z"></path></svg>',
				'option_title' => __( 'Color Options', 'reign' ),
				'option_desc'  => __( 'Replace the default primary and hover color by your own colors.', 'reign' ),
				'link_title'   => __( 'Go to option', 'reign' ),
				'link_url'     => esc_url( admin_url( 'customize.php?autofocus[section]=colors&return=' . admin_url( 'admin.php?page=reign-options' ) ) ),
			);

			$theme_options_quick_links['site_header'] = array(
				'option_icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="#1d76da"><path d="M20,17.5v-15C20,1.1,18.9,0,17.5,0h-15C1.1,0,0,1.1,0,2.5v15C0,18.9,1.1,20,2.5,20h15C18.9,20,20,18.9,20,17.5z M18.8,17.6c0,0.6-0.6,1.2-1.2,1.2h-15c-0.7,0-1.2-0.5-1.2-1.2V7h17.5V17.6z"></path></svg>',
				'option_title' => __( 'Header Customization', 'reign' ),
				'option_desc'  => __( 'Manage the look of your header in all way possible.', 'reign' ),
				'link_title'   => __( 'Go to option', 'reign' ),
				'link_url'     => esc_url( admin_url( 'customize.php?autofocus[panel]=reign_header_panel&return=' . admin_url( 'admin.php?page=reign-options' ) ) ),
			);

			$theme_options_quick_links['site_footer'] = array(
				'option_icon'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="#1d76da"><path d="M17.5,0h-15C1.1,0,0,1.1,0,2.5v15C0,18.9,1.1,20,2.5,20h15c1.4,0,2.5-1.1,2.5-2.5v-15C20,1.1,18.9,0,17.5,0z M18.8,13H1.2V2.4c0-0.6,0.6-1.2,1.2-1.2h15c0.7,0,1.2,0.5,1.2,1.2V13z"></path></svg>',
				'option_title' => __( 'Footer Customization', 'reign' ),
				'option_desc'  => __( 'Manage the copyright text, widgets and colors for footer.', 'reign' ),
				'link_title'   => __( 'Go to option', 'reign' ),
				'link_url'     => esc_url( admin_url( 'customize.php?autofocus[panel]=reign_footer_panel&return=' . admin_url( 'admin.php?page=reign-options' ) ) ),
			);

			$theme_options_quick_links = apply_filters( 'reign_alter_theme_options_quick_links', $theme_options_quick_links );

			?>
			<div class="reign-option-section">
				<div class="reign-option-info-wrapper">
					<div class="reign-option-info">
						<h2><?php esc_html_e( 'Customizer Shortcuts', 'reign' ); ?></h2>
						<p><?php esc_html_e( 'Begin customizing the website to give it a unique look.', 'reign' ); ?></p>
					</div>
					<div class="reign-option-boxes">
						<?php
						foreach ( $theme_options_quick_links as $key => $theme_option ) {
							?>
							<div class="reign-option-box">
								<div class="option-wrapper">
									<div class="option-icon"><?php echo isset( $theme_option['option_icon'] ) ? $theme_option['option_icon'] : ''; ?></div>
									<h3 class="option-title"><?php echo esc_html( $theme_option['option_title'] ); ?></h3>
									<p class="option-desc"><?php echo esc_html( $theme_option['option_desc'] ); ?></p>
									<div class="option-link-area">
										<a class="option-link" href="<?php echo esc_url( $theme_option['link_url'] ); ?>" target="_blank"><?php echo $theme_option['link_title']; ?></a>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="reign-option-info-wrapper reign-option-downloads-wrapper">
					<div class="reign-option-info">
						<h2><?php esc_html_e( 'Downloads', 'reign' ); ?></h2>
						<p><?php esc_html_e( 'Install Recommended Plugins feature simplifies the addition of essential add-ons for enhancing your website\'s functionality and features.', 'reign' ); ?></p>
					</div>
					<div class="reign-option-boxes">
						<div class="reign-option-box">
							<div class="option-wrapper">
								<div class="option-icon"><svg width="20" height="20" viewBox="0 0 20 20" fill="#1d76da"><path d="M3.1,0c-0.4,0-0.8,0.2-1,0.6L0.2,3.9C0.1,4.1,0,4.2,0,4.4v13.3C0,19,1,20,2.2,20h15.6c1.2,0,2.2-1,2.2-2.2V4.4c0-0.2-0.1-0.4-0.2-0.6l-1.9-3.3c-0.2-0.3-0.6-0.6-1-0.6H3.1z M3.7,2.2h12.6l1.3,2.2H2.4L3.7,2.2z M2.2,6.7h15.6v11.1H2.2V6.7zM8.9,8.3v3.3H5.6l4.4,4.4l4.4-4.4h-3.3V8.3H8.9z"></path></svg></div>
								<h3 class="option-title"><?php esc_html_e( 'Install Recommended Plugins', 'reign' ); ?></h3>
								<p class="option-desc"><?php esc_html_e( 'Enhancing your website\'s functionality with WordPress plugins is easy. You can install, activate, and begin using WordPress plugins in a matter of minutes', 'reign' ); ?></p>
								<div class="option-link-area">
									<?php
									if ( class_exists( 'BuddyPress' ) ) {
										if ( class_exists( 'Buddypress_Share' ) && class_exists( 'Buddypress_Reactions' ) && function_exists( 'wbcom_essential' ) ) {
											?>
											<a class="option-link all-plugin-installed" href="javascript:void(0)"><?php esc_html_e( 'Installed', 'reign' ); ?></a>
										<?php } else { ?>
											<a class="option-link" href="<?php echo esc_url( admin_url() . 'admin.php?page=install-required-plugins' ); ?>" target="_blank"><?php esc_html_e( 'Install now', 'reign' ); ?></a>
											<?php
										}
									} elseif ( function_exists( 'wbcom_essential' ) ) {
										?>
										<a class="option-link all-plugin-installed" href="javascript:void(0)"><?php esc_html_e( 'Installed', 'reign' ); ?></a>
									<?php } else { ?>
										<a class="option-link" href="<?php echo esc_url( admin_url() . 'admin.php?page=install-required-plugins' ); ?>" target="_blank"><?php esc_html_e( 'Install now', 'reign' ); ?></a>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<div class="reign-option-box">
							<div class="option-wrapper">
								<div class="option-icon"><svg width="20" height="20" viewBox="0 0 20 20" fill="#1d76da"><path d="M3.1,0c-0.4,0-0.8,0.2-1,0.6L0.2,3.9C0.1,4.1,0,4.2,0,4.4v13.3C0,19,1,20,2.2,20h15.6c1.2,0,2.2-1,2.2-2.2V4.4c0-0.2-0.1-0.4-0.2-0.6l-1.9-3.3c-0.2-0.3-0.6-0.6-1-0.6H3.1z M3.7,2.2h12.6l1.3,2.2H2.4L3.7,2.2z M2.2,6.7h15.6v11.1H2.2V6.7zM8.9,8.3v3.3H5.6l4.4,4.4l4.4-4.4h-3.3V8.3H8.9z"></path></svg></div>
								<h3 class="option-title"><?php esc_html_e( 'Reign Child Theme', 'reign' ); ?></h3>
								<p class="option-desc"><?php esc_html_e( 'By using a child theme you can modify any file without the fear of breaking something in the parent theme.', 'reign' ); ?></p>
								<div class="option-link-area">
									<a class="option-link" href="<?php echo esc_url( 'https://github.com/wbcomdesigns/reign-child-theme/releases/download/4.0.0/reign-child-theme.zip' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Download now', 'reign' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
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
				<div class="reign-option-info-wrapper reign-option-tutorials-wrapper">
					<div class="reign-option-boxes">
						<div class="reign-option-box reign-theme-videos">
							<div class="reign-theme-video">
								<iframe width="100%" height="380" src="https://www.youtube.com/embed/Gep2E7YhW8g" title="Reign BuddyPress Theme - Demo Setup 2023 - Create Social Community Website in 10 Minutes" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
							</div>
							<div class="option-wrapper">
								<h3 class="option-title"><?php esc_html_e( 'Reign Theme Video Tutorials', 'reign' ); ?></h3>
								<p class="option-desc"><?php esc_html_e( 'A theme video series is a collection of short videos that visually and concisely guide users through various aspects of a specific theme or template, often used for websites or applications. These videos offer step-by-step instructions on installation, customization, and troubleshooting, enhancing users\' understanding and facilitating a smoother experience with the theme. This multimedia approach to documentation provides a dynamic and engaging way for users to master the theme\'s features and create stunning online platforms.', 'reign' ); ?></p>
								<div class="option-link-area">
									<a class="option-link" href="<?php echo esc_url( 'https://www.youtube.com/watch?v=Gep2E7YhW8g&list=PLlkJGdi68l-9eWBbEwNFUQciw15x4bR5n&ab_channel=WbcomDesigns' ); ?>" target="_blank"><?php esc_html_e( 'Watch now', 'reign' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
		}
	}

	endif;

/**
 * Main instance of Reign_Get_Started_Options.
 *
 * @return Reign_Get_Started_Options
 */
Reign_Get_Started_Options::instance();
