<?php

/*
*/
class Database_Operations_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Database_Operations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Database_Operations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/database_operations-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Database_Operations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Database_Operations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/database_operations-public.js', array( 'jquery' ), $this->version, false );

wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/database-operations-admin.css', array(), $this->version, 'all' );

	wp_enqueue_style( 'db_wp_charts_style', plugins_url( 'css/db_wp_charts.css', __FILE__ ) );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-chartjs', plugins_url( 'js/Chart.min.js', __FILE__ ), array( 'jquery' ), '2.3.0', true );
			wp_enqueue_script( 'db_wp_charts_script', plugins_url( 'js/db_wp_charts.js', __FILE__ ), array( 'jquery', 'jquery-chartjs' ), PWPC_CHARTS_VERSION, true );
                       
wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/database-operations-admin.js', array( 'jquery' ), $this->version, false );
	wp_enqueue_script( db_wp_charts_init, plugin_dir_url( __FILE__ ) . 'js/db_wp_charts_init.js', array( 'jquery' ), $this->version, false );
	wp_enqueue_script( db_wp_charts_admin, plugin_dir_url( __FILE__ ) . 'js/db_wp_charts_admin.js', array( 'jquery' ), $this->version, false );


wp_register_script( 'db_wp_charts_init_script', plugins_url( 'js/db_wp_charts_init.js', __FILE__ ), array( 'jquery', 'jquery-chartjs', 'db_wp_charts_script' ), PWPC_CHARTS_VERSION, false );
           wp_register_script( 'db_wp_charts_admin', plugins_url( 'js/db_wp_charts_admin.js', __FILE__ ), array( 'jquery', 'jquery-chartjs', 'db_wp_charts_script' ), PWPC_CHARTS_VERSION, false );
           wp_register_script( 'db_wp_charts', plugins_url( 'js/db_wp_charts.js', __FILE__ ), array( 'jquery', 'jquery-chartjs', 'db_wp_charts_script' ), PWPC_CHARTS_VERSION, false );
			wp_localize_script( 'db_wp_charts_init_script', 'pwpc_params', $this->pwpcharts_init_array );
			wp_enqueue_script( 'db_wp_charts_init_script' );
			wp_enqueue_script( 'db_wp_charts_admin_script' );		        wp_enqueue_script( 'db_wp_charts' );

	}
    
    public function register_database_operations() {
        add_shortcode( 'database_operations', array( $this, 'display_databaseoperations') );
    }
    
    public function display_databaseoperations( $attributes ) {
        extract( shortcode_atts( array(
            'id' => 'null',
        ), $attributes ) );
        $content = get_post_meta( $id ,"ct_ms_content", true);
        //$content = get_post_meta( $id , $attributes, true );
        //return htmlentities($content);
    return $content;
    }
}