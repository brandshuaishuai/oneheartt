<?php
/*
Plugin Name: Hustle
Plugin URI: https://wordpress.org/plugins/wordpress-popup/
Description: Start collecting email addresses and quickly grow your mailing list with big bold pop-ups, slide-ins, widgets, or in post opt-in forms.
Version: 7.0.0.1
Author: WPMU DEV
Author URI: https://premium.wpmudev.org

 */

// +----------------------------------------------------------------------+
// | Copyright Incsub (http://incsub.com/)                                |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License, version 2, as  |
// | published by the Free Software Foundation.                           |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,               |
// | MA 02110-1301 USA                                                    |
// +----------------------------------------------------------------------+

// Display admin notice about plugin deactivation
add_action( 'network_admin_notices', 'hustle_activated_deactivated' );
add_action( 'admin_notices', 'hustle_activated_deactivated' );
if ( ! function_exists( 'hustle_activated_deactivated' ) ) {
	function hustle_activated_deactivated() {
		// for Pro
		if ( get_site_option( 'hustle_free_deactivated' ) && is_super_admin() ) { ?>
            <div class="notice notice-success is-dismissible">
                <p><?php esc_html_e( 'Congratulations! You have activated Hustle Pro! We have automatically deactivated the free version.', 'hustle' ); ?></p>
            </div>
<?php
			delete_site_option( 'hustle_free_deactivated' );
		}
		// for Free
		if ( get_site_option( 'hustle_free_activated' ) && is_super_admin() ) {
?>
            <div class="notice notice-error is-dismissible">
                <p><?php esc_html_e( 'You already have Hustle Pro activated. If you really wish to go back to the free version of Hustle, please deactivate the Pro version first.', 'hustle' ); ?></p>
            </div>
<?php
			delete_site_option( 'hustle_free_activated' );
		}
	}
}

// Deactivate the .org version, if pro version is active
add_action( 'activated_plugin', 'hustle_activated', 10, 2 );
if ( ! function_exists( 'hustle_activated' ) ) {
	function hustle_activated( $plugin, $network_activation ) {

		if ( is_plugin_active( 'hustle/opt-in.php' ) && is_plugin_active( 'wordpress-popup/popover.php' ) ) {

			// deactivate free version
			deactivate_plugins( 'wordpress-popup/popover.php' );

			if ( 'hustle/opt-in.php' === $plugin ) {
				//Store in database about free version deactivated, in order to show a notice on page load
				update_site_option( 'hustle_free_deactivated', 1 );
			} else if ( 'wordpress-popup/popover.php' === $plugin ) {
				//Store in database about free version being activated even pro is already active
				update_site_option( 'hustle_free_activated', 1 );
			}
		}
	}
}

if ( version_compare( PHP_VERSION, '5.3.2', '>=' ) ) {
	if ( ! class_exists( 'ComposerAutoloaderInitda98371940d11703c56dee923bbb392f' ) ) {
		require_once 'vendor/autoload.php';
	}
} else {
	if ( ! class_exists( 'ComposerAutoloaderInitdc2feb09422541020a75a34eeac8ae2a' ) ) {
		require_once 'vendor/autoload_52.php';
	}
}

require_once 'lib/wpmu-lib/core.php';
require_once 'opt-in-static.php';
//require_once 'assets/shared-ui/plugin-ui.php';

if ( ! defined( 'HUSTLE_SUI_VERSION' ) ) {
	define( 'HUSTLE_SUI_VERSION', '2.3.21' );
}

if ( ! class_exists( 'Opt_In' ) ) :

	class Opt_In extends Opt_In_Static{

		const VERSION = '4.0.0.1';

		const TEXT_DOMAIN = 'hustle';

		const VIEWS_FOLDER = 'views';
		const EXPORT_MODULE_ACTION = 'module_export';


		private $hustle_provider_loader;


		public static $plugin_base_file;
		public static $plugin_url;
		public static $plugin_path;
		public static $vendor_path;
		public static $template_path;

		protected static $_registered_providers = array();

		/**
		 * Opt_In constructor.
		 *
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			self::$plugin_base_file = plugin_basename( __FILE__ );
			self::$plugin_url = plugin_dir_url( self::$plugin_base_file );
			self::$plugin_path = trailingslashit( dirname( __FILE__ ) );
			self::$vendor_path = self::$plugin_path . 'vendor/';
			self::$template_path = trailingslashit( dirname( __FILE__ ) ) . 'views/';

			// Register autoloader
			spl_autoload_register( array( $this, 'autoload' ) );

			// Register text domain
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

			// Add custom capabilities
			add_action( 'init', array( $this, 'add_custom_capabilities' ) );

			/**
			 * Boot up and instantiate core classes
			 */
			$this->_boot();
		}


		/**
		 * Add custom capabilities to administrator
		 *
		 * @since 4.0
		 */
		public function add_custom_capabilities() {
			$hustle_capabilities = array(
				'hustle_menu',
				'hustle_edit_module',
				'hustle_create',
				'hustle_edit_integrations',
				'hustle_access_emails',
				'hustle_edit_settings',
			);

			$admin = get_role( 'administrator' );
			foreach ( $hustle_capabilities as $cap ) {
				$admin->add_cap( $cap );
			}
		}


		/**
		 * Returns static variable from class instance
		 *
		 * @since 2.0
		 *
		 * @param $var_name
		 * @return mixed
		 */
		public function get_static_var( $var_name ) {
			static $static = array();
			if ( ! isset( $static[  $var_name ] ) ) {
				$class = new ReflectionClass( $this );
				$static[  $var_name ]  = $class->getStaticPropertyValue( $var_name );
			}
			return $static[  $var_name ];
		}

		/**
		 * Returns constant variable from class instance
		 *
		 * @since 2.0
		 * @param $var_name
		 * @param $class_instance
		 * @return mixed
		 */
		public function get_const_var( $var_name, $class_instance = null ) {
			static $const = array();

			if ( ! isset( $const[ $var_name ] ) ) {
				$r = new ReflectionObject( is_null( $class_instance ) ? $this : $class_instance );
				$const[ $var_name  ] = $r->getConstant( $var_name );
			}

			return $const[ $var_name ];
		}

		/**
		 * Returns list of optin providers based on their declared classes that implement Opt_In_Provider_Interface
		 *
		 * @return array
		 */
		public function get_providers() {
			if ( empty( self::$_registered_providers ) ) {
				self::$_registered_providers = Hustle_Provider_Utils::get_activable_providers_list();
			}
			return self::$_registered_providers;
		}

		/**
		 * Loads text domain
		 *
		 * @since 1.0.0
		 */
		public function load_text_domain() {
			load_plugin_textdomain( self::TEXT_DOMAIN, false, dirname( plugin_basename( self::$plugin_base_file ) ) . '/languages/' );
		}

		/**
		 * Autoloads undefined classes
		 *
		 * @since 1.0.0
		 *
		 * @param $class
		 * @return bool
		 */
		public function autoload( $class ) {

			$dirs = array( 'inc', 'inc/provider', 'inc/display-conditions', 'inc/popup', 'inc/slidein', 'inc/embed', 'inc/sshare' );

			foreach ( $dirs as $dir ) {
				$filename = self::$plugin_path  . $dir . DIRECTORY_SEPARATOR . str_replace( '_', '-', strtolower( $class ) ) . '.php';
				if ( is_readable( $filename ) ) {
					require_once $filename;
					return true;
				}
			}

			return false;
		}

		/**
		 * Boots up the plugin and instantiates core classes
		 *
		 * @since 1.0.0
		 */
		private function _boot() {
			// Registers the existing activable providers
			$this->_init_providers();
		}

		private function _init_providers() {

			/**
			 * Triggered before registering internal providers
			 *
			 * @since xxx
			 */
			do_action( 'hustle_before_load_providers' );

			$this->hustle_provider_loader = Hustle_Providers::get_instance();
			// Load packaged providers
			$autoloader = new Hustle_Provider_Autoload();
			$autoloader->load();

			/*
             * Triggered after hustle packaged providers were loaded
             *
             * @since xxx
             */
			do_action( 'hustle_providers_loaded' );
		}

		/**
		 * Show Exit-intent description
		 *
		 * @since 3.0.8
		 * @todo move it somewhere else. No need to have this in this file. It's used in wizard's trigger sections.
		 */
		public function get_exitintent_description() {
			printf( esc_html__( '%1$sNote:%2$s Exit-intent will show only by detecting mouse movement and not with finger scroll.', self::TEXT_DOMAIN ), '<b>', '</b>' );
		}

		/**
		 * Get smallcaps singular
		 *
		 * @param string $module_type
		 * @return string
		 */
		public static function get_smallcaps_singular( $module_type ) {
			$smallcaps_singular = '';

			if ( Hustle_Module_Model::POPUP_MODULE === $module_type ) {
				$smallcaps_singular = esc_html__( 'pop-up', self::TEXT_DOMAIN );
			} elseif ( Hustle_Module_Model::SLIDEIN_MODULE === $module_type ) {
				$smallcaps_singular = esc_html__( 'slide-in', self::TEXT_DOMAIN );
			} elseif ( Hustle_Module_Model::EMBEDDED_MODULE === $module_type ) {
				$smallcaps_singular = esc_html__( 'embed', self::TEXT_DOMAIN );
			} elseif ( Hustle_Module_Model::SOCIAL_SHARING_MODULE === $module_type ) {
				$smallcaps_singular = esc_html__( 'social sharing', self::TEXT_DOMAIN );
			}

			return $smallcaps_singular;
		}


		/**
		 * Renders a view file
		 *
		 * @param $file
		 * @param array $params
		 * @param bool|false $return
		 * @return string
		 */
		public function render( $file, $params = array(), $return = false ) {
			//        $params = array_merge( array('self' => $this), $params );
			/**
			 * assign $file to a variable which is unlikely to be used by users of the method
			 */
			$opt_in_to_be_file_name = $file;
			if ( array_key_exists( 'this', $params ) ) {
				unset( $params['this'] );
			}
			extract( $params, EXTR_OVERWRITE ); // phpcs:ignore

			if ( $return ) {
				ob_start();
			}

			$template_file = trailingslashit( self::$plugin_path ) . self::VIEWS_FOLDER . '/' . $opt_in_to_be_file_name . '.php';
			if ( file_exists( $template_file ) ) {
				include $template_file;
			} else {
				$template_path = self::$template_path . $opt_in_to_be_file_name . '.php';
				// Render file located outside the plugin's folder. Useful when adding third party integrations.
				$external_path = $opt_in_to_be_file_name . '.php';

				if ( file_exists( $template_path ) ) {
					include $template_path;
				} elseif ( file_exists( $external_path ) ) {
					include $external_path;
				} elseif ( file_exists( $opt_in_to_be_file_name ) ) {
					include $opt_in_to_be_file_name;
				}
			}

			if ( $return ) {
				return ob_get_clean();
			}

			if ( ! empty( $params ) ) {
				foreach ( $params as $param ) {
					unset( $param );
				}
			}
		}

		/**
		 * Renders a view file with static call
		 *
		 * @param $file
		 * @param array $params
		 * @param bool|false $return
		 * @return string
		 */
		public static function static_render( $file, $params = array(), $return = false ) {
			$params = array_merge( $params );
			/**
			 * assign $file to a variable which is unlikely to be used by users of the method
			 */
			$opt_in_to_be_file_name = $file;
			extract( $params, EXTR_OVERWRITE ); // phpcs:ignore

			if ( $return ) {
				ob_start();
			}

			$template_file = trailingslashit( self::$plugin_path ) . self::VIEWS_FOLDER . '/' . $opt_in_to_be_file_name . '.php';
			if ( file_exists( $template_file ) ) {
				include $template_file;
			} else {
				$template_path = self::$template_path . $opt_in_to_be_file_name . '.php';
				// Render file located outside the plugin's folder. Useful when adding third party integrations.
				$external_path = $opt_in_to_be_file_name . '.php';

				if ( file_exists( $template_path ) ) {
					include $template_path;
				} elseif ( file_exists( $external_path ) ) {
					include $external_path;
				} elseif ( file_exists( $opt_in_to_be_file_name ) ) {
					include $opt_in_to_be_file_name;
				}
			}

			if ( $return ) {
				return ob_get_clean();
			}

			if ( ! empty( $params ) ) {
				foreach ( $params as $param ) {
					unset( $param );
				}
			}
		}


		protected function get_palette( $palette_name ) {
			$palette_name = ucwords( str_replace( '_', ' ', $palette_name ) );

			$palettes = $this->get_palettes();
			return $palettes[ $palette_name ];
		}

		public function current_page_type() {
			/**
			 * @var $wp_query WP_Query
			 */
			global $wp_query, $post;
			$type = 'notfound';

			if ( $wp_query->is_page ) {
				$type = is_front_page() ? 'front' : 'page';
			} elseif ( $wp_query->is_home ) {
				$type = 'home';
			} elseif ( $wp_query->is_single  ) {
				$type = ( $wp_query->is_attachment ) ? 'attachment' : get_post_type();
			} elseif ( $wp_query->is_category ) {
				$type = 'category';
			} elseif ( $wp_query->is_tag ) {
				$type = 'tag';
			} elseif ( $wp_query->is_tax ) {
				$type = 'tax';
			} elseif ( $wp_query->is_archive ) {
				if ( $wp_query->is_day ) {
					$type = 'day';
				} elseif ( $wp_query->is_month ) {
					$type = 'month';
				} elseif ( $wp_query->is_year ) {
					$type = 'year';
				} elseif ( $wp_query->is_author ) {
					$type = 'author';
				} else {
					$type = 'archive';
				}
			} elseif ( $wp_query->is_search ) {
				$type = 'search';
			} elseif ( $wp_query->is_404 ) {
				$type = 'notfound';
			}

			return $type;
		}

		/**
		 * Prepares the custom css string
		 *
		 * @since 1.0
		 * @param $css_string
		 * @param $prefix
		 * @param bool|false $as_array
		 * @param bool|true $separate_prefix
		 * @return array|string
		 */
		public static function prepare_css( $css_string, $prefix, $as_array = false, $separate_prefix = true, $wildcard = '' ) {
			$css_array = array(); // master array to hold all values
			$elements = explode( '}', $css_string );
			// Output is the final processed CSS string.
			$output = '';
			$prepared = '';
			$have_media = false;
			$media_names = array();
			$media_names_key = 0;
			$index = 0;
			foreach ( $elements as $element ) {

				$check_element = trim( $element );
				if ( empty( $check_element ) ) {
					// Still increment $index even if empty.
					$index++;
					continue;
				}

				// get the name of the CSS element
				$a_name = explode( '{', $element );
				$name = $a_name[0];

				// check if @media is  present
				$media_name = '';
				if ( strpos( $name, '@media' ) !== false && isset( $a_name[1] ) ) {
					$have_media = true;
					$media_name = $name;
					$media_names[ $media_names_key ] = array(
						'name' => $media_name,
					);
					$name = $a_name[1];
					$media_names_key++;
				}

				if ( $have_media ) {
					$prepared = '';
				}

				// get all the key:value pair styles
				$a_styles = explode( ';', $element );
				// remove element name from first property element
				$remove_element_name = ( ! empty( $media_name ) ) ? $media_name . '{' . $name : $name;
				$a_styles[0] = str_replace( $remove_element_name . '{', '', $a_styles[0] );
				$names = explode( ',', $name );
				foreach ( $names as $name ) {
					if ( $separate_prefix && empty( $wildcard ) ) {
						$space_needed = true;
					} elseif ( $separate_prefix && ! empty( $wildcard ) ) {
						// wildcard is the sibling class of target selector e.g. "wph-modal"
						if ( strpos( $name, $wildcard ) ) {
							$space_needed = false;
						} else {
							$space_needed = true;
						}
					} else {
						$space_needed = false;
					}
					$maybe_put_space = ( $space_needed ) ? ' ' : '';
					$prepared .= ( $prefix . $maybe_put_space . trim( $name ).',' );
				}
				$prepared = trim( $prepared, ',' );
				$prepared .= '{';
				// loop through each style and split apart the key from the value
				$count = count( $a_styles );
				for ( $a = 0;$a < $count;$a++ ) {
					if ( trim( $a_styles[ $a ] ) ) {
						$a_key_value = explode( ':', $a_styles[ $a ] );
						// build the master css array
						if ( count( $a_key_value ) > 2 ) {
							$a_key_value_to_join = array_slice( $a_key_value, 1 );
							$a_key_value[1] = implode( ':', $a_key_value_to_join );
						}
						if ( ! isset( $a_key_value[1] ) ) {
							continue;
						}
						$css_array[ $name ][ $a_key_value[0] ] = $a_key_value[1];
						$prepared .= ($a_key_value[0] . ': ' . $a_key_value[1]);// . strpos($a_key_value[1], "!important") === false ? " !important;": ";";
						if ( strpos( $a_key_value[1], '!important' ) === false ) { $prepared .= ' !important'; }
						$prepared .= ';';
					}
				}
				$prepared .= '}';

				// if have @media earlier, append these styles
				$prev_media_names_key = $media_names_key - 1;
				if ( isset( $media_names[ $prev_media_names_key ] ) ) {
					if ( isset( $media_names[ $prev_media_names_key ]['styles'] ) ) {
						// See if there were two closing '}' or just one.
						// (each element is exploded/split on '}' symbol, so having two empty strings afterward in the elements array means two '}'s.
						$next_element = isset( $elements[ $index + 2 ] ) ? trim( $elements[ $index + 2 ] ) : false;
						// If inside @media block.
						if ( ! empty( $next_element ) ) {
							$media_names[ $prev_media_names_key ]['styles'] .= $prepared;
						} else {
							// If outside of @media block, add to output.
							$output .= $prepared;
						}
					} else {
						$media_names[ $prev_media_names_key ]['styles'] = $prepared;
					}
				} else {
					// If no @media, add styles to $output outside @media.
					$output .= $prepared;
				}
				// Increase index.
				$index++;
			}

			// if have @media, populate styles using $media_names
			if ( $have_media ) {
				// reset first $prepared styles
				$prepared = '';
				foreach ( $media_names as $media ) {
					$prepared .= $media['name'] . '{ ' . $media['styles'] . ' }';
				}
				// Add @media styles to output.
				$output .= $prepared;
			}

			return $as_array ? $css_array : $output;
		}

		/**
		 * Returns constant value from the provided $class_name
		 * this method is to provide compatibility to php versions less than 5.3
		 *
		 * @param $class_name
		 * @param $const_name
		 * @return mixed
		 */
		public static function get_const( $class_name, $const_name ) {
			$reflection = new ReflectionClass( $class_name );
			return $reflection->getConstant( $const_name );
		}

		public static function render_attributes( $html_options, $echo = true ) {

			$special_attributes = array(
				'async' => 1,
				'autofocus' => 1,
				'autoplay' => 1,
				'checked' => 1,
				'controls' => 1,
				'declare' => 1,
				'default' => 1,
				'defer' => 1,
				'disabled' => 1,
				'formnovalidate' => 1,
				'hidden' => 1,
				'ismap' => 1,
				'loop' => 1,
				'multiple' => 1,
				'muted' => 1,
				'nohref' => 1,
				'noresize' => 1,
				'novalidate' => 1,
				'open' => 1,
				'readonly' => 1,
				'required' => 1,
				'reversed' => 1,
				'scoped' => 1,
				'seamless' => 1,
				'selected' => 1,
				'typemustmatch' => 1,
			);
			if ( array() === $html_options ) {
				return ''; }

			$html = '';
			if ( isset( $html_options['encode'] ) ) {
				$raw = ! $html_options['encode'];
				unset( $html_options['encode'] );
			} else {
				$raw = false;
			}
			foreach ( $html_options as $name => $value ) {
				if ( isset( $special_attributes[ $name ] ) ) {
					if ( $value ) {
						$html .= ' ' . $name;
						$html .= '="' . $name . '"';
					}
				} elseif ( null !== $value ) {
					$html .= ' ' . esc_attr( $name ) . '="' . ($raw ? $value : esc_attr( $value ) ) . '"'; }
			}

			if ( $echo ) {
				echo $html; // WPCS: xss ok.
			} else { 			return $html; }
		}

		/**
		 * SUI summary config
		 *
		 * @since 4.0.0
		 */
		public function get_sui_summary_config( $class = null ) {
			$style = '';
			$image_url = apply_filters( 'wpmudev_branding_hero_image', null );
			if ( ! empty( $image_url ) ) {
				$style = 'background-image:url(' . esc_url( $image_url ) . ')';
			}
			$sui = array(
				'summary' => array(
					'style' => $style,
					'classes' => array(
						'sui-box',
						'sui-summary',
					),
				),
			);
			if ( ! empty( $class ) && is_string( $class ) ) {
				$sui['summary']['classes'][] = $class;
			}
			/**
			 * Dash integration
			 *
			 * @since 4.0.0
			 */
			$hide_branding = apply_filters( 'wpmudev_branding_hide_branding', false );
			$branding_image = apply_filters( 'wpmudev_branding_hero_image', null );
			if ( $hide_branding && ! empty( $branding_image ) ) {
				$sui['summary']['classes'][] = 'sui-rebranded';
			} elseif ( $hide_branding && empty( $branding_image ) ) {
				$sui['summary']['classes'][] = 'sui-unbranded';
			}
			return $sui;
		}
	}

endif;

/**
 * Initializing Hustle classes
 */
$hustle = new Opt_In();
$hustle_init = new Hustle_Init( $hustle );

//Load dashboard notice
if ( file_exists( Opt_In::$plugin_path . 'lib/wpmudev-dashboard/wpmudev-dash-notification.php' ) ) {
	global $wpmudev_notices;
	$wpmudev_notices[] = array(
		'id' => 1107020,
		'name' => 'Hustle',
		'screens' => array(
			'toplevel_page_hustle',
			'optin-pro_page_inc_optin',
		),
	);
	require_once Opt_In::$plugin_path . 'lib/wpmudev-dashboard/wpmudev-dash-notification.php';
}

if ( is_admin() && Opt_In_Utils::_is_free() ) {
	require_once Opt_In::$plugin_path . 'lib/free-dashboard/module.php';
	// Register the current plugin.
	do_action(
		'wdev-register-plugin',
		plugin_basename( __FILE__ ), 			 // 1. Plugin ID
		'Hustle', 								 // 2. Plugin Title
		'/plugins/wordpress-popup/', 			 // 3. https://wordpress.org
		__( 'Sign Me Up', Opt_In::TEXT_DOMAIN ), // 4. Email Button CTA
		'f68d9fbc51'							 // 5. Mailchimp List id
	);
}

if ( ! function_exists( 'hustle_activation' ) ) {
	function hustle_activation() {
		update_option( 'hustle_activated_flag', 1 );
		delete_option( Hustle_Db::DB_VERSION_KEY );
	}
}
register_activation_hook( __FILE__, 'hustle_activation' );
