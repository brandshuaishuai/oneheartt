<?php
/**
 * Helper functions for providers
 *
 * @since 4.0
 */
class Hustle_Provider_Utils {

	/**
	 * Instance of Hustle Provider Utils.
	 *
	 * @since 4.0
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Slug will be used as additional info in submission entries.
	 *
	 * @since 4.0
	 * @var string
	 */
	public $_last_url_request;

	/**
	 * Slug will be used as additional info in submission entries.
	 *
	 * @since 4.0
	 * @var string
	 */
	public $_last_data_received;

	/**
	 * Slug will be used as additional info in submission entries.
	 *
	 * @since 4.0
	 * @var string
	 */
	public $_last_data_sent;


	/**
	 * Return the existing instance of Hustle_Provider_Utils, or create a new one if none exists.
	 *
	 * @since 4.0
	 * @return Hustle_Provider_Utils
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get the last URL request.
	 *
	 * @since  4.0
	 * @return string
	 */
	final public function get_last_url_request() {
		return $this->_last_url_request;
	}

	/**
	 * Get the last received data.
	 *
	 * @since  4.0
	 * @return string
	 */
	final public function get_last_data_received() {
		return $this->_last_data_received;
	}

	/**
	 * Get the last sent data.
	 *
	 * @since  4.0
	 * @return string
	 */
	final public function get_last_data_sent() {
		return $this->_last_data_sent;
	}

	/**
	 * Gets all providers as list
	 *
	 * @since 3.0.5
	 * @return array
	 */
	public static function get_registered_providers_list() {
		$providers_list = Hustle_Providers::get_instance()->get_providers()->to_array();

		// late init properties
		foreach ( $providers_list as $key => $provider ) {
			$providers_list[ $key ]['is_active'] = Hustle_Providers::get_instance()->addon_is_active( $key );
		}

		return $providers_list;
	}

	/**
	 * Get registered addons grouped by connected status
	 *
	 * @since 4.0
	 * @return array
	 */
	public static function get_registered_addons_grouped_by_connected() {
		$addon_list           = self::get_registered_providers_list();
		$connected_addons     = array();
		$not_connected_addons = array();

		// late init properties
		foreach ( $addon_list as $key => $addon ) {

			if ( $addon['is_multi_on_global'] ) {
				// Add instances to connected
				if ( isset( $addon['global_multi_ids'] ) && is_array( $addon['global_multi_ids'] ) ) {
					foreach ( $addon['global_multi_ids'] as $multi_id ) {
						$addon_array = $addon;
						$addon_array['global_multi_id']   = $multi_id['id'];
						$addon_array['multi_name'] = ! empty( $multi_id['label'] ) ? $multi_id['label'] : $multi_id['id'];
						$connected_addons[] = $addon_array;
					}
				}
				$not_connected_addons[] = $addon;
			} else {
				if ( $addon['is_connected'] ) {
					$connected_addons[] = $addon;
				} else {
					$not_connected_addons[] = $addon;
				}
			}
		}

		return array(
			'connected'     => $connected_addons,
			'not_connected' => $not_connected_addons,
		);
	}

	/**
	 * Get the instance of the providers that are connected to a module.
	 *
	 * @since 4.0
	 *
	 * @param $module_id
	 * @return array Hustle_Provider_Abstract[]
	 */
	public static function get_addons_instance_connected_with_module( $module_id ) {
		$providers = array();

		$active_addons_slug = Hustle_Providers::get_instance()->get_activated_addons();

		// TODO: move local list first.

		foreach ( $active_addons_slug as $active_addon_slug ) {
			$provider = self::get_provider_by_slug( $active_addon_slug );
			if ( $provider ) {
				if ( $provider->is_form_connected( $module_id ) ) {
					$class_name = $provider->get_form_settings_class_name();
					$form_settings_instance = new $class_name( $provider, $module_id );
					$form_settings_values = $form_settings_instance->get_form_settings_values();
					if ( !empty( $form_settings_values['selected_global_multi_id'] ) ) {
						$provider->selected_global_multi_id = $form_settings_values['selected_global_multi_id'];
					}
					$providers[] = $provider;
				}
			}
		}

		return $providers;
	}

	/**
	 * Get provider(s) in array format grouped by connected / not connected with $module_id
	 *
	 * Every addon inside this array will be formatted first by @see Hustle_Provider_Abstract::to_array_with_form()
	 *
	 * @since 4.0
	 *
	 * @param $module_id
	 * @return array
	 */
	public static function get_registered_addons_grouped_by_form_connected( $module_id ) {

		$connected_addons     = array();
		$not_connected_addons = array();

		$providers = self::get_registered_providers_list();

		foreach ( $providers as $slug => $data ) {
			if ( ! $data['is_connected'] ) {
				continue;
			}

			$provider = self::get_provider_by_slug( $slug );

			/** @var Hustle_Provider_Abstract $provider */
			if ( $provider->is_allow_multi_on_form() ) {
				$provider_array = $provider->to_array_with_form( $module_id );
				if ( isset( $provider_array['multi_ids'] ) && is_array( $provider_array['multi_ids'] ) ) {
					foreach ( $provider_array['multi_ids'] as $multi_id ) {
						$provider_array['multi_id']   = $multi_id['id'];
						$provider_array['multi_name'] = ! empty( $multi_id['label'] ) ? $multi_id['label'] : $multi_id['id'];
						$connected_addons[] = $provider_array;
					}
				}
				$not_connected_addons[] = $provider->to_array_with_form( $module_id );
			} else {
				if ( $provider->is_connected() && $provider->is_form_connected( $module_id ) ) {
					$connected_addons[] = $provider->to_array_with_form( $module_id );
				} else {
					$not_connected_addons[] = $provider->to_array_with_form( $module_id );
				}

			}
		}

		return array(
			'connected'     => $connected_addons,
			'not_connected' => $not_connected_addons,
		);
	}

	/**
	 * Get registered addons.
	 *
	 * @since 4.0
	 *
	 * @return Hustle_Provider_Abstract[]
	 */
	public static function get_registered_addons() {
		$addons = array();
		$registered_addons = Hustle_Providers::get_instance()->get_providers();

		foreach ( $registered_addons as $slug => $registered_addon ) {
			$addon = self::get_provider_by_slug( $slug );
			if ( $addon instanceof Hustle_Provider_Abstract ) {
				$addons[ $addon->get_slug() ] = $addon;
			}
		}

		return $addons;
	}

	/**
	 * Attach default hooks for provider.
	 *
	 * Call when needed only,
	 * defined in @see Hustle_Provider_Abstract::global_hookable()
	 * and @see Hustle_Provider_Abstract::admin_hookable() on admin side.
	 *
	 * @since 4.0
	 *
	 * @param Hustle_Provider_Abstract $provider
	 */
	public static function maybe_attach_addon_hook( Hustle_Provider_Abstract $provider ) {

		$provider->global_hookable();
		// Hooks that are available on admin only.
		if ( is_admin() ) {
			$provider->admin_hookable();
		}
	}

	/**
	 * Get all activable providers as list
	 *
	 * @since 3.0.5
	 * @return array
	 */
	public static function get_activable_providers_list() {
		$providers_list = self::get_registered_providers_list();
		foreach ( $providers_list as $key => $provider ) {
			if ( ! $providers_list[ $key ]['is_activable'] ) {
				unset( $providers_list[ $key ] );
			}
		}
		return $providers_list;
	}

	/**
	 * Returns provider class by name
	 *
	 * @since 3.0.5
	 * @param $slug string provider Slug
	 * @return bool|Opt_In_Provider_Abstract
	 */
	public static function get_provider_by_slug( $slug ) {
		return Hustle_Providers::get_instance()->get_provider( $slug );
	}

	/**
	 * Return if the passed provider is active or not.
	 *
	 * @since 4.0
	 *
	 * @param string $slug
	 * @return boolean
	 */
	public static function is_provider_active( $slug ) {
		return Hustle_Providers::get_instance()->addon_is_active( $slug );
	}

	/**
	 * Format Form Fields
	 *
	 * @since 4.0
	 *
	 * @param Hustle_Module_Model $module
	 *
	 * @return array
	 */
	public static function addon_format_form_fields( Hustle_Module_Model $module ) {
		$formatted_fields = array();
		$fields = $module->get_form_fields();

		foreach ( $fields as $field ) {
			$ignored_fields = Hustle_Entry_Model::ignored_fields();
			if ( in_array( $field['type'], $ignored_fields, true ) ) {
				continue;
			}

			$formatted_fields[] = $field;
		}

		return $formatted_fields;
	}

	/**
	 * Find addon meta data from entry model that saved on db
	 *
	 * @since 4.0
	 *
	 * @param Hustle_Provider_Abstract $connected_addon
	 * @param Hustle_Entry_Model $entry_model
	 *
	 * @return array
	 */
	public static function find_addon_meta_data_from_entry_model( Hustle_Provider_Abstract $connected_addon, Hustle_Entry_Model $entry_model ) {
		$addon_meta_data = array();
		$addon_meta_data_prefix = 'hustle_provider_' . $connected_addon->get_slug() . '_';
		foreach ( $entry_model->meta_data as $key => $meta_datum ) {
			if ( false !== stripos( $key, $addon_meta_data_prefix ) ) {
				$addon_meta_data[] = array(
					'name'  => str_ireplace( $addon_meta_data_prefix, '', $key ),
					'value' => $meta_datum['value'],
				);
			}
		}

		/**
		 * Filter addon's meta data retrieved from db
		 * @since 4.0
		 */
		$addon_meta_data = apply_filters( 'hustle_provider_meta_data_from_entry_model', $addon_meta_data, $connected_addon, $entry_model, $addon_meta_data_prefix );

		return $addon_meta_data;
	}

	/**
	 * Unset technical data of a form.
	 *
	 * @since 4.0
	 *
	 * @param array $data $_POST
	 *
	 * @return array
	 */
	public static function format_submitted_data_for_addon( $data ) {
		unset( $data['form'], $data['module_id'], $data['uri'], $data['hustle_module_id'], $data['post_id'], $data['gdpr'], $data['recaptcha'], $data['g-recaptcha-response'], $data['hustle_sub_type'] );

		return $data;
	}

}


/**
 * Retrieves the HTML markup given an array of options.
 * Renders it from the file "general/option.php", which is a template.
 * The array should be something like:
 * array(
 * 		"optin_url_label" => array(
 *			"id"    => "optin_url_label",
 *			"for"   => "optin_url",
 *			"value" => "Enter a Webhook URL:",
 *			"type"  => "label",
 *		),
 *		"optin_url_field_wrapper" => array(
 *			"id"        => "optin_url_id",
 *			"class"     => "optin_url_id_wrapper",
 *			"type"      => "wrapper",
 *			"elements"  => array(
 *				"optin_url_field" => array(
 *					"id"            => "optin_url",
 *					"name"          => "api_key",
 *					"type"          => "text",
 *					"default"       => "",
 *					"value"         => "",
 *					"placeholder"   => "",
 *					"class"         => "wpmudev-input_text",
 *				)
 *			)
 *		),
 *	);
 *
 * @since 4.0
 * @uses Opt_In::static_render()
 * @param array $options
 * @return string
 */
if ( ! function_exists( 'hustle_get_html_for_options' ) ) {

	function hustle_get_html_for_options( $options ) {
		$html = '';
		foreach( $options as $key =>  $option ){
			$html .= Opt_In::static_render( 'general/option', array_merge( $option, array( 'key' => $key ) ), true );
		}
		return $html;
	}

}


if ( ! function_exists( 'hustle_get_integration_modal_title_markup' ) ) {

	/**
	 * Return the markup used for the title of Integrations modal.
	 * 
	 * @since 4.0
	 *
	 * @param string $title
	 * @param string $subtitle
	 * @param string $class
	 * @return string
	 */
	function hustle_get_integration_modal_title_markup( $title = '', $subtitle = '', $class = '' ) {

		$html = '<div class="integration-header ' . esc_attr( $class ) . '">';

			if ( ! empty( $title ) ) {
				$html .= '<h3 class="sui-box-title" id="dialogTitle2">' . esc_html( $title ) . '</h3>';
			}

			if ( ! empty( $subtitle ) ){
				$html .= '<p class="sui-description">' . $subtitle . '</p>';
			}

		$html .= '</div>';

		return $html;
	}

}

if ( ! function_exists( 'hustle_get_provider_button_markup' ) ) {

	/**
	 * Return the markup for buttons.
	 * 
	 * @since 4.0
	 *
	 * @param string $value
	 * @param string $class
	 * @param string $action next/prev/close/connect/disconnect. Action that this button triggers.
	 * @param bool $loading whether the button should have the 'loading' markup.
	 * @return string
	 */
	function hustle_get_provider_button_markup( $value = '', $class = '', $action = '', $loading = false, $disabled = false ) {

		if ( ! empty( $action ) ) {
			switch( $action ) {
				case 'next':
					$action_class =	'hustle-provider-next ';
					break;
				case 'prev':
					$action_class =	'hustle-provider-back ';
					break;
				case 'close':
					$action_class =	'hustle-provider-close ';
					break;
				case 'connect':
					$action_class =	'hustle-provider-connect ';
					break;
				case 'disconnect':
					$action_class =	'hustle-provider-disconnect ';
					break;
				case 'disconnect_form':
					$action_class =	'hustle-provider-form-disconnect ';
					break;
				default:
					$action_class = '';
			}
		}

		$inner = $loading ? '<span class="sui-loading-text">' . esc_html( $value ) . '</span><i class="sui-icon-loader sui-loading" aria-hidden="true"></i>' : esc_html( $value );
		// Maybe render this from "options" template.
		$html = '<button type="button" class="sui-button '. esc_attr( $action_class ) . esc_attr( $class ) . '" ' . disabled( $disabled, true, false  ) . '>' . $inner . '</button>';

		return $html;
	}
}

if ( ! function_exists( 'hustle_provider_maybe_log' ) ) {

	/**
	 * Adds an entry to debug log
	 *
	 * By default it will check `HUSTLE_PROVIDER_DEBUG` to decide whether to add the log,
	 * then will check `filters`.
	 *
	 * @since 4.0
	 */
	function hustle_provider_maybe_log() {
		$enabled = ( defined( 'HUSTLE_PROVIDER_DEBUG' ) && HUSTLE_PROVIDER_DEBUG );

		/**
		 * Filter to enable or disable log for Hustle
		 *
		 * @since 4.0
		 *
		 * @param bool $enabled current enabled status
		 */
		$enabled = apply_filters( 'hustle_provider_enable_log', $enabled );

		if ( $enabled ) {
			$args    = func_get_args();
			$message = wp_json_encode( $args );
			if ( false !== $message ) {
				error_log( '[Hustle] ' . $message ); // phpcs:ignore
			}

			
			if ( is_callable( array( 'Opt_In_Utils', 'maybe_log' ) ) ) {
				$args  = array( '[PROVIDER]' );
				$fargs = func_get_args();
				$args  = array_merge( $args, $fargs );
				call_user_func_array( array( 'Opt_In_Utils', 'maybe_log' ), $args );
			}

		}
	}
}
