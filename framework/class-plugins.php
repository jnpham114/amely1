<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin installation and activation for WordPress themes
 *
 * @package Amely
 */
if ( ! class_exists( 'Amely_Register_Plugins' ) ) {

	class Amely_Register_Plugins {

		/**
		 * Insight_Register_Plugins constructor.
		 */
		public function __construct() {
			add_filter( 'insight_core_tgm_plugins', array( $this, 'plugin_list' ) );
			add_action( 'tgmpa_register', array( $this, 'register_plugins' ), 11, 1 );
		}

		/**
		 * Register required plugins
		 *
		 * @return array
		 */
		public function plugin_list() {
			$plugins = array(
				array(
					'name'     => esc_html__( 'Insight Core', 'amely' ),
					'slug'     => 'insight-core',
					'source'   => get_template_directory() . '/plugins/insight-core-1.6.7.6-no-kirki.zip',
					'version'  => '1.6.7.6',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'WPBakery Page Builder', 'amely' ),
					'slug'     => 'js_composer',
					'source'   => 'https://www.googleapis.com/drive/v3/files/1A8-G_73QK3UBVUKdU86JitP8OUJKcQTt?alt=media&key=AIzaSyBQsxIg32Eg17Ic0tmRvv1tBZYrT9exCwk',
					'version'  => '6.9.0',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'WPBakery Page Builder (Visual Composer) Clipboard', 'amely' ),
					'slug'     => 'vc_clipboard',
					'source'   => 'https://www.googleapis.com/drive/v3/files/1fvaqD_UY7pe3Zwz_cUMGmsyIA6Xx_l9d?alt=media&key=AIzaSyBQsxIg32Eg17Ic0tmRvv1tBZYrT9exCwk',
					'version'  => '5.0.3',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'Revolution Slider', 'amely' ),
					'slug'     => 'revslider',
					'source'   => 'https://www.googleapis.com/drive/v3/files/1AM1FS_OecPXtKm1p8oK-3cEhMxOYxXdr?alt=media&key=AIzaSyBQsxIg32Eg17Ic0tmRvv1tBZYrT9exCwk',
					'version'  => '6.5.20',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Vafpress Post Formats UI', 'amely' ),
					'slug'     => 'vafpress-post-formats-ui',
					'source'   => get_template_directory() . '/plugins/vafpress-post-formats-ui-150.zip',
					'required' => false,
					'version'  => '1.5',
				),
				array(
					'name'     => esc_html__( 'WooCommerce Brands Pro', 'amely' ),
					'slug'     => 'woocommerce-brands',
					'source'   => 'https://api.thememove.com/download/woo-brand-4.5.0-F8W9od8Ga.zip',
					'version'  => '4.5.0',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'Redux Framework', 'amely' ),
					'slug'     => 'redux-framework',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'WooCommerce', 'amely' ),
					'slug'     => 'woocommerce',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'WooCommerce Bought Together', 'amely' ),
					'slug'     => 'woo-bought-together',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'WooCommerce Smart Compare', 'amely' ),
					'slug'     => 'woo-smart-compare',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'YITH WooCommerce Wishlist', 'amely' ),
					'slug'     => 'yith-woocommerce-wishlist',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'Contact Form 7', 'amely' ),
					'slug'     => 'contact-form-7',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'WordPress Countdown Widget', 'amely' ),
					'slug'     => 'wordpress-countdown-widget',
					'required' => false,
				),
				array(
					'name'     => esc_html__( 'Safe SVG', 'amely' ),
					'slug'     => 'safe-svg',
					'required' => false,
				),
				array(
					'name'    => esc_html__( 'Instagram Feed', 'amely' ),
					'slug'    => 'elfsight-instagram-feed-cc',
					'source'  => 'https://api.thememove.com/download/elfsight-instagram-feed-cc-4.0.2-dYYYZeP8Zo.zip',
					'version' => '4.0.2',
				),
			);

			if ( ! function_exists( 'run_MABEL_SI' ) ) {
				$plugins[] = array(
					'name'     => esc_html__( 'Shoppable Images Lite', 'amely' ),
					'slug'     => 'mabel-shoppable-images-lite',
					'required' => false,
				);
			}

			return $plugins;
		}

		function register_plugins() {
			$plugins = array();
			$plugins = apply_filters( 'insight_core_tgm_plugins', $plugins );
			$config  = array(
				'id'           => 'tgmpa',
				// Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',
				// Default absolute path to pre-packaged plugins.
				'menu'         => 'tgmpa-install-plugins',
				// Menu slug.
				'parent_slug'  => 'themes.php',
				// Parent menu slug.
				'capability'   => 'edit_theme_options',
				// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,
				// Show admin notices or not.
				'dismissable'  => true,
				// If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',
				// If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,
				// Automatically activate plugins after installation or not.
				'message'      => '',
				// Message to output right before the plugins table.
				'strings'      => array(
					'page_title'                      => esc_html__( 'Install Required Plugins', 'amely' ),
					'menu_title'                      => esc_html__( 'Install Plugins', 'amely' ),
					'installing'                      => esc_html__( 'Installing Plugin: %s', 'amely' ),
					// %s = plugin name.
					'oops'                            => esc_html__( 'Something went wrong with the plugin API.',
						'amely' ),
					'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.',
						'This theme requires the following plugins: %1$s.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.',
						'This theme recommends the following plugins: %1$s.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
						'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
						'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_ask_to_update_maybe'      => _n_noop( 'There is an update available for: %1$s.',
						'There are updates available for the following plugins: %1$s.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
						'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.',
						'The following required plugins are currently inactive: %1$s.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.',
						'The following recommended plugins are currently inactive: %1$s.',
						'amely' ),
					// %1$s = plugin name(s).
					'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
						'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
						'amely' ),
					// %1$s = plugin name(s).
					'install_link'                    => _n_noop( 'Begin installing plugin',
						'Begin installing plugins',
						'amely' ),
					'update_link'                     => _n_noop( 'Begin updating plugin',
						'Begin updating plugins',
						'amely' ),
					'activate_link'                   => _n_noop( 'Begin activating plugin',
						'Begin activating plugins',
						'amely' ),
					'return'                          => esc_html__( 'Return to Required Plugins Installer', 'amely' ),
					'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'amely' ),
					'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:',
						'amely' ),
					'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.',
						'amely' ),
					// %1$s = plugin name(s).
					'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.',
						'amely' ),
					// %1$s = plugin name(s).
					'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s',
						'amely' ),
					// %s = dashboard link.
					'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.',
						'amely' ),
					'nag_type'                        => 'updated',
					// Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
				),
			);

			tgmpa( $plugins, $config );

		}
	}

	new Amely_Register_Plugins();
}
