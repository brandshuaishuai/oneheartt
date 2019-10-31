<?php
class templatesWtbp extends moduleWtbp {
    protected $_styles = array();
	private $_cdnUrl = '';
	
	public function __construct($d) {
		parent::__construct($d);
		$this->getCdnUrl();	// Init CDN URL
	}
	public function getCdnUrl() {
		if(empty($this->_cdnUrl)) {
			if((int) frameWtbp::_()->getModule('options')->get('use_local_cdn')) {
				$uploadsDir = wp_upload_dir( null, false );
				$this->_cdnUrl = $uploadsDir['baseurl']. '/'. WTBP_CODE. '/';
				if(uriWtbp::isHttps()) {
					$this->_cdnUrl = str_replace('http://', 'https://', $this->_cdnUrl);
				}
				dispatcherWtbp::addFilter('externalCdnUrl', array($this, 'modifyExternalToLocalCdn'));
			} else {
				$this->_cdnUrl = (uriWtbp::isHttps() ? 'https' : 'http'). '://supsystic-42d7.kxcdn.com/';
			}
		}
		return $this->_cdnUrl;
	}
	public function modifyExternalToLocalCdn( $url ) {
		$url = str_replace(
			array('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css'), 
			array($this->_cdnUrl. 'lib/font-awesome'), 
			$url);
		return $url;
	}
    public function init() {
        if (is_admin()) {
			if($isAdminPlugOptsPage = frameWtbp::_()->isAdminPlugOptsPage()) {
				$this->loadCoreJs();
				$this->loadAdminCoreJs();
				$this->loadCoreCss();
				$this->loadChosenSelects();
				frameWtbp::_()->addScript('adminOptionsWtbp', WTBP_JS_PATH. 'admin.options.js', array(), false, true);
				add_action('admin_enqueue_scripts', array($this, 'loadMediaScripts'));
				add_action('init', array($this, 'connectAdditionalAdminAssets'));
			}
			// Some common styles - that need to be on all admin pages - be careful with them
			frameWtbp::_()->addStyle('supsystic-for-all-admin-'. WTBP_CODE, WTBP_CSS_PATH. 'supsystic-for-all-admin.css');
		}else{
			$this->loadCoreJs();
		}
        parent::init();
    }
	public function connectAdditionalAdminAssets() {
		if(is_rtl()) {
			frameWtbp::_()->addStyle('styleWtbp-rtl', WTBP_CSS_PATH. 'style-rtl.css');
		}
	}
	public function loadMediaScripts() {
		if(function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
		}
	}
	public function loadAdminCoreJs() {
		frameWtbp::_()->addScript('jquery-ui-dialog');
		frameWtbp::_()->addScript('jquery-ui-slider');
		frameWtbp::_()->addScript('wp-color-picker');
		frameWtbp::_()->addScript('icheck', WTBP_JS_PATH. 'icheck.min.js');
		$this->loadTooltipster();
	}
	public function loadCoreJs() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addScript('jquery');

			frameWtbp::_()->addScript('commonWtbp', WTBP_JS_PATH. 'common.js');
			frameWtbp::_()->addScript('coreWtbp', WTBP_JS_PATH. 'core.js');

			$ajaxurl = admin_url('admin-ajax.php');
			$jsData = array(
				'siteUrl'					=> WTBP_SITE_URL,
				'imgPath'					=> WTBP_IMG_PATH,
				'cssPath'					=> WTBP_CSS_PATH,
				'loader'					=> WTBP_LOADER_IMG, 
				'close'						=> WTBP_IMG_PATH. 'cross.gif', 
				'ajaxurl'					=> $ajaxurl,
				'options'					=> frameWtbp::_()->getModule('options')->getAllowedPublicOptions(),
				'WTBP_CODE'					=> WTBP_CODE,
				//'ball_loader'				=> WTBP_IMG_PATH. 'ajax-loader-ball.gif',
				//'ok_icon'					=> WTBP_IMG_PATH. 'ok-icon.png',
				'jsPath'					=> WTBP_JS_PATH,
			);
			if(is_admin()) {
				$jsData['isPro'] = frameWtbp::_()->getModule('promo')->isPro();
				$jsData['mainLink'] = frameWtbp::_()->getModule('promo')->getMainLink();
			}
			$jsData = dispatcherWtbp::applyFilters('jsInitVariables', $jsData);
			frameWtbp::_()->addJSVar('coreWtbp', 'WTBP_DATA', $jsData);
			$loaded = true;
		}
	}
	public function loadTooltipster() {
		frameWtbp::_()->addScript('tooltipster', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/tooltipster/jquery.tooltipster.min.js');
		frameWtbp::_()->addStyle('tooltipster', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/tooltipster/tooltipster.css');
	}
	public function loadSlimscroll() {
		frameWtbp::_()->addScript('jquery.slimscroll', frameWtbp::_()->getModule('templates')->getModPath(). 'js/jquery.slimscroll.js');
	}
	public function loadCodemirror() {
		frameWtbp::_()->addStyle('wtbpCodemirror', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/codemirror.css');
		frameWtbp::_()->addStyle('codemirror-addon-hint', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/addon/hint/show-hint.css');
		frameWtbp::_()->addScript('wtbpCodemirror', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/codemirror.js');
		frameWtbp::_()->addScript('codemirror-addon-show-hint', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/addon/hint/show-hint.js');
		frameWtbp::_()->addScript('codemirror-addon-xml-hint', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/addon/hint/xml-hint.js');
		frameWtbp::_()->addScript('codemirror-addon-html-hint', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/addon/hint/html-hint.js');
		frameWtbp::_()->addScript('codemirror-mode-xml', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/mode/xml/xml.js');
		frameWtbp::_()->addScript('codemirror-mode-javascript', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/mode/javascript/javascript.js');
		frameWtbp::_()->addScript('codemirror-mode-css', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/mode/css/css.js');
		frameWtbp::_()->addScript('codemirror-mode-htmlmixed', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/codemirror/mode/htmlmixed/htmlmixed.js');
	}
	public function loadCoreCss() {
		$this->_styles = array(
			'styleWtbp'			=> array('path' => WTBP_CSS_PATH. 'style.css', 'for' => 'admin'), 
			'supsystic-uiWtbp'	=> array('path' => WTBP_CSS_PATH. 'supsystic-ui.css', 'for' => 'admin'), 
			'dashicons'			=> array('for' => 'admin'),
			'bootstrap-alerts'	=> array('path' => WTBP_CSS_PATH. 'bootstrap-alerts.css', 'for' => 'admin'),
			'icheck'			=> array('path' => WTBP_CSS_PATH. 'jquery.icheck.css', 'for' => 'admin'),
			//'uniform'			=> array('path' => WTBP_CSS_PATH. 'uniform.default.css', 'for' => 'admin'),
			'wp-color-picker'	=> array('for' => 'admin'),
		);
		foreach($this->_styles as $s => $sInfo) {
			if(!empty($sInfo['path'])) {
				frameWtbp::_()->addStyle($s, $sInfo['path']);
			} else {
				frameWtbp::_()->addStyle($s);
			}
		}
		$this->loadFontAwesome();
	}
	public function loadJqueryUi() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addStyle('jquery-ui', WTBP_CSS_PATH. 'jquery-ui.min.css');
			frameWtbp::_()->addStyle('jquery-ui.structure', WTBP_CSS_PATH. 'jquery-ui.structure.min.css');
			frameWtbp::_()->addStyle('jquery-ui.theme', WTBP_CSS_PATH. 'jquery-ui.theme.min.css');
			frameWtbp::_()->addStyle('jquery-slider', WTBP_CSS_PATH. 'jquery-slider.css');
			$loaded = true;
		}
	}
	public function loadJqGrid() {
		static $loaded = false;
		if(!$loaded) {
			$this->loadJqueryUi();
			frameWtbp::_()->addScript('jq-grid', $this->_cdnUrl. 'lib/jqgrid/jquery.jqGrid.min.js');
			frameWtbp::_()->addStyle('jq-grid', $this->_cdnUrl. 'lib/jqgrid/ui.jqgrid.css');
			$langToLoad = utilsWtbp::getLangCode2Letter();
			$availableLocales = array('ar','bg','bg1251','cat','cn','cs','da','de','dk','el','en','es','fa','fi','fr','gl','he','hr','hr1250','hu','id','is','it','ja','kr','lt','mne','nl','no','pl','pt','pt','ro','ru','sk','sr','sr','sv','th','tr','tw','ua','vi');
			if(!in_array($langToLoad, $availableLocales)) {
				$langToLoad = 'en';
			}
			frameWtbp::_()->addScript('jq-grid-lang', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/jqgrid/i18n/grid.locale-'. $langToLoad. '.js');
			$loaded = true;
		}
	}
	public function loadFontAwesome() {
		frameWtbp::_()->addStyle('font-awesomeWtbp', dispatcherWtbp::applyFilters('externalCdnUrl', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'));
	}
	public function loadChosenSelects() {
		frameWtbp::_()->addStyle('jquery.chosen', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/chosen/chosen.min.css');
		frameWtbp::_()->addScript('jquery.chosen', frameWtbp::_()->getModule('templates')->getModPath(). 'lib/chosen/chosen.jquery.min.js');
	}
	public function loadDatePicker() {
		frameWtbp::_()->addScript('jquery-ui-datepicker');
	}
	public function loadJqplot() {
		static $loaded = false;
		if(!$loaded) {
			$jqplotDir = frameWtbp::_()->getModule('templates')->getModPath(). 'lib/jqplot/';

			frameWtbp::_()->addStyle('jquery.jqplot', $jqplotDir. 'jquery.jqplot.min.css');

			frameWtbp::_()->addScript('jplot', $jqplotDir. 'jquery.jqplot.min.js');
			frameWtbp::_()->addScript('jqplot.canvasAxisLabelRenderer', $jqplotDir. 'jqplot.canvasAxisLabelRenderer.min.js');
			frameWtbp::_()->addScript('jqplot.canvasTextRenderer', $jqplotDir. 'jqplot.canvasTextRenderer.min.js');
			frameWtbp::_()->addScript('jqplot.dateAxisRenderer', $jqplotDir. 'jqplot.dateAxisRenderer.min.js');
			frameWtbp::_()->addScript('jqplot.canvasAxisTickRenderer', $jqplotDir. 'jqplot.canvasAxisTickRenderer.min.js');
			frameWtbp::_()->addScript('jqplot.highlighter', $jqplotDir. 'jqplot.highlighter.min.js');
			frameWtbp::_()->addScript('jqplot.cursor', $jqplotDir. 'jqplot.cursor.min.js');
			frameWtbp::_()->addScript('jqplot.barRenderer', $jqplotDir. 'jqplot.barRenderer.min.js');
			frameWtbp::_()->addScript('jqplot.categoryAxisRenderer', $jqplotDir. 'jqplot.categoryAxisRenderer.min.js');
			frameWtbp::_()->addScript('jqplot.pointLabels', $jqplotDir. 'jqplot.pointLabels.min.js');
			frameWtbp::_()->addScript('jqplot.pieRenderer', $jqplotDir. 'jqplot.pieRenderer.min.js');
			$loaded = true;
		}
	}
	public function loadSortable() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addScript('jquery-ui-core');
			frameWtbp::_()->addScript('jquery-ui-widget');
			frameWtbp::_()->addScript('jquery-ui-mouse');

			frameWtbp::_()->addScript('jquery-ui-draggable');
			frameWtbp::_()->addScript('jquery-ui-sortable');
			$loaded = true;
		}
	}
	public function loadMagicAnims() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addStyle('magic.anim', frameWtbp::_()->getModule('templates')->getModPath(). 'css/magic.min.css');
			$loaded = true;
		}
	}
	public function loadCssAnims() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addStyle('animate.styles', frameWtbp::_()->getModule('templates')->getModPath(). 'css/magic.min.css');
			$loaded = true;
		}
	}
	public function loadBootstrapSimple() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addStyle('bootstrap-simple', WTBP_CSS_PATH. 'bootstrap-simple.css');
			$loaded = true;
		}
	}
	public function loadGoogleFont( $font ) {
		static $loaded = array();
		if(!isset($loaded[ $font ])) {
			frameWtbp::_()->addStyle('google.font.'. str_replace(array(' '), '-', $font), 'https://fonts.googleapis.com/css?family='. urlencode($font));
			$loaded[ $font ] = 1;
		}
	}
	public function loadBxSlider() {
		static $loaded = false;
		if(!$loaded) {
			frameWtbp::_()->addStyle('bx-slider', WTBP_JS_PATH. 'bx-slider/jquery.bxslider.css');
			frameWtbp::_()->addScript('bx-slider', WTBP_JS_PATH. 'bx-slider/jquery.bxslider.min.js');
			$loaded = true;
		}
	}
}
