<?php
class mailControllerWtbp extends controllerWtbp {
	public function testEmail() {
		$res = new responseWtbp();
		$email = reqWtbp::getVar('test_email', 'post');
		if($this->getModel()->testEmail($email)) {
			$res->addMessage(__('Now check your email inbox / spam folders for test mail.'));
		} else 
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function saveMailTestRes() {
		$res = new responseWtbp();
		$result = (int) reqWtbp::getVar('result', 'post');
		frameWtbp::_()->getModule('options')->getModel()->save('mail_function_work', $result);
		$res->ajaxExec();
	}
	public function saveOptions() {
		$res = new responseWtbp();
		$optsModel = frameWtbp::_()->getModule('options')->getModel();
		$submitData = reqWtbp::get('post');
		if($optsModel->saveGroup($submitData)) {
			$res->addMessage(__('Done', WTBP_LANG_CODE));
		} else
			$res->pushError ($optsModel->getErrors());
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			WTBP_USERLEVELS => array(
				WTBP_ADMIN => array('testEmail', 'saveMailTestRes', 'saveOptions')
			),
		);
	}
}
