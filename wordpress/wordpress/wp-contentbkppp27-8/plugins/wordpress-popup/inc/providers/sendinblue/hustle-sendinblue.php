<?php

if( !class_exists("Hustle_SendinBlue") ) :

/**
* Class Hustle_SendinBlue
*/
class Hustle_SendinBlue extends Hustle_Provider_Abstract  {

	const SLUG = "sendinblue";
	//const NAME = "SendinBlue";

	const LIST_PAGES = "hustle-sendinblue-list-pages";
	const CURRENT_LISTS = "hustle-sendinblue-current-list";

	/**
	 * Provider Instance
	 *
	 * @since 3.0.5
	 *
	 * @var self|null
	 */
	protected static $_instance = null;

	/**
	 * @since 3.0.5
	 * @var string
	 */
	protected $_slug 				   = 'sendinblue';

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
	protected $_title                  = 'SendinBlue';

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
	protected $_form_settings = 'Hustle_SendinBlue_Form_Settings';

	/**
	 * Class name of form hooks
	 *
	 * @since 4.0
	 * @var string
	 */
	protected $_form_hooks = 'Hustle_SendinBlue_Form_Hooks';

	/**
	 * Provider constructor.
	 */
	public function __construct() {
		$this->_icon_2x = plugin_dir_url( __FILE__ ) . 'images/icon.png';
		$this->_logo_2x = plugin_dir_url( __FILE__ ) . 'images/logo.png';
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

	public static function api( $api_key ) {
		if ( ! class_exists( 'Hustle_SendinBlue_Api' ) )
			require_once 'hustle-sendinblue-api.php';

		$api = new Hustle_SendinBlue_Api( $api_key );

		return $api;
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
				'callback'     => array( $this, 'configure_api_key' ),
				'is_completed' => array( $this, 'is_connected' ),
			),
		);
	}


	/**
	 * Configure the API key settings. Global settings.
	 *
	 * @since 4.0
	 *
	 * @param array $submitted_data
	 * @return array
	 */
	public function configure_api_key( $submitted_data ) {
		$has_errors = false;
		$default_data = array(
			'api_key' => '',
			'name' => '',
		);
		$current_data = $this->get_current_data( $default_data, $submitted_data );
		$is_submit = isset( $submitted_data['api_key'] );
		$global_multi_id = $this->get_global_multi_id( $submitted_data );

		$api_key_validated = true;
		if ( $is_submit ) {

			$api_key_validated = $this->validate_api_key( $submitted_data['api_key'] );
			if ( ! $api_key_validated ) {
				$error_message = $this->provider_connection_falied();
				$has_errors = true;
			}

			if ( ! $has_errors ) {
				$settings_to_save = array(
					'api_key' => $current_data['api_key'],
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
					'html'         => Hustle_Api_Utils::get_modal_title_markup( __( 'SendinBlue Added', Opt_In::TEXT_DOMAIN ), __( 'You can now go to your forms and assign them to this integration', Opt_In::TEXT_DOMAIN ) ),
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
				'class'    => $api_key_validated ? '' : 'sui-form-field-error',
				'elements' => array(
					'label' => array(
						'type'  => 'label',
						'for'   => 'api_key',
						'value' => __( 'API Key', Opt_In::TEXT_DOMAIN ),
					),
					'api_key' => array(
						'type'        => 'text',
						'name'        => 'api_key',
						'value'       => $current_data['api_key'],
						'placeholder' => __( 'Enter Key', Opt_In::TEXT_DOMAIN ),
						'id'          => 'api_key',
						'icon'        => 'key',
					),
					'error' => array(
						'type'  => 'error',
						'class' => $api_key_validated ? 'sui-hidden' : '',
						'value' => __( 'Please enter a valid SendinBlue API key', Opt_In::TEXT_DOMAIN ),
					),
				)
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
			__( 'Configure SendinBlue', Opt_In::TEXT_DOMAIN ),
			sprintf(
				__( 'To get %1$sSendinBlue%2$s API key v2.0 log in %3$scampaigns dashboard%4$s and click on %1$sSMTP & API%2$s in left menu.', Opt_In::TEXT_DOMAIN ),
				'<strong>',
				'</strong>',
				'<a href="https://account.sendinblue.com/advanced/api" target="_blank">',
				'</a>'
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
	 * Validate the provided API key.
	 *
	 * @since 4.0
	 *
	 * @param string $api_key
	 * @return bool
	 */
	private function validate_api_key( $api_key ) {
		if ( empty( trim( $api_key ) ) ) {
			return false;
		}

		// Check API Key by validating it on get_info request
		try {

			if ( ! $this->check_api( $api_key ) ) {
				Hustle_Api_Utils::maybe_log( __METHOD__, __( 'Invalid SendinBlue API key.', Opt_In::TEXT_DOMAIN ) );
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
			'api_key' => 'api_key',
		);
	}

	/**
	 * Check API key
	 *
	 * @param object $api_key Hustle_SendinBlue_Api
	 * @return boolean | object Hustle_SendinBlue_Api
	 */
	public function check_api( $api_key ) {
		// Check if API key is valid
		$api = self::api( $api_key );

		$_lists = $api->get_lists( array(
			"page" => 1,
			"page_limit" => 10
		));

		if ( !is_wp_error( $_lists ) && 'failure' !== $_lists['code'] ) {
			return $api;
		} else {
			return false;
		}
	}

	public static function add_custom_fields( $fields, $api ) {
		try {
			foreach ( $fields as $field ) {
				$type = ( 'email' === $field['type'] || 'name' === $field['type'] || 'address' === $field['type'] || 'phone' === $field['type'] ) ? 'text' : $field['type'];
				$api->create_attribute( array(
					"type" => "normal",
					"data" => array(
					strtoupper( $field['name'] ) => strtoupper( $type )
					)
				) );
			}

		} catch ( Exception $e ) {
			return array(
				'error' => true,
				'code' => 'custom',
				'message' => $e->getMessage(),
			);
		}
		return array(
			'success' => true,
			'field' => $fields,
		);
	}
}

endif;
