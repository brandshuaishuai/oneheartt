<?php
class mailViewWtbp extends viewWtbp {
	public function getTabContent() {
		frameWtbp::_()->getModule('templates')->loadJqueryUi();
		frameWtbp::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		
		$this->assign('options', frameWtbp::_()->getModule('options')->getCatOpts( $this->getCode() ));
		$this->assign('testEmail', frameWtbp::_()->getModule('options')->get('notify_email'));
		return parent::getContent('mailAdmin');
	}
}
