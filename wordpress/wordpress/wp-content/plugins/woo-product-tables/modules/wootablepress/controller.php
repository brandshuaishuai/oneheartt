<?php
class wootablepressControllerWtbp extends controllerWtbp {

    protected $_code = 'wootablepress';

	protected function _prepareTextLikeSearch($val) {
		$query = '(title LIKE "%'. $val. '%"';
		if(is_numeric($val)) {
			$query .= ' OR id LIKE "%'. (int) $val. '%"';
		}
		$query .= ')';
		return $query;
	}
	public function _prepareListForTbl($data){
		foreach($data as $key=>$row){
			$id = $row['id'];
			$shortcode = "[".WTBP_SHORTCODE." id=".$id."]";
			$showPrewiewButton = "<button data-id='".$id."' data-shortcode='".$shortcode."' class='button button-primary button-prewiew' style='margin-top: 1px;'>".__('Prewiew', WTBP_LANG_CODE)."</button>";
			$titleUrl = "<a href=".$this->getModule()->getEditLink( $id ).">".$row['title']." <i class='fa fa-fw fa-pencil'></i></a>";
			$data[$key]['shortcode'] = $shortcode;
			$data[$key]['rewiew'] = $showPrewiewButton;
			$data[$key]['title'] = $titleUrl;
		}
		return $data;
	}

	public function getSearchProducts(){
		$params = reqWtbp::get('post');
		$html = $this->getView()->getSearchProducts($params);
		echo json_encode($html);
		die();
	}

    public function getProductContent(){
        $res = new responseWtbp();
        $params = reqWtbp::get('post');

        $frontend = !empty($params['frontend']) ? true : false;
        $htmlAndIds = $this->getView()->getProductContentBackend($params, $frontend);

        if(!empty($htmlAndIds)){
            $res->addMessage(__('Done', WTBP_LANG_CODE));
            $res->setHtml($htmlAndIds['html']);
            $res->addData(array('ids' => $htmlAndIds['ids'], 'filter' => $htmlAndIds['filter'], 'css' => $htmlAndIds['css']));
            if(!empty($params['prewiew'])){
                $res->addData(array('settings' => $htmlAndIds['settings']));
            }
        }else{
            $res->addMessage(__('Post not exist!', WTBP_LANG_CODE));
        }
        return $res->ajaxExec();
    }

    public function save(){
        $res = new responseWtbp();
        $data = reqWtbp::get('post');
        if(!isset($data['id']) && !isset($data['settings'])) {
        	$data['settings'] = array('productids' => $this->getView()->calcProductIds($data, true), 'header_show' => 1);
        }
        if(($id = $this->getModel('wootablepress')->save($data)) != false) {
            $res->addMessage(__('Done', WTBP_LANG_CODE));
            $res->addData('edit_link', $this->getModule()->getEditLink( $id ));
        } else
            $res->pushError ($this->getModel('wootablepress')->getErrors());
        return $res->ajaxExec();
    }

    public function cloneTable(){
        $res = new responseWtbp();
        if(($id = $this->getModel('wootablepress')->cloneTable(reqWtbp::get('post'))) != false) {
            $res->addMessage(__('Done', WTBP_LANG_CODE));
            $res->addData('edit_link', $this->getModule()->getEditLink($id));
        } else
            $res->pushError($this->getModel('wootablepress')->getErrors());
        return $res->ajaxExec();
    }

    public function deleteByID(){
        $res = new responseWtbp();

        if($this->getModel('wootablepress')->delete(reqWtbp::get('post')) != false){
            $res->addMessage(__('Done', WTBP_LANG_CODE));
        }else{
            $res->pushError ($this->getModel('wootablepress')->getErrors());
        }
        return $res->ajaxExec();
    }

    public function createTable(){
		$res = new responseWtbp();
		if(($id = $this->getModel('wootablepress')->save(reqWtbp::get('post'))) != false) {
			$res->addMessage(__('Done', WTBP_LANG_CODE));
			$res->addData('edit_link', $this->getModule()->getEditLink( $id ));
		} else
			$res->pushError ($this->getModel('wootablepress')->getErrors());
		return $res->ajaxExec();
	}

	public function multyProductAddToCart(){
		$res = new responseWtbp();
		$params = reqWtbp::get('post');
		$selectedProducts = $params['selectedProduct'];
		if(!empty($selectedProducts)){
			foreach ($selectedProducts as $selectedProduct) {
				if(!empty($selectedProduct['id']) && !empty($selectedProduct['quantity'])){
					global $woocommerce;
					WC()->cart->add_to_cart( $selectedProduct['id'], $selectedProduct['quantity'], isset($selectedProduct['varId']) ? $selectedProduct['varId'] : 0);
				}
			}
			$res->addMessage(__('Product(s) added to the cart', WTBP_LANG_CODE));
		}else{
			$res->addMessage(__('Please select products', WTBP_LANG_CODE));
		}
		return $res->ajaxExec();

	}

}
