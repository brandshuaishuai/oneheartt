<?php
if ( ! class_exists( 'Hustle_Mautic' ) ) :

	/**
 * Mautic Integration
 *
 * @class Hustle_Mautic
 * @version 1.0.0
 **/
	class Hustle_Mautic extends Hustle_Provider_Abstract {

		const SLUG = 'mautic';

		/**
	 * Provider Instance
	 *
	 * @since 3.0.5
	 *
	 * @var self|null
	 */
		protected static $_instance 	   = null;

		/**
	 * @since 3.0.5
	 * @var string
	 */
		public static $_min_php_version    = '5.3';

		/**
	 * @since 3.0.5
	 * @var string
	 */
		protected $_slug 				   = 'mautic';

		/**
	 * @since 3.0.5
	 * @var string
	 */
		protected $_version				   = '1.0';

		/**
	 * @since 3.0.5
	 * @var string
	 */
		protected $_class				   = __CLASS__;

		/**
	 * @since 3.0.5
	 * @var string
	 */
		protected $_title                  = 'Mautic';

		/**
	 * @since 3.0.5
	 * @var bool
	 */
		protected $_supports_fields 	   = true;

		/**
	 * Class name of form settings
	 *
	 * @var string
	 */
		protected $_form_settings = 'Hustle_Mautic_Form_Settings';

	/**
	 * Class name of form hooks
	 *
	 * @since 4.0
	 * @var string
	 */
		protected $_form_hooks = 'Hustle_Mautic_Form_Hooks';

	/**
	 * Array of options which should exist for confirming that settings are completed
	 *
	 * @since 4.0
	 * @var array
	 */
	protected $_completion_options = array( 'url', 'username', 'password' );

		/**
	 * Provider constructor.
	 */
		public function __construct() {
			$this->_icon_2x = plugin_dir_url( __FILE__ ) . 'images/icon.png';
			$this->_logo_2x = plugin_dir_url( __FILE__ ) . 'images/logo.png';

			if ( ! class_exists( 'Hustle_Mautic_Api' ) ) {
				include_once 'hustle-mautic-api.php';
			}
		}

		/**
	 * Get Instance
	 *
	 * @return self|null
	 */
		public static function get_instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
	 * Get the wizard callbacks for the global settings.
	 *
	 * @since 4.0
	 *
	 * @return array
	 */
		public function settings_wizards() {
			return array(
				array(
					'callback'     => array( $this, 'configure_credentials' ),
					'is_completed' => array( $this, 'is_connected' ),
				),
			);
		}

		public static function api( $base_url = '', $username = '', $password = '' ) {
			if ( ! class_exists( 'Hustle_Mautic_Api' ) ) {
				include_once 'hustle-mautic-api.php';
			}
			try {
				return new Hustle_Mautic_Api( $base_url, $username, $password );
			} catch ( Exception $e ) {
				return $e;
			}
		}

		/**
	 * Configure Global settings.
	 *
	 * @since 4.0
	 *
	 * @param array $submitted_data
	 * @return array
	 */
		public function configure_credentials( $submitted_data ) {
			$has_errors = false;
			$default_data = array(
				'url' => '',
				'username' => '',
				'password' => '',
				'name' => '',
			);
			$current_data = $this->get_current_data( $default_data, $submitted_data );
			$is_submit = isset( $submitted_data['url'] ) && isset( $submitted_data['username'] )
				&& isset( $submitted_data['password'] );
			$global_multi_id = $this->get_global_multi_id( $submitted_data );

			$app_url_valid = $api_username_valid = $api_password_valid = true;
			if ( $is_submit ) {

				$app_url_valid = ! empty( trim( $current_data['url'] ) );
				$api_username_valid = ! empty( trim( $current_data['username'] ) )
				                      && sanitize_email( $current_data['username'] ) === $current_data['username'];
				$api_password_valid = ! empty( trim( $current_data['password'] ) );
				$api_key_validated = $app_url_valid
				                     && $api_username_valid
				                     && $api_password_valid
				                     && $this->validate_credentials( $submitted_data['url'], $submitted_data['username'], $submitted_data['password'] );
				if ( ! $api_key_validated ) {
					$error_message = $this->provider_connection_falied();
					$has_errors = true;
				}

				if ( ! $has_errors ) {
					$settings_to_save = array(
						'url' => $current_data['url'],
						'username' => $current_data['username'],
						'password' => $current_data['password'],
						'name' => $current_data['name'],
					);
					// If not active, activate it.
					// TODO: Wrap this in a friendlier method
					if ( Hustle_Provider_Utils::is_provider_active( $this->_slug )
							|| Hustle_Providers::get_instance()->activate_addon( $this->_slug ) ) {
						$this->save_multi_settings_values( $global_multi_id, $settings_to_save );
					} else {
						$error_message = __( "Provider couldn't be activated.", Opt_In::TEXT_DOMAIN );
						$has_errors = true;
					}
				}

				if ( ! $has_errors ) {

					return array(
						'html'         => Hustle_Api_Utils::get_modal_title_markup( __( 'Mautic Added', Opt_In::TEXT_DOMAIN ), __( 'You can now go to your forms and assign them to this integration', Opt_In::TEXT_DOMAIN ) ),
						'buttons'      => array(
							'close' => array(
								'markup' => Hustle_Api_Utils::get_button_markup( __( 'Close', Opt_In::TEXT_DOMAIN ), 'sui-button-ghost', 'close' ),
							),
						),
						'redirect'     => false,
						'has_errors'   => false,
						'notification' => array(
							'type' => 'success',
							'text' => '<strong>' . $this->get_title() . '</strong> ' . __( 'Successfully connected', Opt_In::TEXT_DOMAIN ),
						),
					);

				}
			}

			$options = array(
				array(
					'type'     => 'wrapper',
					'class'    => $app_url_valid ? '' : 'sui-form-field-error',
					'elements' => array(
						'label' => array(
							'type'  => 'label',
							'for'   => 'url',
							'value' => __( 'Installation URL', Opt_In::TEXT_DOMAIN ),
						),
						'url' => array(
							'type'        => 'url',
							'name'        => 'url',
							'value'       => $current_data['url'],
							'placeholder' => __( 'Enter URL', Opt_In::TEXT_DOMAIN ),
							'id'          => 'url',
							'icon'        => 'web-globe-world',
						),
						'error' => array(
							'type'  => 'error',
							'class' => $app_url_valid ? 'sui-hidden' : '',
							'value' => __( 'Please enter a valid Mautic installation URL', Opt_In::TEXT_DOMAIN ),
						),
					),
				),
				array(
					'type'     => 'wrapper',
					'class'    => $api_username_valid ? '' : 'sui-form-field-error',
					'elements' => array(
						'label' => array(
							'type'  => 'label',
							'for'   => 'username',
							'value' => __( 'Login Email', Opt_In::TEXT_DOMAIN ),
						),
						'username' => array(
							'type'        => 'text',
							'name'        => 'username',
							'value'       => $current_data['username'],
							'placeholder' => __( 'Enter Email', Opt_In::TEXT_DOMAIN ),
							'id'          => 'username',
							'icon'        => 'mail',
						),
						'error' => array(
							'type'  => 'error',
							'class' => $api_username_valid ? 'sui-hidden' : '',
							'value' => __( 'Please enter a valid Mautic login email', Opt_In::TEXT_DOMAIN ),
						),
					),
				),
				array(
					'type'     => 'wrapper',
					'class'    => $api_password_valid ? '' : 'sui-form-field-error',
					'elements' => array(
						'label' => array(
							'type'  => 'label',
							'for'   => 'password',
							'value' => __( 'Login Password', Opt_In::TEXT_DOMAIN ),
						),
						'password' => array(
							'type'        => 'password',
							'name'        => 'password',
							'value'       => $current_data['password'],
							'placeholder' => __( 'Enter Password', Opt_In::TEXT_DOMAIN ),
							'id'          => 'password',
							'icon'        => 'eye-hide',
						),
						'error' => array(
							'type'  => 'error',
							'class' => $api_password_valid ? 'sui-hidden' : '',
							'value' => __( 'Please enter a valid Mautic login password', Opt_In::TEXT_DOMAIN ),
						),
					),
				),
				array(
					'type'     => 'wrapper',
					'style'    => 'margin-bottom: 0;',
					'elements' => array(
						'label' => array(
							'type'  => 'label',
							'for'   => 'instance-name-input',
							'value' => __( 'Identifier', Opt_In::TEXT_DOMAIN ),
						),
						'name' => array(
							'type'        => 'text',
							'name'        => 'name',
							'value'       => $current_data['name'],
							'placeholder' => __( 'E.g. Business Account', Opt_In::TEXT_DOMAIN ),
							'id'          => 'instance-name-input',
						),
						'message' => array(
							'type'  => 'description',
							'value' => __( 'Helps to distinguish your integrations if you have connected to the multiple accounts of this integration.', Opt_In::TEXT_DOMAIN ),
						),
					)
				),
			);

			$step_html = Hustle_Api_Utils::get_modal_title_markup(
				__( 'Configure Mautic', Opt_In::TEXT_DOMAIN ),
				sprintf(
					__( 'Enable API and HTTP Basic Auth in your Mautic configuration API settings. %1$sRemember:%2$s Your Mautic installation URL must start with either http or https.', Opt_In::TEXT_DOMAIN ),
					'<strong>',
					'</strong>'
				)
			);
			if ( $has_errors ) {
				$step_html .= '<span class="sui-notice sui-notice-error"><p>' . esc_html( $error_message ) . '</p></span>';
			}
			$step_html .= Hustle_Api_Utils::get_html_for_options( $options );

			$is_edit = $this->settings_are_completed( $global_multi_id );
			if ( $is_edit ) {
				$buttons = array(
					'disconnect' => array(
						'markup' => Hustle_Api_Utils::get_button_markup( __( 'Disconnect', Opt_In::TEXT_DOMAIN ), 'sui-button-ghost', 'disconnect', true ),
					),
					'save' => array(
						'markup' => Hustle_Api_Utils::get_button_markup( __( 'Save', Opt_In::TEXT_DOMAIN ), '', 'connect', true ),
					),
				);
			} else {
				$buttons = array(
					'connect' => array(
						'markup' => Hustle_Api_Utils::get_button_markup( __( 'Connect', Opt_In::TEXT_DOMAIN ), '', 'connect', true ),
					),
				);

			}

			$response = array(
			'html'       => $step_html,
			'buttons'    => $buttons,
			'has_errors' => $has_errors,
			);

			return $response;
		}

		/**
	 * Validate the provided credentials.
	 *
	 * @since 4.0
	 *
	 * @param string $url
	 * @param string $username
	 * @param string $password
	 * @return bool
	 */
		private function validate_credentials( $url, $username, $password ) {
			if ( empty( $url ) || empty( $username ) || empty( $password ) ) {
				return false;
			}

			try {
				// Check if credentials are valid
				$api = self::api( $url, $username, $password );

				$_lists = $api->get_segments();

				if ( is_wp_error( $_lists ) || empty( $_lists ) ) {
					Hustle_Api_Utils::maybe_log( __METHOD__, __( 'Invalid Mautic API credentials.', Opt_In::TEXT_DOMAIN ) );
					return false;
				}

			} catch ( Exception $e ) {
				Hustle_Api_Utils::maybe_log( __METHOD__, $e->getMessage() );
				return false;
			}

			return true;
		}

		public function get_30_provider_mappings() {
			return array(
				'url'      => 'url',
				'username' => 'username',
				'password' => 'password',
			);
		}

		public static function add_custom_fields( $fields, $api ) {
			$custom_fields = $api->get_custom_fields();
			foreach ( $fields as $field ) {
				$label = $field['label'];
				$alias = $field['name'];
				$exist = false;

				if ( is_array( $custom_fields ) ) {
					foreach ( $custom_fields as $custom_field ) {
						if ( $label === $custom_field['label'] ) {
							$exist = true;
							$field['name'] = $custom_field['alias'];
						} elseif ( $custom_field['alias'] === $alias ) {
							$exist = true;
						}
					}
				}

				if ( false === $exist ) {
					$custom_field = array(
					'label' => $label,
					'alias' => $alias,
					'type' 	=> ( 'email' === $field['type'] || 'name' === $field['type'] || 'address' === $field['type'] || 'phone' === $field['type'] ) ? 'text' : $field['type'],
					);

					$exist = $api->add_custom_field( $custom_field );
				}
			}

			if ( $exist ) {
				return array(
					'success' => true,
					'field' => $fields,
				);
			}

			return array(
				'error' => true,
				'code' => '',
			);
		}
	}

endif;
