<?php
class admin_navControllerWtbp extends controllerWtbp {
	public function getPermissions() {
		return array(
			WTBP_USERLEVELS => array(
				WTBP_ADMIN => array()
			),
		);
	}
}