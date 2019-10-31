<?php
class tableModulesWtbp extends tableWtbp {
    public function __construct() {
        $this->_table = '@__modules';
        $this->_id = 'id';     /*Let's associate it with posts*/
        $this->_alias = 'sup_m';
        $this->_addField('label', 'text', 'varchar', 0, __('Label', WTBP_LANG_CODE), 128)
                ->_addField('type_id', 'selectbox', 'smallint', 0, __('Type', WTBP_LANG_CODE))
                ->_addField('active', 'checkbox', 'tinyint', 0, __('Active', WTBP_LANG_CODE))
                ->_addField('params', 'textarea', 'text', 0, __('Params', WTBP_LANG_CODE))
                ->_addField('code', 'hidden', 'varchar', '', __('Code', WTBP_LANG_CODE), 64)
                ->_addField('ex_plug_dir', 'hidden', 'varchar', '', __('External plugin directory', WTBP_LANG_CODE), 255);
    }
}