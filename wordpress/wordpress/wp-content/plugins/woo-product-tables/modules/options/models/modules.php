<?php
class modulesModelWtbp extends modelWtbp {
	public function __construct() {
		$this->_setTbl('modules');
	}
    public function get($d = array()) {
        if(isset($d['id']) && $d['id'] && is_numeric($d['id'])) {
            $fields = frameWtbp::_()->getTable('modules')->fillFromDB($d['id'])->getFields();
            $fields['types'] = array();
            $types = frameWtbp::_()->getTable('modules_type')->fillFromDB();
            foreach($types as $t) {
                $fields['types'][$t['id']->value] = $t['label']->value;
            }
            return $fields;
        } elseif(!empty($d)) {
            $data = frameWtbp::_()->getTable('modules')->get('*', $d);
            return $data;
        } else {
            return frameWtbp::_()->getTable('modules')
                ->innerJoin(frameWtbp::_()->getTable('modules_type'), 'type_id')
                ->getAll(frameWtbp::_()->getTable('modules')->alias().'.*, '. frameWtbp::_()->getTable('modules_type')->alias(). '.label as type');
        }
    }
    public function put($d = array()) {
        $res = new responseWtbp();
        $id = $this->_getIDFromReq($d);
        $d = prepareParamsWtbp($d);
        if(is_numeric($id) && $id) {
            if(isset($d['active']))
                $d['active'] = ((is_string($d['active']) && $d['active'] == 'true') || $d['active'] == 1) ? 1 : 0;           //mmm.... govnokod?....)))
           /* else
                 $d['active'] = 0;*/
            
            if(frameWtbp::_()->getTable('modules')->update($d, array('id' => $id))) {
                $res->messages[] = __('Module Updated', WTBP_LANG_CODE);
                $mod = frameWtbp::_()->getTable('modules')->getById($id);
                $newType = frameWtbp::_()->getTable('modules_type')->getById($mod['type_id'], 'label');
                $newType = $newType['label'];
                $res->data = array(
                    'id' => $id, 
                    'label' => $mod['label'], 
                    'code' => $mod['code'], 
                    'type' => $newType,
                    'active' => $mod['active'], 
                );
            } else {
                if($tableErrors = frameWtbp::_()->getTable('modules')->getErrors()) {
                    $res->errors = array_merge($res->errors, $tableErrors);
                } else
                    $res->errors[] = __('Module Update Failed', WTBP_LANG_CODE);
            }
        } else {
            $res->errors[] = __('Error module ID', WTBP_LANG_CODE);
        }
        return $res;
    }
    protected function _getIDFromReq($d = array()) {
        $id = 0;
        if(isset($d['id']))
            $id = $d['id'];
        elseif(isset($d['code'])) {
            $fromDB = $this->get(array('code' => $d['code']));
            if(isset($fromDB[0]) && $fromDB[0]['id'])
                $id = $fromDB[0]['id'];
        }
        return $id;
    }
}
