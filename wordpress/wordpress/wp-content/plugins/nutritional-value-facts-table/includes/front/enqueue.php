<?php

function nvft_enqueue_scripts() {
	wp_register_style ('nvft_style', plugins_url( '/styles/style.css', NUTRITIONAL_VALUE_PLUGIN_URL));
	wp_enqueue_style ('nvft_style');
	wp_register_script('nvft_main', plugins_url ('/assets/js/main.js', NUTRITIONAL_VALUE_PLUGIN_URL ), array(), '1.0.0', true);
	wp_enqueue_script ('nvft_main');
}