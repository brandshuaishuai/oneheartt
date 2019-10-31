<?php
/**
 * Class WPHEALTHTRACKER_Admin_Master_Ui - class-wphealthtracker-admin-master-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes/UI/Admin
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Admin_Master_Ui', false ) ) :
	/**
	 * WPHEALTHTRACKER_Admin_Master Class.
	 */
	class WPHEALTHTRACKER_Admin_Master_Ui {

		/** Common member variable
		 *
		 *  @var string $page
		 */
		public $page;

		/** Common member variable
		 *
		 *  @var string $translations
		 */
		public $translations;

		/**
		 * Class constructor. Determines what functions to call.
		 */
		public function __construct() {

			// Require the translations file.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->translations = new WPHealthTracker_Translations();
			$this->translations->exercise_tab_trans_strings();
			$this->translations->common_trans_strings();
			$this->translations->d3_chart_trans_strings();
			$this->translations->tab_titles_trans_strings();

			// Get active plugins to see if any extensions are in play.
			$this->active_plugins = (array) get_option( 'active_plugins', array() );
			if ( is_multisite() ) {
				$this->active_plugins = array_merge( $this->active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			}

			// Get current menu/submenu.
			if ( isset( $_GET['page'] ) ) {
				$this->page = filter_var( wp_unslash( $_GET['page'] ), FILTER_SANITIZE_STRING );
			}

			// Get current tab - if no tab, set $this->activetab to default.
			if ( isset( $_GET['tab'] ) ) {
				$this->activetab = filter_var( wp_unslash( $_GET['tab'] ), FILTER_SANITIZE_STRING );
			} else {
				$this->activetab = 'default';
			}

			// Controls UI for each Menu/Submenu page.
			switch ( $this->page ) {
				case 'WPHealthTracker-users':
					$this->setup_users_ui();
					break;

				case 'WPHealthTracker-Options-extentions':
					$this->setup_extensions_ui();
					break;
				case 'WPHealthTracker-tracker':
					$this->setup_tracker_ui();
					break;
				case 'WPHealthTracker-stats':
					$this->setup_stats_ui();
					break;
				default:
					// Controls UI for submenu pages added through extensions.
					$this->setup_dynamic_ui();
					break;
			}
		}

		/**
		 * Sets up tabs for the 'Users' page
		 */
		private function setup_users_ui() {
			$this->tabs = array(
				'createuser' => $this->translations->tab_title_7,
				'edituser'   => $this->translations->tab_title_16,
			);

			if ( has_filter( 'wphealthtracker_add_tab_users' ) ) {
				$this->tabs = apply_filters( 'wphealthtracker_add_tab_users', $this->tabs );
			}

			if ( 'default' === $this->activetab ) {
				$this->activetab = null;
			}

			$this->output_tabs_ui();
			$this->output_indiv_tab();
		}

		/**
		 * Sets up tabs for the 'Tracker' page
		 */
		private function setup_tracker_ui() {
			$this->tabs = array(
				'tracker'     => $this->translations->tab_title_1,
				'vitals'      => $this->translations->tab_title_2,
				'diet'        => $this->translations->tab_title_4,
				'exercise'    => $this->translations->tab_title_6,
				//'medications' => $this->translations->tab_title_8,
				//'lifestyle'   => $this->translations->tab_title_9,
				//'goaltracker' => $this->translations->tab_title_10,
				//'misc'        => $this->translations->tab_title_11,
			);

			if ( has_filter( 'wphealthtracker_add_tab_tracker' ) ) {
				$this->tabs = apply_filters( 'wphealthtracker_add_tab_tracker', $this->tabs );
			}

			if ( 'default' === $this->activetab ) {
				$this->activetab = null;
			}

			$this->output_tabs_ui();
			$this->output_indiv_tab();
		}

		/**
		 * Sets up tabs for the 'Stats' page
		 */
		private function setup_stats_ui() {
			$this->tabs = array(
				'vitalstats'    => $this->translations->tab_title_3,
				'dietstats'     => $this->translations->tab_title_5,
				'exercisestats' => $this->translations->tab_title_12,
				//'medstats'      => $this->translations->tab_title_13,
				//'lastats'       => $this->translations->tab_title_14,
				//'goalstats'     => $this->translations->tab_title_15,
			);

			if ( has_filter( 'wphealthtracker_add_tab_tracker' ) ) {
				$this->tabs = apply_filters( 'wphealthtracker_add_tab_tracker', $this->tabs );
			}

			if ( 'default' === $this->activetab ) {
				$this->activetab = null;
			}

			$this->output_tabs_ui();
			$this->output_indiv_tab();
		}

		/**
		 * Sets up the tabs for a submenu page that has been added by an extension
		 */
		private function setup_dynamic_ui() {
			$path = $this->build_extension_path();
			$path = $path . '/includes/classes/ui/admin/';

			$page              = explode( '-', $this->page );
			$tab_array         = array();
			$tab_display_array = array();
			$tab_slug_array    = array();

			if ( file_exists( $path ) && is_dir( $path ) ) {
				$dir_array = scandir( $path );

				foreach ( $dir_array as $file ) {
					if ( '.' === $file || '..' === $file ) {
						continue;
					}

					if ( 'wphealthtracker-' . $page[2] . '.php' === $file ) {
						continue;
					}

					$filestring = explode( '-', $file );
					foreach ( $filestring as $string ) {
						if ( 'admin' === $string || 'class' === $string || 'tab' === $string || 'extension' === $string || 'ui.php' === $string ) {
							continue;
						} else {
							array_push( $tab_array, $string );
						}
					}

					array_shift( $tab_array );
					$final_tab_string             = '';
					$final_tab_string_for_display = '';
					foreach ( $tab_array as $tabpart ) {
						$final_tab_string_for_display = $final_tab_string_for_display . ' ' . ucfirst( $tabpart );
						$final_tab_string             = $final_tab_string . '-' . $tabpart;
					}

					array_push( $tab_display_array, ltrim( $final_tab_string_for_display, ' ' ) );
					array_push( $tab_slug_array, ltrim( $final_tab_string, '-' ) );

					$final_tab_string_for_display = '';
					$final_tab_string             = '';
					$tab_array                    = array();
				}
			}

			$this->tabs = array();
			foreach ( $tab_slug_array as $key => $slug ) {
				$this->tabs[ $slug ] = $tab_display_array[ $key ];
			}

			// A filter to add tabs to the submenu page. So the submenu extensions can have their own separate plugins that add tabs to it. The name of this filter will be 'wphealthtracker_add_tab_' plus the one-word unique identifer for this extension, i.e., the word that is displayed in the WPHEALTHTRACKER plugin main menu.
			if ( array_key_exists( 2, $page ) ) {
				if ( has_filter( 'wphealthtracker_add_tab_' . $page[2] ) ) {
					$this->tabs = apply_filters( 'wphealthtracker_add_tab_' . $page[2], $this->tabs );
				}
			}

			if ( 'default' === $this->activetab ) {
				$this->activetab = null;
			}

			$this->output_tabs_ui();
			$this->output_indiv_tab();
		}

		/**
		 * The function that actually generates the tabs on a page
		 */
		private function output_tabs_ui() {
			$current = '';
			if ( ! empty( $_GET['tab'] ) ) {
				$this->activetab = filter_var( $_GET['tab'], FILTER_SANITIZE_STRING );
			} else {
				reset( $this->tabs );
				$this->activetab = strtolower( key( $this->tabs ) );
			}

			$html = '<h2 class="nav-tab-wrapper">';
			foreach ( $this->tabs as $tab => $name ) {
				$class = ( $tab === $current ) ? 'nav-tab-active' : '';
				$html .= '<a class="nav-tab ' . $class . '" href="?page=' . $this->page . '&tab=' . $tab . '">' . $name . '</a>';
			}
			$html .= '</h2>';
			echo $html;
		}

		/**
		 * The function that controls the output for each individual tab
		 */
		private function output_indiv_tab() {
			$this->activetab;
			$this->page;
			$page = explode( '-', $this->page );

			$filename = null;
			if ( array_key_exists( 1, $page ) ) {
				$filename = 'class-admin-' . $page[1] . '-' . $this->activetab . '-tab-ui.php';
			}

			// Support for Extensions.
			if ( ! file_exists( WPHEALTHTRACKER_CLASSES_UI_ADMIN_DIR . $filename ) ) {
				$path = $this->build_extension_path();
				if ( is_dir( $path ) ) {
					$path1 = $path . '/includes/ui/class-admin-' . $page[1] . '-' . $this->activetab . '-tab-extension-ui.php';
					if ( is_dir( $path1 ) ) {
						require_once $path1;
					} else {
						$path2 = $path . '/includes/classes/ui/admin/class-admin-' . $page[1] . '-' . $this->activetab . '-tab-extension-ui.php';
						require_once $path2;
					}
				} else {
					require_once $path;
				}
			} else {
				// Look for file in core plugin.
				require_once WPHEALTHTRACKER_CLASSES_UI_ADMIN_DIR . $filename;
			}
		}

		/**
		 * The function that builds paths for extensions, both for creating a new submenu page, and tabs that have been added via extensions.
		 */
		private function build_extension_path() {
			$page = explode( '-', $this->page );
			foreach ( $this->active_plugins as $plugin ) {
				if ( strpos( $plugin, 'wphealthtracker-' ) !== false ) {
					if ( strpos( $plugin, $this->activetab ) !== false ) {
						$temp = explode( '-', $plugin );
						if ( $temp[2] === $this->activetab . '.php' ) {
							$filename = 'class-admin-' . $page[2] . '-' . $this->activetab . '-tab-extension-ui.php';
							$path     = WPHEALTHTRACKER_ROOT_WP_PLUGINS_DIR . $temp[0] . '-' . $this->activetab . '/' . $filename;
						} else {
							echo 'something wrong';
						}
					}

					if ( ! isset( $path ) ) {
						$path = null;
					}

					if ( file_exists( $path ) && ! is_dir( $path ) ) {
						return $path;
					} else {
						$page = explode( '-', $this->page );
						if ( strpos( $plugin, $page[2] ) !== false ) {
							$path = WPHEALTHTRACKER_ROOT_WP_PLUGINS_DIR . 'wphealthtracker-' . $page[2];
							if ( file_exists( $path ) ) {
								return $path;
							}
						}
					}
				}
			}
		}

	}
endif;


// Instantiate the class.
$am = new WPHEALTHTRACKER_Admin_Master_Ui();
