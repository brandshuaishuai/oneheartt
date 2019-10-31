<?php
class pagesViewWtbp extends viewWtbp {
    public function displayDeactivatePage() {
        $this->assign('GET', reqWtbp::get('get'));
        $this->assign('POST', reqWtbp::get('post'));
        $this->assign('REQUEST_METHOD', strtoupper(reqWtbp::getVar('REQUEST_METHOD', 'server')));
        $this->assign('REQUEST_URI', basename(reqWtbp::getVar('REQUEST_URI', 'server')));
        parent::display('deactivatePage');
    }
}

