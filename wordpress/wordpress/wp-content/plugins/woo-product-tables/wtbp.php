<?php
/**
 * Plugin Name: Woo Product Table
 * Plugin URI: https://woobewoo.com/plugins/table-woocommerce-plugin/
 * Description: Post your product easy in tables
 * Version: 1.1.2
 * Author: woobewoo
 * Author URI: https://woobewoo.com
 * Text Domain: woo-product-tables
 * Domain Path: /languages
 * WC requires at least: 3.4.0
 * WC tested up to: 3.6.5
 **/
	/**
	 * Base config constants and functions
	 */
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'config.php');
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'functions.php');
	/**
	 * Connect all required core classes
	 */
    importClassWtbp('dbWtbp');
    importClassWtbp('installerWtbp');
    importClassWtbp('baseObjectWtbp');
    importClassWtbp('moduleWtbp');
    importClassWtbp('modelWtbp');
    importClassWtbp('viewWtbp');
    importClassWtbp('controllerWtbp');
    importClassWtbp('helperWtbp');
    importClassWtbp('dispatcherWtbp');
    importClassWtbp('fieldWtbp');
    importClassWtbp('tableWtbp');
    importClassWtbp('frameWtbp');
	/**
	 * @deprecated since version 1.0.1
	 */
    importClassWtbp('langWtbp');
    importClassWtbp('reqWtbp');
    importClassWtbp('uriWtbp');
    importClassWtbp('htmlWtbp');
    importClassWtbp('responseWtbp');
    importClassWtbp('fieldAdapterWtbp');
    importClassWtbp('validatorWtbp');
    importClassWtbp('errorsWtbp');
    importClassWtbp('utilsWtbp');
    importClassWtbp('modInstallerWtbp');
	importClassWtbp('installerDbUpdaterWtbp');
	importClassWtbp('dateWtbp');
	/**
	 * Check plugin version - maybe we need to update database, and check global errors in request
	 */
    installerWtbp::update();
    errorsWtbp::init();
    /**
	 * Start application
	 */
    frameWtbp::_()->parseRoute();
    frameWtbp::_()->init();
    frameWtbp::_()->exec();

	//var_dump(frameWtbp::_()->getActivationErrors()); exit();
