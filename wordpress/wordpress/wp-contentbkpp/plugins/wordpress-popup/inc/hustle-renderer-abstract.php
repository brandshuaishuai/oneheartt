<?php

/**
 * Class Hustle_Renderer_Abstract
 * @since 4.0
 */
abstract class Hustle_Renderer_Abstract {

	const SSHARE_WIDGET_CSS_CLASS = 'hustle_sshare_module_widget_wrap';
	const SSHARE_SHORTCODE_CSS_CLASS = 'hustle_sshare_module_shortcode_wrap';
	const SHORTCODE_TRIGGER_CSS_CLASS = 'hustle_module_shortcode_trigger';

	/**
	 * A unique ID for the current module.
	 *
	 * @var array
	 */
	protected static $render_ids = array();

	/**
	 * Module sub_type.
	 * Only for embedded and social sharing modules.
	 * @since 4.0
	 * @var string
	 */
	protected $sub_type = null;

	/**
	 * Whether the render is for a preview.
	 * @since 4.0
	 * @var boolean
	 */
	public static $is_preview = false;

	public function __construct() {
		$this->is_admin = is_admin();
	}

	//abstract public function display( Hustle_Module_Model $module, $sub_type = null, $custom_classes = '' );

	/**
	 * Generate an ID for the current module
	 * represented as an integer, starting from 0.
	 *
	 * @since 4.0
	 *
	 * @param $id
	 */
	public function generate_render_id( $id ) {
		if ( ! isset( self::$render_ids[ $id ] ) ) {
			self::$render_ids[ $id ] = 0;
		} else {
			self::$render_ids[ $id ] ++;
		}
	}

	/**
	 * Return the markup of the module.
	 *
	 * @since 4.0
	 *
	 * @param Hustle_Module_Model $module
	 * @param string $sub_type The sub_type for embedded and social sharing modules: widget, shortcode, etc.
	 * @param string $custom_classes
	 * @param bool $is_preview
	 */
	public function display( Hustle_Module_Model $module, $sub_type = null, $custom_classes = '', $is_preview = false ) {

		$this->module = $module;
		$id = $this->module->id;
		$this->sub_type = $sub_type;
		$this->generate_render_id( $id );

		self::$is_preview = $is_preview;

		if ( $is_preview || $this->module->is_allowed_to_display( $module->module_type, $sub_type ) ) {

			// Render form
			echo $this->get_module( $sub_type, $custom_classes ); // wpcs: xss ok.

			add_action( 'wp_footer', array( $this, 'print_styles' ), 9999 );
		}

	}

	/**
	 * Return markup
	 *
	 * @since 4.0
	 *
	 * @param string $sub_type
	 * @param string $custom_classes
	 *
	 * @return mixed|void
	 */
	public function get_module( $sub_type = null, $custom_classes = '' ) {
		$html = '';
		$post_id = $this->get_post_id();
		$id = $this->module->module_id;
		$module_type = $this->module->module_type;
		//if rendered on Preview, the array is empty and sometimes PHP notices show up
		if ( $this->is_admin && ( empty( self::$render_ids ) || ! $id ) ) {
			self::$render_ids[ $id ] = 0;
		}
		$render_id = self::$render_ids[ $id ];

		// TODO: validate sub_types
		$data_type = is_null( $sub_type ) ? $this->module->module_type : $sub_type;

		do_action( 'hustle_before_module_render', $render_id, $this, $post_id, $sub_type );

		$html .= $this->get_wrapper_main( $sub_type, $custom_classes );

			$html .= $this->get_overlay_mask();

				$html .= $this->get_wrapper_content( $sub_type );

				$html .= $this->get_module_body( $sub_type );

			$html .= '</div>'; // Closing wrapper content.

		$html .= '</div>'; // Closing wrapper main.

		$post_id   = $this->get_post_id();
		/**
		 * Tracking
		 */
		$form_view = Hustle_Tracking_Model::get_instance();
		$post_id   = $this->get_post_id();

		/**
		 * Output
		 */
		$html = apply_filters( 'hustle_render_module_markup', $html, $this, $render_id, $sub_type, $post_id );
		do_action( 'hustle_after_module_render', $this, $render_id, $post_id, $sub_type );
		return $html;
	}

	/**
	 * Return post ID
	 *
	 * @since 4.0
	 * @return int|string|bool
	 */
	public function get_post_id() {
		return get_queried_object_id();
	}

	public function print_styles( $is_preview = false ) {

		$disable_styles = apply_filters( 'hustle_disable_front_styles', false, $this->module, $this );

		if ( ! $disable_styles ) {
			$style = $this->module->get_decorated()->get_module_styles( $this->module->module_type, $is_preview );
			// TODO: if this is printed for each embedded/ssharing module, we should add the render-id in this ID to keep it unique.
			echo '<style type="text/css" id="hustle-module-' . $this->module->id . '-styles" class="hustle-module-styles">' . wp_strip_all_tags( $style ) . '</style>'; // wpcs xss: ok.
		}

	}


	public static function ajax_load_module() {

		// TODO: check nonce.
		// TODO: maybe we don't need to pass "type" in the request if we always pass the id.

		$data = $_REQUEST; // phpcs:ignore
		$id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
		$preview_data = filter_input( INPUT_POST, 'previewData', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
		$type = isset( $data['type'] ) ? $data['type'] : 0;

		if ( ! $id && empty( $preview_data ) ) {
			wp_send_json_error( __( 'Invalid data', Opt_In::TEXT_DOMAIN ) );
		}

		if ( empty( $type ) ) {
			wp_send_json_error( __( 'Invalid module type', Opt_In::TEXT_DOMAIN ) );
		}

		$module = Hustle_Module_Collection::instance()->return_model_from_id( $id );

		$view = $module->get_renderer();

		// This might change later on. We're only using the ajax for preview at the moment.
		$is_preview = true;

		do_action( 'hustle_before_ajax_display', $module, $is_preview );

		$response = $view->ajax_display( $module, $preview_data, $is_preview );

		$response = apply_filters( 'hustle_ajax_display_response', $response, $module, $is_preview );

		do_action( 'hustle_after_ajax_display', $module, $is_preview, $response );

		wp_send_json_success( $response );
	}

	protected function get_overlay_mask() {
		return '';
	}
}
