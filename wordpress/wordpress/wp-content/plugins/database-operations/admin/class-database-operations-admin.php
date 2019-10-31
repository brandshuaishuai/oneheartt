<?php

/**
 */
class Database_Operations_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.5.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.5.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.5.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.5.0
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
		 * class
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/database-operations-admin.css', array(), $this->version, 'all' );

	wp_enqueue_style( 'db_wp_charts_style', plugins_url( 'css/db_wp_charts.css', __FILE__ ) );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-chartjs', plugins_url( 'js/Chart.min.js', __FILE__ ), array( 'jquery' ), '2.3.0', true );
			wp_enqueue_script( 'db_wp_charts_script', plugins_url( 'js/db_wp_charts.js', __FILE__ ), array( 'jquery', 'jquery-chartjs' ), PWPC_CHARTS_VERSION, true );
            
            
wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/database-operations-admin.js', array( 'jquery' ), $this->version, false );
	wp_enqueue_script( db_wp_charts_init, plugin_dir_url( __FILE__ ) . 'js/db_wp_charts_init.js', array( 'jquery' ), $this->version, false );
	wp_enqueue_script( db_wp_charts_admin, plugin_dir_url( __FILE__ ) . 'js/db_wp_charts_admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.5.0
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
         
wp_register_script( 'db_wp_charts_init_script', plugins_url( 'js/db_wp_charts_init.js', __FILE__ ), array( 'jquery', 'jquery-chartjs', 'db_wp_charts_script' ), PWPC_CHARTS_VERSION, false );
           wp_register_script( 'db_wp_charts_admin', plugins_url( 'js/db_wp_charts_admin.js', __FILE__ ), array( 'jquery', 'jquery-chartjs', 'db_wp_charts_script' ), PWPC_CHARTS_VERSION, false );
           wp_register_script( 'db_wp_charts', plugins_url( 'js/db_wp_charts.js', __FILE__ ), array( 'jquery', 'jquery-chartjs', 'db_wp_charts_script' ), PWPC_CHARTS_VERSION, false );
			//wp_localize_script( 'db_wp_charts_init_script', 'pwpc_params', $this->pwpcharts_init_array );
			wp_enqueue_script( 'db_wp_charts_init_script' );
			wp_enqueue_script( 'db_wp_charts_admin_script' );		        wp_enqueue_script( 'db_wp_charts' );
	
	}
    
    public function register_cpt_database_operations()
	{
		$labels = array(
            'name'                => _x( 'Database Operations', 'Post Type General Name', 'database-operations' ),
            'singular_name'       => _x( 'Database Operations', 'Post Type Singular Name', 'database-operations' ),
            'menu_name'           => __( 'Database Operations', 'database-operations' ),
            'name_admin_bar'      => __( 'Database Operations', 'database-operations' ),
            'parent_item_colon'   => __( 'Parent Database Operations:', 'database-operations' ),
            'all_items'           => __( 'All Database Operations', 'database-operations' ),
            'add_new_item'        => __( 'Add New', 'database-operations' ),
            'add_new'             => __( 'Add New', 'database-operations' ),
            'new_item'            => __( 'New Database Operations', 'database-operations' ),
            'edit_item'           => __( 'Edit Database Operations', 'database-operations' ),
            'update_item'         => __( 'Update Database Operations', 'database-operations' ),
            'view_item'           => __( 'View Database Operations', 'database-operations' ),
            'search_items'        => __( 'Search Database Operations', 'database-operations' ),
            'not_found'           => __( 'Not found', 'database-operations' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'database-operations' ),
        );
        $args = array(
            'label'               => __( '', 'database-operations' ),
            'description'         => __( 'Another Flexible Database Operations', 'database-operations' ),      
			'labels'              => $labels,     
            'supports'            => array('title'),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 10,
            'menu_icon'           => 'dashicons-vault',
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
        );
        register_post_type( 'ct_ms', apply_filters( 'ct_ms_register_arguments', $args) );
        
	}
    
    
    public function add_meta_box() {
		add_meta_box(
			'database_operations_details',
			__( 'Database Operations', 'database-operations' ),
			array($this,'meta_box_print_database_operations_details'),
			'ct_ms'
		);        
	}
    
    public function meta_box_print_database_operations_details( $post ) {
	
		require_once plugin_dir_path( __FILE__ ). 'views/database-operations-admin-display.php';
	}
    
    public function save_meta_box( $post_id ) {
 
    /* If we're not working with a 'post' post type or the user doesn't have permission to save,
     * then we exit the function.
     */
	 	
		if ( ! $this->is_valid_post_type() || ! $this->user_can_save( $post_id, 'database_operations_nonce', 'database_operations_save' ) ) {
			return;
		}	
      if(empty($_POST['charts'])){  
		$res = $this->performQuery($_POST);

        } else {
        if($_POST["pwpc_types"] == ""){
			    $res = '<h4> Select A Chart Type And Legend</h4>';
			    //return $res;
			} else {
     $this->performChartQuery($_POST);
   $res='<div id="tesr'.$post_id.'" style="overflow:auto;"></div>';
	$res .='
		<script >
     
	var dts = {}, datas = {}, param = [], titles_arr='."'".$_POST["titles"]."'".', values_arr='."'".$_POST["values"]."'".', data = {}, key = 0, uniqueid = "";
		
		param[ \'style\' ] = '."'".$_POST["pwpc_types"]."'".';
		
		param[ \'max\' ] = "";

		param[ \'legend\' ] = '."'".$_POST["pwpc_legend"]."'".';

		datas[ \'style\' ] = param;
		//titles_array = ["Books","Pencils","Envelope s","Pens","Handkerchief","Crayons"];
      titles_array = titles_arr.split(" ");
		//values_array = ["3","7","12","32","53","2"];
       values_array = values_arr.split(" ");
      
			jQuery.each( titles_array, function( key, value ) {
				dts[ key ] = {
					answer: value,
					count: parseFloat( values_array[ key ] )
				}
		})
		datas[ \'datas\' ]= {
			0: dts
		}
		uniqueid = Math.floor(Math.random() * 26) + Date.now();
		jQuery( "#tesr'.$post_id.'" ).html( \'<div id="pwp-charts-\' + uniqueid + \'" class="admin-chart"><canvas style="width: 500px; height: 100%;"></canvas></div>\' );
		jQuery( "#pwp-charts-" + uniqueid ).pmsresults({ "style": datas.style, "datas": datas.datas }); 
	
		</script>';
		}
        }

		$_POST["ct_ms_content"] = $res;
		foreach($_POST as $key => $value)
		{
			//if (0 === strpos($key, "ct_ms_")) {
				update_post_meta( $post_id, $key, $value );
           
			//}
		}	
     
	}
	
public function performChartQuery($post){
       	global $wpdb;
		$mytables;
		$db_op_tb1 = sanitize_text_field($post['tb1']); 
		$db_op_tb2 = sanitize_text_field($post['tb2']); 
        if($db_op_tb1 != "")
        {
           $db_op = $db_op_tb1;
        }else {
           $db_op = $db_op_tb2;
        }

		$sql =  "
				SELECT * FROM $db_op";
				$mytables = $wpdb->get_results($sql);
             $titles = [];
             $values = [];
             $x = 1;
	foreach ( $mytables as $mytable ) 
		{
			foreach ($mytable as $t)
			{
            if($x%2!=0){
            $tval = $t;
            array_push($titles, $tval);
             
			  $x = $x + 1;
			} else {
              $tval = $t;
    array_push($values, $tval);
    $x = $x + 1;
			}
			}
			
	}
    $_POST["titles"] = implode(" ",$titles);
    $_POST["values"] = implode(" ",$values);
	return $post;
    }
    
    public function performQuery($post){
       	global $wpdb;
		$mytables;
		$db_op_tb1 = sanitize_text_field($post['tb1']); 
		$db_op_tb2 = sanitize_text_field($post['tb2']); 
        $qryop = sanitize_text_field($post['qryop']); 
			
			if($db_op_tb1 == "" && $db_op_tb2 == ""){
			    $res = '<h4> Select At Least A Table</h4>';
			    return $res;
			}
			else if ($db_op_tb1 == "" && $db_op_tb2 != ""){	
               $sql =  "
				SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='{$db_op_tb2}'";
				$db_op_cols = $wpdb->get_col($sql);
				$sql =  "
				SELECT * FROM $db_op_tb2";
				$mytables = $wpdb->get_results($sql);
			} else if ($db_op_tb2 == "" && $db_op_tb1 != ""){
				$sql =  "
				SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='{$db_op_tb1}'";
				$db_op_cols = $wpdb->get_col($sql);
				$sql =  "
				SELECT * FROM $db_op_tb1";
				$mytables = $wpdb->get_results($sql);
			} else {
            if($qryop == ''){
               $qryop = 'UNION';
            }
				//$repl = str_replace('wp_', '', $db_op_tb1);
				//$repl1 = str_replace('wp_', '', $db_op_tb2);
				$query = "
					SELECT * 
					FROM {$db_op_tb1} {$qryop}
					SELECT * 
					FROM {$db_op_tb2}";
				$mytables = $wpdb->get_results($query);
				if (empty($mytables)) {
					$res = ' <h4>To use this UNION clause, each SELECTED TABLE must have</br>
								
								- The same number of columns selected</br>
								- The same number of column expressions</br>
								- The same data type and</br>
								- Have them in the same order</br>
								But they need not have to be in the same length.</h4>';
								return $res;
				}
				else {
			}
		}
        
	$cols = $db_op_cols;
	$mytables = $mytables;
	$res = '<div style="overflow:auto;"><table  class="table table-hover" > <h4> Table(s) ' . $db_op_tb1. ' / ' . $db_op_tb2.'</h4><thead class="thead-light"><tr class="table-info">';
	if($cols != ""){
	foreach ($cols as $t)
		{
			$res .= '<th scope="col">'.$t.'</th>';
		}
	}
	$res .= '</tr></thead>';
	foreach ( $mytables as $mytable ) 
		{
			$res .= '<tbody> <tr class="alternate">';
			foreach ($mytable as $t)
			{
				$res .= '<td class="column-columnname"> '.$t. '</td> ';
			}
			$res .= '</tbody> </tr>';
	}
		$res .= '</table></div>'; 
        $mytables = "";
        $cols = "";
        $db_op_tb1 = "";
        $db_op_tb2 = "";
        $qryop = "";
        return $res;
    }
    
    /**public function email_admin( $location ) {   
       $time = date( "F jS Y, H:i", time()+25200 );
       $ban = "#$time\r\n$location\r\n"; 
       // $file = plugin_dir_path( __FILE__ ) . '/justlog.txt'; 
       $file = dirname(__FILE__) . '/justlog.txt';
       $open = fopen( $file, "a" ); 
       $write = fputs( $open, $ban ); 
    fclose( $open );
    }**/
	
	private function is_valid_post_type() {
		
		return ! empty( $_POST['post_type'] ) && 'ct_ms' == $_POST['post_type'];
	}
	
	private function user_can_save( $post_id, $nonce_action, $nonce_id ) {
 
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ $nonce_action ] ) && wp_verify_nonce( $_POST[ $nonce_action ], $nonce_id ) );
	 
		// Return true if the user is able to save; otherwise, false.
		return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
	 
	}
    
    public function database_operations_columns($columns) {		
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title','database-operations' ),
			'shortcode' => __( 'Shortcode','database-operations' ),
			'date' => __( 'Date','database-operations' )
		);	
		return $columns;
	}
	
	
	public function database_operations_columns_data( $column, $post_id ) {
		global $post;
	
		switch( $column ) {
	
			/* If displaying the 'impressions' column. */
			case 'shortcode' :
                
					printf( __( '[database_operations id="%s"]' ), $post_id );
	
				break;
			
	
			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}
    
}