<?php
class wootablepressWtbp extends moduleWtbp {
	public function init() {
		if(is_admin()) {
			add_action('admin_notices', array($this, 'showAdminErrors'));
		}
		dispatcherWtbp::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		add_shortcode(WTBP_SHORTCODE, array($this, 'render'));
	}
	public function addAdminTab($tabs) {
		$tabs[ $this->getCode(). '#wtbpadd' ] = array(
			'label' => __('Add New Table', WTBP_LANG_CODE), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-plus-circle', 'sort_order' => 10, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode(). '_edit' ] = array(
			'label' => __('Edit', WTBP_LANG_CODE), 'callback' => array($this, 'getEditTabContent'), 'sort_order' => 20, 'child_of' => $this->getCode(), 'hidden' => 1, 'add_bread' => $this->getCode(),
		);
		$tabs[ $this->getCode() ] = array(
			'label' => __('Show All Tables', WTBP_LANG_CODE), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-list', 'sort_order' => 20, //'is_main' => true,
		);
		return $tabs;
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
	public function getEditTabContent() {
		$id = reqWtbp::getVar('id', 'get');
		return $this->getView()->getEditTabContent( $id );
	}
	public function getEditLink($id, $tableTab = '') {
		$link = frameWtbp::_()->getModule('options')->getTabUrl( $this->getCode(). '_edit' );
		$link .= '&id='. $id;
		if(!empty($tableTab)) {
			$link .= '#'. $tableTab;
		}
		return $link;
	}
	public function render($params){
		return $this->getView()->renderHtml($params);
	}
	public function showAdminErrors() {
		// check WooCommerce is installed and activated
		if(!$this->isWooCommercePluginActivated()) {
			// WooCommerce install url
			$wooCommerceInstallUrl = add_query_arg(
				array(
					's' => 'WooCommerce',
					'tab' => 'search',
					'type' => 'term',
				),
				admin_url( 'plugin-install.php' )
			);
			$tableView = $this->getView();
			$tableView->assign('errorMsg',
				$this->translate('For work with "')
				. WTBP_WP_PLUGIN_NAME
				. $this->translate('" plugin, You need to install and activate <a target="_blank" href="' . $wooCommerceInstallUrl . '">WooCommerce</a> plugin')
			);
			// check current module
			if(isset($_GET['page']) && $_GET['page'] == WTBP_SHORTCODE) {
				// show message
				echo $tableView->getContent('showAdminNotice');
			}
		}
	}
	public function isWooCommercePluginActivated() {
		return class_exists('WooCommerce');
	}

	public function unserialize($data, $isReplaceCallback = true) {
		if ($isReplaceCallback) {
			$data = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {
	            return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
	        }, $data );
		}

		if ( @unserialize(base64_decode($data)) !== false ) {
			return unserialize(base64_decode($data));
		} else {
			return unserialize($data);
		}
    }
}
