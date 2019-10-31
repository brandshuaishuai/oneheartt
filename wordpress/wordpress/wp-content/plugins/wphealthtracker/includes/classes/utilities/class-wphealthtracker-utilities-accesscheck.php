<?php
/**
 * Class WPHealthTracker_Utilities_Date - class-wphealthtracker-utilities-accesscheck.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Exercise
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Utilities_Accesscheck', false ) ) :
	/**
	 * WPHealthTracker_Utilities_Date class. Here we'll house everything to do with getting the current accesscheck.
	 */
	class WPHealthTracker_Utilities_Accesscheck {

		/** Common member variable
		 *
		 *  @var array $user
		 */
		public $user = array();

		/**
		 * The users ID we're checking access on.
		 *
		 * @param int $wpuserid - The users ID we're checking access on.
		 */
		public function wphealthtracker_accesscheck( $wpuserid, $perm ) {

			global $wpdb;

			// Get all saved Users from the WPHealthTracker Users table.
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->user = $transient_exists;
			} else {
				$query      = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $wpuserid;
				$this->user = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// If we've retreived a user, continue on to permission check, otherwise return false.
			if ( null !== $this->user ) {

				// Get user's specific permissions.
				$perms = $this->user->permissions;
				$perms = explode( ',', $perms );

				// Now check permissions - if user is just a regular user or a reviewer, and they haven't been granted specific access to this page, then they have no access to this page.
				if ( ( 'admin' !== $this->user->role && 'godmode' !== $this->user->role ) && '1' !== $perm ) {
					return false;
				} else {
					return $this->user;
				}
			} else {

				// No registered WPHealthTracker user was found - return false.
				return false;
			}
		}

		/**
		 * The getting the WPHealthTracker user's role and permissions.
		 *
		 * @param int $wpuserid - The users ID we're checking access on.
		 */
		public function wphealthtracker_get_user_role_and_perms( $wpuserid ) {

			global $wpdb;

			// Get all saved Users from the WPHealthTracker Users table.
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->user = $transient_exists;
			} else {
				$query      = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $wpuserid;
				$this->user = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// If we've retreived a user, continue on to permission check, otherwise return false.
			if ( null !== $this->user ) {

				// Get user's specific permissions.
				$perms = $this->user->permissions;
				$perms = explode( ',', $perms );

				// Set user's permissions and role.
				$this->userrole  = $this->user->role;
				$this->userperms = $this->user->permissions;

			} else {

				// No registered WPHealthTracker user was found - set role and permissions to false.
				$this->userrole  = false;
				$this->userperms = false;
			}
		}

		/**
		 * Create the 'No Access' message.
		 */
		public function wphealthtracker_accesscheck_no_permission_message() {

			// Grab Superadmin from the settings table to the user knows who to contact.
			global $wpdb;

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients          = new WPHealthTracker_Transients();
			$settings_table_name = $wpdb->prefix . 'wphealthtracker_general_settings';
			$transient_name      = 'wpht_' . md5( 'SELECT * FROM ' . $settings_table_name );
			$transient_exists    = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->general_settings = $transient_exists;
			} else {
				$query                  = 'SELECT * FROM ' . $settings_table_name;
				$this->general_settings = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			$gmuser = $this->general_settings->gmuser;
			$gmuser = explode( ',', $gmuser );

			// Getting the current SuperAdmin.
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE role = "godmode"' );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$gmuser = $transient_exists;
			} else {
				$query = 'SELECT * FROM ' . $users_table_name . ' WHERE role = "godmode"';
				$gmuser  = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// First we'll get all the translations for this tab.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->trans = new WPHealthTracker_Translations();
			$this->trans->common_trans_strings();
			$this->trans->dashboard_trans_strings();
			$this->trans->users_tab_trans_strings();

			return '<div class="wphealthtracker-no-saved-data-stats-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span-stats-1">' . $this->trans->dashboard_trans_21 . '</span>
					<br>
					' . $this->trans->common_trans_75 . '
					<br>
					' . $this->trans->common_trans_76 . ' ' . $gmuser->firstname . ' ' . $gmuser->lastname . ' ' . $this->trans->common_trans_78 . ' ' . $gmuser->email . ' ' . $this->trans->common_trans_77 . '
					<br><br>
				</p>
			</div>';
		}

		/**
		 * Creates custom WPHealthTracker WordPress roles
		 *
		 * @param string $role_name - The name of the role we're wanting to create.
		 */
		public function wphealthtracker_accesscheck_create_role( $role_name ) {

			// Require the translations file.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->translations = new WPHealthTracker_Translations();
			$this->translations->users_tab_trans_strings();

			$role_caps    = array();
			$display_name = '';

			switch ( $role_name ) {
				case $this->translations->user_trans_91:
					// Basic WPHealthTracker User.
					$role_caps = array(
						'read'                   => true,
						'edit_posts'             => false,
						'delete_posts'           => false,
						'edit_others_posts'      => false,
						'edit_published_posts'   => false,
						'publish_posts'          => false,
						'delete_others_posts'    => false,
						'delete_published_posts' => false,
						'delete_private_posts'   => false,
						'edit_private_posts'     => false,
						'read_private_posts'     => false,
						'edit_pages'             => false,
						'delete_pages'           => false,
						'edit_others_pages'      => false,
						'edit_published_pages'   => false,
						'publish_pages'          => false,
						'delete_others_pages'    => false,
						'delete_published_pages' => false,
						'delete_private_pages'   => false,
						'edit_private_pages'     => false,
						'read_private_pages'     => false,
						'moderate_comments'      => false,

					);

					$role_name    = 'wphealthtracker_basic_user';
					$display_name = $this->translations->user_trans_91;

					break;
				default:
					break;
			}

			// Create the wphealthtracker_basic_user role.
			$result = add_role( $role_name, $display_name, $role_caps );

			// Now get each role we have in WordPress and add our custom 'wphealthtracker_dashboard_access' capability to ensure that each user has access to the WPHealthTracker menu pages.
			global $wp_roles;
			$roles = $wp_roles->get_names();
			foreach ( $roles as $key => $role ) {
				$role       = strtolower( $role );
				$role       = str_replace( ' ', '_', $role );
				$indiv_role = get_role( $role );
				if ( null !== $indiv_role ) {
					$indiv_role->add_cap( 'wphealthtracker_dashboard_access' );
				}
			}
		}
	}

endif;
