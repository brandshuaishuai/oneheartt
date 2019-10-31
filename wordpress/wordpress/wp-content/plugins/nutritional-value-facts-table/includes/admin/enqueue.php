<?php
function nvft_admin_enqueue(){
	
	global $typenow;
	if ( $typenow !== 'nutritional_value') {
		// Kijkt of deze variabel is set to post type
	return;	
	}
	wp_register_style ('nvft_bootstrap', plugins_url('/assets/css/bootstrap.css', NUTRITIONAL_VALUE_PLUGIN_URL) );
	wp_enqueue_style ('nvft_bootstrap' );
  
}

?>