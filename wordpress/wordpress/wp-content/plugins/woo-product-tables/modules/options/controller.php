<?php
class optionsControllerWtbp extends controllerWtbp {
	public function saveGroup() {
		$res = new responseWtbp();
		if($this->getModel()->saveGroup(reqWtbp::get('post'))) {
			$res->addMessage(__('Done', WTBP_LANG_CODE));
		} else
			$res->pushError ($this->getModel('options')->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			WTBP_USERLEVELS => array(
				WTBP_ADMIN => array('saveGroup')
			),
		);
	}
}

