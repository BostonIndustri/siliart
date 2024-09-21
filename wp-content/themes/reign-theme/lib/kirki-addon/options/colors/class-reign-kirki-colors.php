<?php
/**
 * Reign Kirki Colors
 *
 * @package reign
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Reign_Kirki_Colors' ) ) :

	/**
	 * @class Reign_Kirki_Colors
	 */
	class Reign_Kirki_Colors {

		/**
		 * The single instance of the class.
		 *
		 * @var Reign_Kirki_Colors
		 */
		protected static $_instance = null;

		/**
		 * Main Reign_Kirki_Colors Instance.
		 *
		 * Ensures only one instance of Reign_Kirki_Colors is loaded or can be loaded.
		 *
		 * @return Reign_Kirki_Colors - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Reign_Kirki_Colors Constructor.
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {

			/* remove default background color from theme. */
			add_action( 'customize_register', array( $this, 'reign_remove_wp_background_color' ) );

			add_action( 'init', array( $this, 'reign_add_fields' ) );

			add_action( 'init', array( $this, 'reign_map_color_scheme_values' ) );
		}

		/**
		 * Reign remove wp background color
		 */
		public function reign_remove_wp_background_color( $wp_customize ) {
			$wp_customize->remove_control( 'background_color' );
		}

		/**
		 * Add fields
		 */
		public function reign_add_fields() {

			$default_value_set = reign_color_scheme_set();

			$selector_for_background = '';
			$selector_for_background = apply_filters( 'reign_selector_set_to_apply_theme_color_to_background', $selector_for_background );

			$selector_for_boder = '';
			$selector_for_boder = apply_filters( 'reign_selector_set_to_apply_theme_color_to_border', $selector_for_boder );

			$selector_for_section_bg = '';
			$selector_for_section_bg = apply_filters( 'reign_selector_set_to_apply_section_bg_color', $selector_for_section_bg );

			$selector_for_secondary_bg = '';
			$selector_for_secondary_bg = apply_filters( 'reign_selector_set_to_apply_section_bg_color', $selector_for_secondary_bg );

			$selector_for_border_color = '';
			$selector_for_border_color = apply_filters( 'reign_selector_set_to_apply_border_color', $selector_for_border_color );

			new \Kirki\Field\Radio_Buttonset(
				array(
					'settings' => 'reign_color_scheme',
					'label'    => __( 'Color Scheme', 'reign' ),
					'section'  => 'colors',
					'default'  => 'reign_clean',
					'priority' => 10,
					'choices'  => array(
						'reign_default'   => esc_html__( 'Default', 'reign' ),
						'reign_clean'     => esc_html__( 'Clean', 'reign' ),
						'reign_dark'      => esc_html__( 'Dark', 'reign' ),
						'reign_dating'    => esc_html__( 'Dating', 'reign' ),
						'reign_ectoplasm' => esc_html__( 'Ectoplasm', 'reign' ),
						'reign_sunrise'   => esc_html__( 'Sunrise', 'reign' ),
						'reign_coffee'    => esc_html__( 'Coffee', 'reign' ),
					),
				)
			);

			new \Kirki\Pro\Field\Divider(
				array(
					'settings' => 'reign_color_scheme_divider',
					'section'  => 'colors',
					'choices'  => array(
						'color' => '#dcdcde',
					),
				)
			);

			foreach ( $default_value_set as $color_scheme_key => $default_set ) {

				// Top Bar Color Scheme.
				$fields_on_hold   = array();
				$fields_on_hold[] = array(
					new \Kirki\Field\Color(
						array(
							'settings'        => $color_scheme_key . '-' . 'reign_header_topbar_bg_color',
							'label'           => esc_html__( 'Top Bar Background Color', 'reign' ),
							'description'     => esc_html__( 'The background color of topbar.', 'reign' ),
							'section'         => 'colors',
							'default'         => $default_value_set[ $color_scheme_key ]['reign_header_topbar_bg_color'],
							'priority'        => 10,
							'choices'         => array( 'alpha' => true ),
							'active_callback' => array(
								array(
									'setting'  => 'reign_color_scheme',
									'operator' => '===',
									'value'    => $color_scheme_key,
								),
							),
						)
					),
				);

				$fields_on_hold[] = array(
					new \Kirki\Field\Color(
						array(
							'settings'        => $color_scheme_key . '-' . 'reign_header_topbar_text_color',
							'label'           => esc_html__( 'Top Bar Text Color', 'reign' ),
							'description'     => esc_html__( 'The color of topbar text.', 'reign' ),
							'section'         => 'colors',
							'default'         => $default_value_set[ $color_scheme_key ]['reign_header_topbar_text_color'],
							'priority'        => 10,
							'choices'         => array( 'alpha' => true ),
							'active_callback' => array(
								array(
									'setting'  => 'reign_color_scheme',
									'operator' => '===',
									'value'    => $color_scheme_key,
								),
							),
						)
					),
				);

				$fields_on_hold[] = array(
					new \Kirki\Field\Color(
						array(
							'settings'        => $color_scheme_key . '-' . 'reign_header_topbar_text_hover_color',
							'label'           => esc_html__( 'Top Bar Text Color [Hover]', 'reign' ),
							'description'     => esc_html__( 'The color of topbar text hover.', 'reign' ),
							'section'         => 'colors',
							'default'         => $default_value_set[ $color_scheme_key ]['reign_header_topbar_text_hover_color'],
							'priority'        => 10,
							'choices'         => array( 'alpha' => true ),
							'active_callback' => array(
								array(
									'setting'  => 'reign_color_scheme',
									'operator' => '===',
									'value'    => $color_scheme_key,
								),
							),
						)
					),
				);

				$fields_on_hold = apply_filters( 'reign_header_topbar_fields_on_hold', $fields_on_hold );

				foreach ( $fields_on_hold as $key => $value ) {
					$fields[] = $value;
				}

				// Header Color Scheme: Header BG.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_bg_color',
						'label'           => esc_html__( 'Header Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of header.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Header Color Scheme: Header BG.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_nav_bg_color',
						'label'           => esc_html__( 'Header Layout 4 Navigation Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color only for header layout 4 navigation.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_nav_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
							array(
								'setting'  => 'reign_header_layout',
								'operator' => '==',
								'value'    => 'v4',
							),
						),
					)
				);

				// Header Color Scheme: Header Site Title.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_title_tagline_typography',
						'label'           => esc_html__( 'Site Title Font Color', 'reign' ),
						'description'     => esc_html__( 'The color of site title.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_title_tagline_typography'],
						'priority'        => 10,
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Header Color Scheme: Header Main Menu.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_main_menu_font',
						'label'           => esc_html__( 'Main Menu Item Font Color', 'reign' ),
						'description'     => esc_html__( 'The color of header main menu item.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_main_menu_font'],
						'priority'        => 10,
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_main_menu_text_hover_color',
						'label'           => esc_html__( 'Main Menu Item Font Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of header main menu item hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_main_menu_text_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_main_menu_text_active_color',
						'label'           => esc_html__( 'Main Menu Item Font Color [Active]', 'reign' ),
						'description'     => esc_html__( 'The color of header main menu item active.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_main_menu_text_active_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_main_menu_bg_hover_color',
						'label'           => esc_html__( 'Main Menu Item Border OR Background Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The border or background color of header main menu hover style.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_main_menu_bg_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_main_menu_bg_active_color',
						'label'           => esc_html__( 'Main Menu Item Border OR Background Color [Active]', 'reign' ),
						'description'     => esc_html__( 'The border or background color of header main menu active style.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_main_menu_bg_active_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Header Color Scheme: Header Sub Menu.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_sub_menu_bg_color',
						'label'           => esc_html__( 'Sub Menu Item Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of header sub menu.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_sub_menu_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_sub_menu_font',
						'label'           => esc_html__( 'Sub Menu Item Font Color', 'reign' ),
						'description'     => esc_html__( 'The color of header sub menu item.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_sub_menu_font'],
						'priority'        => 10,
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_sub_menu_text_hover_color',
						'label'           => esc_html__( 'Sub Menu Item Font Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of header sub menu item hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_sub_menu_text_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_sub_menu_bg_hover_color',
						'label'           => esc_html__( 'Sub Menu Item Background Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The background color of header sub menu item hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_sub_menu_bg_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Header Color Scheme: Header Icon.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_icon_color',
						'label'           => esc_html__( 'Header Icon Color', 'reign' ),
						'description'     => esc_html__( 'The color of header icon.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_icon_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_header_icon_hover_color',
						'label'           => esc_html__( 'Header Icon Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of header icon hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_header_icon_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Mobile Colors.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_mobile_menu_bg_color',
						'label'           => esc_html__( 'Mobile Panel Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of mobile panel.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_mobile_menu_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_mobile_menu_color',
						'label'           => esc_html__( 'Mobile Menu Color', 'reign' ),
						'description'     => esc_html__( 'The color of mobile menu.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_mobile_menu_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_mobile_menu_hover_color',
						'label'           => esc_html__( 'Mobile Menu Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The hover color of mobile menu.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_mobile_menu_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_mobile_menu_active_color',
						'label'           => esc_html__( 'Mobile Menu Color [Active]', 'reign' ),
						'description'     => esc_html__( 'The active color of mobile menu.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_mobile_menu_active_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_mobile_menu_active_bg_color',
						'label'           => esc_html__( 'Mobile Menu Background Color [Active]', 'reign' ),
						'description'     => esc_html__( 'The active background color of mobile menu.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_mobile_menu_active_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Left Panel Color Scheme: Header BG.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_bg_color',
						'label'           => esc_html__( 'Left Panel Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of left panel.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Left Panel Color Scheme: Toggle Color.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_toggle_color',
						'label'           => esc_html__( 'Left Panel Toggle Color', 'reign' ),
						'description'     => esc_html__( 'The color of left panel toggle.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_toggle_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Left Panel Color Scheme: Panel Menu.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_menu_font_color',
						'label'           => esc_html__( 'Left Panel Menu Color', 'reign' ),
						'description'     => esc_html__( 'The color of left panel menu item.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_menu_font_color'],
						'priority'        => 10,
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_menu_bg_active_color',
						'label'           => esc_html__( 'Left Panel Background Color [Active]', 'reign' ),
						'description'     => esc_html__( 'The background color of left panel menu item active.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_menu_bg_active_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_menu_icon_active_color',
						'label'           => esc_html__( 'Left Panel Menu Color [Active]', 'reign' ),
						'description'     => esc_html__( 'The color of left panel menu active.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_menu_icon_active_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_menu_bg_hover_color',
						'label'           => esc_attr__( 'Left Panel Background Color [Hover]', 'reign' ),
						'description'     => esc_attr__( 'The background color of left panel menu item hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_menu_bg_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_menu_hover_color',
						'label'           => esc_attr__( 'Left Panel Font Color [Hover]', 'reign' ),
						'description'     => esc_attr__( 'The color of left panel menu item hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_menu_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_tooltip_bg_color',
						'label'           => esc_html__( 'Left Panel Tooltip Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of left panel tooltip.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_tooltip_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_left_panel_tooltip_color',
						'label'           => esc_html__( 'Left Panel Tooltip Color', 'reign' ),
						'description'     => esc_html__( 'The color of left panel tooltip.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_left_panel_tooltip_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_body_bg_color',
						'label'           => esc_html__( 'Body Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of site body.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_body_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_body_text_color',
						'label'           => esc_html__( 'Body Text Color', 'reign' ),
						'description'     => esc_html__( 'The color of body text.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_body_text_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_alternate_text_color',
						'label'           => esc_html__( 'Alternate Text Color', 'reign' ),
						'description'     => esc_html__( 'The color of meta data and supplementary text.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_alternate_text_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_sections_bg_color',
						'label'           => esc_html__( 'Sections Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of sections.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_sections_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'output'          => array(
							array(
								'element'  => '' . $selector_for_section_bg,
								'property' => 'background-color',
							),
						),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_secondary_bg_color',
						'label'           => esc_html__( 'Secondary Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of secondary elements.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_secondary_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'output'          => array(
							array(
								'element'  => '' . $selector_for_secondary_bg,
								'property' => 'background-color',
							),
						),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_colors_theme',
						'label'           => esc_html__( 'Theme Color', 'reign' ),
						'description'     => esc_html__( 'The color of primary color, active color.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_colors_theme'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_headings_color',
						'label'           => esc_html__( 'Headings Color', 'reign' ),
						'description'     => esc_html__( 'The color of headings.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_headings_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_link_color',
						'label'           => esc_html__( 'Link Color', 'reign' ),
						'description'     => esc_html__( 'The color of link.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_link_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_link_hover_color',
						'label'           => esc_html__( 'Link Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of link hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_link_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_accent_color',
						'label'           => esc_html__( 'Content Link Color', 'reign' ),
						'description'     => esc_html__( 'The color of content area link.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_accent_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_accent_hover_color',
						'label'           => esc_html__( 'Content Link Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of content area link hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_accent_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_button_text_color',
						'label'           => esc_html__( 'Button Text Color', 'reign' ),
						'description'     => esc_html__( 'The color of button text.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_button_text_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_button_text_hover_color',
						'label'           => esc_html__( 'Button Text Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of button text hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_button_text_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_button_bg_color',
						'label'           => esc_html__( 'Button Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of button.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_button_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_button_bg_hover_color',
						'label'           => esc_html__( 'Button Background Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The background color of button hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_button_bg_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_border_color',
						'label'           => esc_html__( 'Border Color', 'reign' ),
						'description'     => esc_html__( 'The border color of site.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_border_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'output'          => array(
							array(
								'element'  => '' . $selector_for_border_color,
								'property' => 'border-color',
							),
						),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_site_hr_color',
						'label'           => esc_html__( 'HR Color', 'reign' ),
						'description'     => esc_html__( 'The hr color of site.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_site_hr_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Footer Color Scheme.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_widget_area_bg_color',
						'label'           => esc_html__( 'Footer Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of footer.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_widget_area_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_widget_title_color',
						'label'           => esc_html__( 'Footer Widget Title Color', 'reign' ),
						'description'     => esc_html__( 'The color of footer widget title.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_widget_title_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_widget_text_color',
						'label'           => esc_html__( 'Footer Text Color', 'reign' ),
						'description'     => esc_html__( 'The color of footer text.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_widget_text_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_widget_link_color',
						'label'           => esc_html__( 'Footer Link Color', 'reign' ),
						'description'     => esc_html__( 'The color of footer link.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_widget_link_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_widget_link_hover_color',
						'label'           => esc_html__( 'Footer Link Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The background color of footer link hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_widget_link_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				// Footer Color Scheme: Copyright.
				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_copyright_bg_color',
						'label'           => esc_html__( 'Copyright Background Color', 'reign' ),
						'description'     => esc_html__( 'The background color of copyright.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_copyright_bg_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_copyright_text_color',
						'label'           => esc_html__( 'Copyright Text Color', 'reign' ),
						'description'     => esc_html__( 'The color of copyright text.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_copyright_text_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_copyright_link_color',
						'label'           => esc_html__( 'Copyright Link Color', 'reign' ),
						'description'     => esc_html__( 'The color of copyright link.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_copyright_link_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);

				new \Kirki\Field\Color(
					array(
						'settings'        => $color_scheme_key . '-' . 'reign_footer_copyright_link_hover_color',
						'label'           => esc_html__( 'Copyright Link Color [Hover]', 'reign' ),
						'description'     => esc_html__( 'The color of copyright link hover.', 'reign' ),
						'section'         => 'colors',
						'default'         => $default_value_set[ $color_scheme_key ]['reign_footer_copyright_link_hover_color'],
						'priority'        => 10,
						'choices'         => array( 'alpha' => true ),
						'active_callback' => array(
							array(
								'setting'  => 'reign_color_scheme',
								'operator' => '===',
								'value'    => $color_scheme_key,
							),
						),
					)
				);
			}
		}

		/**
		 * Reign map color scheme values
		 */
		public function reign_map_color_scheme_values() {

			$color_scheme_key = 'reign_default';

			/* Background Color */
			$background_color     = get_theme_mod( 'background_color' );
			$new_background_color = get_theme_mod( $color_scheme_key . '-' . 'reign_site_body_bg_color', false );
			if ( ! $new_background_color && $background_color ) {
				set_theme_mod( $color_scheme_key . '-' . 'reign_site_body_bg_color', $background_color );
			}

			/* Theme Color */
			$theme_color     = get_theme_mod( 'reign_colors_theme' );
			$new_theme_color = get_theme_mod( $color_scheme_key . '-' . 'reign_colors_theme', false );
			if ( ! $new_theme_color && $theme_color ) {
				set_theme_mod( $color_scheme_key . '-' . 'reign_colors_theme', $theme_color );
			}

			/* Link Hover Color */
			$link_hover_color     = get_theme_mod( 'reign_site_link_hover_color' );
			$new_link_hover_color = get_theme_mod( $color_scheme_key . '-' . 'reign_site_link_hover_color', false );
			if ( ! $new_link_hover_color && $link_hover_color ) {
				set_theme_mod( $color_scheme_key . '-' . 'reign_site_link_hover_color', $link_hover_color );
			}

			/* Button Background Color */
			$button_bg_color     = get_theme_mod( 'reign_site_button_bg_color' );
			$new_button_bg_color = get_theme_mod( $color_scheme_key . '-' . 'reign_site_button_bg_color', false );
			if ( ! $new_button_bg_color && $button_bg_color ) {
				set_theme_mod( $color_scheme_key . '-' . 'reign_site_button_bg_color', $button_bg_color );
			}

			/* Accent Color */
			$accent_color     = get_theme_mod( 'reign_accent_color' );
			$new_accent_color = get_theme_mod( $color_scheme_key . '-' . 'reign_accent_color', false );
			if ( ! $new_accent_color && $accent_color ) {
				set_theme_mod( $color_scheme_key . '-' . 'reign_accent_color', $accent_color );
			}

			/* Accent Hover Color */
			$accent_hover_color     = get_theme_mod( 'reign_accent_hover_color' );
			$new_accent_hover_color = get_theme_mod( $color_scheme_key . '-' . 'reign_accent_hover_color', false );
			if ( ! $new_accent_hover_color && $accent_hover_color ) {
				set_theme_mod( $color_scheme_key . '-' . 'reign_accent_hover_color', $accent_hover_color );
			}
		}
	}

	endif;

/**
 * Main instance of Reign_Kirki_Colors.
 *
 * @return Reign_Kirki_Colors
 */
Reign_Kirki_Colors::instance();
