<?php
class columnsModel extends modelWtbp {
	public $enabledColumns = array('thumbnail', 'product_title', 'featured', 'sku', 'categories', 'description', 'short_description', 'reviews', 'stock', 'date', 'price', 'add_to_cart');
	public function __construct() {
		$this->_setTbl('columns');
		$this->enabledColumns = dispatcherWtbp::applyFilters('getEnabledColumns', $this->enabledColumns);
	}
	public function addEnabledColumns($columns) {
		$this->enabledColumns = array_merge($this->enabledColumns, $columns);
	}
	public function getFullColumnList(){
		$columns = $this->setOrderBy('columns_order')->getFromTbl();
		$productAttr = wc_get_attribute_taxonomies();
		$list = array();
		foreach ($columns as $column) {
			$slug = $column['columns_name'];
			$enabled = in_array($slug, $this->enabledColumns);
			$list[] = array('slug' => $slug, 'name' => $column['columns_nice_name'], 'is_enabled' => $enabled, 'is_default' => $column['is_default'], 'sub' => 0, 'class' => '');
			if($slug == 'attribute') {
				foreach ($productAttr as $attr) {
					$list[] = array('slug' => $slug.'-'.$attr->attribute_id, 'name' => $attr->attribute_label, 'is_enabled' => $enabled, 'is_default' => 0, 'sub' => 1, 'class' => '');
				}
			}
		}
		return dispatcherWtbp::applyFilters('addFullColumnList', $list);
    }
}
