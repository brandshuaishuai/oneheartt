<?php
class admin_navViewWtbp extends viewWtbp {
	public function getBreadcrumbs() {
		$this->assign('breadcrumbsList', dispatcherWtbp::applyFilters('mainBreadcrumbs', $this->getModule()->getBreadcrumbsList()));
		return parent::getContent('adminNavBreadcrumbs');
	}
}
