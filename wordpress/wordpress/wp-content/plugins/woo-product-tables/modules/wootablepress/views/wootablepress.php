<?php
class wootablepressViewWtbp extends viewWtbp {
    public $orderColumns = array();
    public $columnNiceNames = array();

    public function getTabContent() {
        frameWtbp::_()->addStyle('wtbp.admin.css', $this->getModule()->getModPath(). 'css/admin.tables.css');
        frameWtbp::_()->addScript('wtbp.admin.list.js', $this->getModule()->getModPath(). 'js/admin.list.js');
        frameWtbp::_()->addJSVar('wtbp.admin.list.js', 'wtbpTblDataUrl', uriWtbp::mod('wootablepress', 'getListForTbl', array('reqType' => 'ajax')));
        frameWtbp::_()->addJSVar('wtbp.admin.list.js', 'url', admin_url('admin-ajax.php'));
        frameWtbp::_()->addScript('adminCreateTableWtbp', $this->getModule()->getModPath(). 'js/create-table.js');
        frameWtbp::_()->addScript('wtbp.dataTables.js', $this->getModule()->getModPath(). 'js/dt/jquery.dataTables.min.js');
        frameWtbp::_()->addStyle('wtbp.dataTables.css', $this->getModule()->getModPath(). 'css/dt/jquery.dataTables.min.css');
        frameWtbp::_()->addScript('wtbp.buttons', $this->getModule()->getModPath(). 'js/dt/dataTables.buttons.min.js');

        frameWtbp::_()->getModule('templates')->loadJqGrid();
        frameWtbp::_()->getModule('templates')->loadFontAwesome();
        frameWtbp::_()->getModule('templates')->loadBootstrapSimple();

        $this->assign('addNewLink', frameWtbp::_()->getModule('options')->getTabUrl('wootablepress#wtbpadd'));

        return parent::getContent('wootablepressAdmin');
    }

    public function getEditTabContent($idIn) {
        $isWooCommercePluginActivated = $this->getModule()->isWooCommercePluginActivated();
        if(!$isWooCommercePluginActivated) {
            return;
        }

        frameWtbp::_()->getModule('templates')->loadBootstrapSimple();
        frameWtbp::_()->getModule('templates')->loadJqueryUi();
        frameWtbp::_()->getModule('templates')->loadCodemirror();

        $this->loadAssets();

        frameWtbp::_()->addScript('wtbp.admin.tables.js', $this->getModule()->getModPath(). 'js/tables.admin.js');
        frameWtbp::_()->addStyle('wtbp.admin.tables.css', $this->getModule()->getModPath(). 'css/admin.tables.css');
        frameWtbp::_()->addStyle('wtbp.frontend.tables.css', $this->getModule()->getModPath(). 'css/frontend.tables.css');
        frameWtbp::_()->addScript('adminCreateTableWtbp', $this->getModule()->getModPath(). 'js/create-table.js');

        dispatcherWtbp::doAction('addScriptsContent', true);

        $idIn = isset($idIn) ? (int) $idIn : 0;
        $table = $this->getModel('wootablepress')->getById($idIn);
        $tableColumns = $this->getModel('columns')->getFullColumnList();
        $settings = $this->getModule()->unserialize($table['setting_data']);
        $link = frameWtbp::_()->getModule('options')->getTabUrl( $this->getCode() );
        $languages = frameWtbp::_()->getModule('wootablepress')->getModel('languages')->getLanguageBackend();

        $this->assign('languages', $languages);
        $this->assign('link', $link);
        $this->assign('settings', $settings);
        $this->assign('table', $table);
        $this->assign('table_columns', $tableColumns);
        $this->assign('authors_html', $this->getAuthorsHtml());
        $this->assign('categories_html', $this->getTaxonomyHierarchyHtml());
        $this->assign('tags_html', $this->getTaxonomyHierarchyHtml(0, '', 'product_tag'));
        $this->assign('attributes_html', $this->getAttributesHierarchy());
        $this->assign('search_table', $this->getLeerSearchTable());
        $this->assign('is_pro', frameWtbp::_()->isPro());

        return parent::getContent('wootablepressEditAdmin');
    }

    public function renderHtml($params){
        $isWooCommercePluginActivated = $this->getModule()->isWooCommercePluginActivated();
        if(!$isWooCommercePluginActivated) {
            return;
        }

        $this->loadAssets();

        frameWtbp::_()->addScript('frontend.tables.js', $this->getModule()->getModPath(). 'js/tables.frontend.js');
        frameWtbp::_()->addStyle('frontend.tables.css', $this->getModule()->getModPath(). 'css/frontend.tables.css');
        frameWtbp::_()->addJSVar('frontend.tables.js', 'url', admin_url('admin-ajax.php'));
        frameWtbp::_()->addScript('common-js', WTBP_JS_PATH. 'common.js', array(), false, true);
        frameWtbp::_()->addScript('lightbox-js', $this->getModule()->getModPath(). 'js/lightbox.js');
        frameWtbp::_()->addStyle('lightbox-css', $this->getModule()->getModPath(). 'css/lightbox.css');

        dispatcherWtbp::doAction('addScriptsContent', false);

        $id = isset($params['id']) ? (int) $params['id'] : 0;
        if(!$id){
            return false;
        }
        $table = $this->getModel('wootablepress')->getById($id);
        $tableSettings = $this->getModule()->unserialize($table['setting_data']);

        $html = $this->getProductContentFrontend($id, $tableSettings);
        $filter = dispatcherWtbp::applyFilters('getTableFilters', '', $id);

        $tableSettings['settings']['order'] = json_encode($this->orderColumns);

        $viewId = $id . '_' . mt_rand(0, 999999);
        $this->assign('tableId', $id);
        $this->assign('viewId', $viewId);
        $this->assign('html', $html);
        $this->assign('filter', $filter);
        $this->assign('settings', $tableSettings);
        $this->assign('custom_css', $this->getCustomCss($tableSettings, 'wtbp-table-'.$viewId));
        $this->assign('loader', $this->getLoaderHtml($tableSettings));

        return parent::getContent('wootablepressHtml');
    }

    public function loadAssets(){
        frameWtbp::_()->addScript('wtbp.dataTables.js', $this->getModule()->getModPath(). 'js/dt/jquery.dataTables.min.js');
        frameWtbp::_()->addScript('wtbp.buttons', $this->getModule()->getModPath(). 'js/dt/dataTables.buttons.min.js');
        frameWtbp::_()->addScript('wtbp.colReorder', $this->getModule()->getModPath(). 'js/dt/dataTables.colReorder.min.js');
        frameWtbp::_()->addScript('wtbp.fixedColumns', $this->getModule()->getModPath(). 'js/dt/dataTables.fixedColumns.min.js');
        frameWtbp::_()->addScript('wtbp.print', $this->getModule()->getModPath(). 'js/dt/buttons.print.min.js');
        frameWtbp::_()->addScript('wtbp.fixedHeader', $this->getModule()->getModPath(). 'js/dt/dataTables.fixedHeader.min.js');
        frameWtbp::_()->addScript('wtbp.scroller', $this->getModule()->getModPath(). 'js/dt/dataTables.scroller.min.js');
        frameWtbp::_()->addScript('wtbp.responsive', $this->getModule()->getModPath(). 'js/dt/dataTables.responsive.min.js');
        frameWtbp::_()->addStyle('wtbp.responsive', $this->getModule()->getModPath(). 'css/dt/responsive.dataTables.min.css');
        frameWtbp::_()->addStyle('wtbp.dataTables.css', $this->getModule()->getModPath(). 'css/dt/jquery.dataTables.min.css');
        frameWtbp::_()->addStyle('wtbp.fixedHeader.css', $this->getModule()->getModPath(). 'css/dt/fixedHeader.dataTables.min.css');
        frameWtbp::_()->addScript('wtbp.core.tables.js', $this->getModule()->getModPath(). 'js/core.tables.js');
        frameWtbp::_()->addJSVar('wtbp.core.tables.js', 'url', admin_url('admin-ajax.php'));
        frameWtbp::_()->addStyle('wtbp.loaders.css', $this->getModule()->getModPath(). 'css/loaders.css');
        frameWtbp::_()->addScript('wtbp.notify.js', WTBP_JS_PATH. 'notify.js', array(), false, true);
    }

    public function getCustomCss(&$tableSettings, $viewId) {
        if(isset($tableSettings['settings']['custom_css']) && !empty($tableSettings['settings']['custom_css'])) {
            $customCss = base64_decode($tableSettings['settings']['custom_css']);
            unset($tableSettings['settings']['custom_css']);
        } else {
            $customCss = '';
        }
        return dispatcherWtbp::applyFilters('getCustomStyles', $customCss, $viewId, $tableSettings['settings']);
    }

    public function getLoaderHtml($settings) {
        $html = '';
        if(!$this->getTableSetting($settings['settings'], 'hide_table_loader', false)) {
            $html = '<div class="supsystic-table-loader wtbpLogoLoader"></div>';
            $html = dispatcherWtbp::applyFilters('getLoaderHtml', $html, $settings['settings']);
            $html = '<div class="wtbpLoader">'.$html.'</div>';
        }
        return $html;
    }

    public function getSearchProductsFilters($args, $params){
        $filterAuthor = isset($params['filter_author']) ? $params['filter_author'] : 0;
        $filterCategory = isset($params['filter_category']) ? $params['filter_category'] : 0;
        $filterTag = isset($params['filter_tag']) ? $params['filter_tag'] : 0;
        $filterAttribute = isset($params['filter_attribute']) ? $params['filter_attribute'] : 0;

        if(!empty($filterAuthor)) {
            $args['author'] = $filterAuthor;
        }

        if(!empty($filterCategory)) {
            $args["tax_query"][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => $filterCategory,
                'include_children' => true
            );
        }

        if(!empty($filterTag)) {
            $args["tax_query"][] = array(
                'taxonomy' => 'product_tag',
                'field'    => 'id',
                'terms'    => $filterTag,
                'include_children' => true
            );
        }

        if(!empty($filterAttribute)) {
            if ( empty(wc_get_attribute($filterAttribute)->slug) ) {
                $term = get_term( $filterAttribute );
                $taxonomy = $term->taxonomy;
                $args["tax_query"][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $filterAttribute,
                    'operator' => "IN"
                );
            } else {
                $term = get_term( $filterAttribute );
                $taxonomy = $term->taxonomy;
                $args["tax_query"][] = array(
                    'taxonomy' => wc_get_attribute($filterAttribute)->slug,
                    'operator' => 'EXISTS',
                );
            }
        }

        if(!empty($params['search']['value'])){
            $args['s'] = $params['search']['value'];
        }
        if(isset($params['filter_private']) && $params['filter_private'] == 1) {
            $args['post_status'] = array('publish', 'private');
        }
        if(isset($params['show_variations']) && $params['show_variations'] == 1) {
            $args['post_type'] = array('product', 'product_variation');
        }

        return $args;
    }

    public function getSearchProducts($params){
        $dataArr = array();
        $args = array(
            'posts_per_page' => 10,
            'post_type'   => 'product',
            'order'       => 'DESC',
            'suppress_filters' => true,
            'post_status' => array('publish'),
            'offset' => !empty($params['start']) ? $params['start'] : '0'
        );
        $filterInTable = isset($params['filter_in_table']) ? $params['filter_in_table'] : '';
        $ids = isset($params['productids']) ? explode(',', $params['productids']) : [];
        if(sizeof($ids) > 0 && !empty($filterInTable)) {
            $args[$filterInTable == 'no' ? 'post__not_in' : 'post__in'] = $ids;
        }
        $args = $this->getSearchProductsFilters($args, $params);

        if(!empty($params['order']['0']['column']) && !empty($params['order']['0']['dir'])){
            switch($params['order']['0']['column']){
                //3 - title column
                case 3:
                    $args['orderby'] = 'title';
                    break;
                //6 - sku
                case 6:
                    $args['meta_key'] = '_sku';
                    $args['orderby'] = 'meta_value';
                    break;
                //7 - stock column
                case 7:
                    $args['meta_key'] = '_stock_status';
                    $args['orderby'] = 'meta_value';
                    break;
                //8 - price column
                case 8:
                    $args['meta_key'] = '_price';
                    $args['orderby'] = 'meta_value_num';
                    break;
                //9 - date column
                case 9:
                    $args['orderby'] = 'date';
                    break;
            }
            $args['order'] = $params['order']['0']['dir'];
        }
        $stockNames = wc_get_product_stock_status_options();

        $products = new WP_Query( $args );

        $filterAttribute = isset($params['filter_attribute']) ? $params['filter_attribute'] : 0;
        $filterAttributeExactly = isset($params['filter_attribute_exactly']) ? $params['filter_attribute_exactly'] : '';

        if(empty($filterAttribute)) $filterAttributeExactly = ''; 
        else {
            if(empty(wc_get_attribute($filterAttribute)->slug) ) {
                $term = get_term( $filterAttribute );
                $attributeSlug = $term->taxonomy;
            } else {
                $attributeExactlyParent = true;
            }
        }

        $filtered = false;

        foreach($products->posts as $product) {
            $id = $product->ID;
            $thumbnailSrc = get_the_post_thumbnail($id, array(50,50));
            $continue = true;
            //$categories = get_the_term_list( $product->ID, 'product_cat', '', ', ', '' );
            //$categories = is_admin() ? str_ireplace('<a', '<a target="_blank"', $categories) : $categories;
            $_product = wc_get_product($id);
            if ( !empty($filterAttributeExactly) ) {
                $continue = true;
                $attributesList = $_product->get_attributes();
                foreach ($attributesList as $attribute) {
                    if ( ( $attribute['name'] == $attributeSlug ) && ( count($attribute['options']) > 1 ) ) {
                        $continue = false;
                    }
                }
                if ( ( !$continue ) || ( !empty($attributeExactlyParent) && $attributeExactlyParent && count($attributesList) > 1) ) {
                    $filtered = true;
                    continue;
                }
            }

            $attributes = '';
            $attributesList2 = $_product->get_attributes();

            foreach ($attributesList2 as $attribute) {
                $title = $attribute['name'];
                $terms = wc_get_product_terms($_product->id, $attribute['name'], array('fields' => 'names'));
                if ( !empty($terms) ){
                    $title .= ' : ';
                }
                foreach ($terms as $key => $term) {
                    $title .= $term;
                    if (!empty($terms[$key+1])) {
                        $title .= ', ';
                    }
                }
                $attributes .= $title;
                $attributes .= '<br>';
            }

            $price = $_product->get_price_html();
            $date = $product->post_date;
            if($_product->post_type == 'product_variation') {
                $existVariations = true;
                $parentId = $_product->get_parent_id();
                if(!isset($parents[$parentId])) {
                    $parents[$parentId] = array(
                        'thumbnail' => get_the_post_thumbnail($parentId, array(50, 50)),
                        'categories' => get_the_term_list($parentId, 'product_cat', '', ', ', '')
                    );
                }
                if(empty($thumbnailSrc)) $thumbnailSrc = $parents[$parentId]['thumbnail'];
                $categories = $parents[$parentId]['categories'];
                $variation = implode(', ', $_product->get_attributes());
            } else {
                $categories = get_the_term_list($id, 'product_cat', '', ', ', '');
                $variation = '';
            }
            $categories = is_admin() ? str_ireplace('<a', '<a target="_blank"', $categories) : $categories;

            $dataArr[] = array(
                'id' => $id,
                'in_table' => in_array($id, $ids),
                'product_title' => $product->post_title,
                'thumbnail' => $thumbnailSrc,
                'categories' => $categories,
                'sku' => $_product->get_sku(),
                'stock' => $stockNames[$_product->get_stock_status()],
                'price' => $price,
                'date' => $date,
                'variation' => $variation,
                'attributes' => $attributes,
            );
        }

        $filtered = ($filtered) ? count($dataArr) : $products->found_posts;

        $data = $this->generateTableSearchData($dataArr);
        $return = array(
            "draw" => 0,
            "recordsTotal" => $products->found_posts,
            "recordsFiltered" => $filtered,
            'data' => $data
        );
        return $return;
    }

    public function setOrderColumns($orders, $backend = true) {
        $columns = array();

        if (!$backend) {
            //If we use stripslashes, then we remove the special characters of the encoding - as a result,
            //sometimes on frontend we get incorrect text for json_decode (and as a result, an incorrect column name send to frontend data-settings) if we use Cyrillic or diacritical symbols,
            //therefore we need to make json_decode without stripslashes and take the correct column name from there
            $ordersPrepare = json_decode($orders, true);
            $nameList = array();
            if (!empty($ordersPrepare)) {
                foreach ($ordersPrepare as $key => $ord) {
                    $nameList[$key]['display_name'] = !empty($ord['display_name']) ? $ord['display_name'] : '';
                    $nameList[$key]['original_name'] = !empty($ord['original_name']) ? $ord['original_name'] : '';
                };
            }
        }

        if($orders !== false && !empty($orders)) {
            $orders = json_decode(stripslashes($orders), true);
            $enabledColumns = $this->getModel('columns')->enabledColumns;
            foreach($orders as $key => $column) {
                $fullSlug = $column['slug'];
                $subDelim = strpos($fullSlug, '-');
                if (!$backend) {
                    //Insert the correct column name
                    $column['display_name'] = $nameList[$key]['display_name'];
                    $column['original_name'] = $nameList[$key]['original_name'];
                }
                if($subDelim > 0) {
                    $column['main_slug'] = substr($fullSlug, 0, $subDelim);
                    $sub_slug = substr($fullSlug, $subDelim + 1);
                    $column['sub_slug'] = $column['main_slug'] == 'attribute' ? wc_attribute_taxonomy_name_by_id((int)$sub_slug) : $sub_slug;
                } else {
                    $column['main_slug'] = $fullSlug;
                }
                if(in_array($column['main_slug'], $enabledColumns)) {
                    $columns[] = $column;
                }
            }
        }
        $this->orderColumns = $columns;
    }

    public function addHiddenFilterQuery($query) {
        if($hidden_term = get_term_by('name', 'exclude-from-catalog', 'product_visibility')) {
            $query[] = array(
                'taxonomy' => 'product_visibility',
                'field' => 'term_taxonomy_id',
                'terms' => array($hidden_term->term_taxonomy_id),
                'operator' => 'NOT IN'
            );
        }
        return $query;
    }

    public function getProductContentFrontend($id, $tableSettings){
        if(empty($id)) return false;

        $settings = $this->getTableSetting($tableSettings, 'settings', array());
        $this->setOrderColumns($this->getTableSetting($settings, 'order', false), false);
        $dataArr = array();
        if(!(frameWtbp::_()->isPro() && $this->getTableSetting($settings, 'pagination_ssp', false))) {

            $productIds = $this->getTableSetting($settings, 'productids', false);
            $productIds = explode(",", $productIds);
            if(!empty($productIds) && !is_array($productIds)){
                $productIds = array($productIds);
            }
            $dataArr = $this->getProductContent(array('in' => $productIds, 'not' => false), $tableSettings, true);

            wp_reset_postdata();
        }
        $html = $this->generateTableHtml($dataArr, true, $settings);

        return $html;
    }

    public function getProductPage($params) {
        if(empty($params['id'])){
            return false;
        }
        $tableId = $params['id'];

        $table = $this->getModel('wootablepress')->getById($tableId);
        $tableSettings = $this->getModule()->unserialize($table['setting_data']);
        $settings = $this->getTableSetting($tableSettings, 'settings', array());

        $this->setOrderColumns($this->getTableSetting($settings, 'order', false), true);
        //$tableSettings['settings']['order'] = json_encode($this->orderColumns);
        
        $productIds = $this->getTableSetting($settings, 'productids', false);
        $productIds = explode(",", $productIds);
        if(!empty($productIds) && !is_array($productIds)){
            $productIds = array($productIds);
        }
        $dataArr = $this->getProductContent(array('in' => $productIds, 'not' => false), $tableSettings, true, $params);

        $html = $this->generateTableHtml($dataArr, true, $settings, false);

        return array(
            'html' => $html,
            'total' => $params['total'],
            'filtered' => $params['filtered']);
    }

    public function calcProductIds($params, $getList = false) {
        $productIdsExits = !empty($params['productIdExist']) ? $params['productIdExist'] : array();
        $productIdsSelected = !empty($params['productIdSelected']) ? $params['productIdSelected'] : array();
        $productIdExcluded = !empty($params['productIdExcluded']) ? $params['productIdExcluded'] : array();
        $productFilters = !empty($params['filters']) ? $params['filters'] : array();

        $filter = $this->getSearchProductsFilters(array(), $productFilters);
        $isAll = $productIdsSelected == 'all';

        $productIds = array();
        if(sizeof($filter) > 0) {
            $args = array_merge(array(
                'post_type' => 'product',
                'ignore_sticky_posts' => true,
                'post_status' => array('publish'),
                'posts_per_page' => -1
            ), $filter);

            if($isAll) {
                if(sizeof($productIdExcluded) > 0) {
                    $args['post__not_in'] = $productIdExcluded;
                }
            } else {
                $args['post__in'] = $productIdsSelected;
            }
            $postExist = new WP_Query($args);

            $products = $productIdsExits;
            foreach($postExist->posts as $post) {
                $products[] = $post->ID;
            }
            $productIds = array('in' => array_unique($products), 'not' => false);
        } else {
            if($isAll) {
                $filtered = array_filter($productIdExcluded,
                    function ($value) use ($productIdsExits) {
                        return !in_array($value, $productIdsExits);
                    }
                );
                $productIds = array('in' => false, 'not' => $filtered);
            } else {
                $productIdsExits = dispatcherWtbp::applyFilters('filterProductIds', $productIdsExits, $params);
                $productIds = array('in' => array_unique(array_merge($productIdsExits, $productIdsSelected)), 'not' => false);
            }
        }
        if($getList) {
            if($productIds['not'] == false) {
                $ids = $productIds['in'];
            } else {
                $args = array(
                    'post_type' => 'product',
                    'ignore_sticky_posts' => true,
                    'post_status' => array('publish'),
                    'posts_per_page' => -1,
                    'post__not_in' => $productIds['not'],
                    'fields' => 'ids',
                );

                if(is_array($productIds['in'])) {
                    $args['post__in'] = $productIds['in'];
                }
                $result = new WP_Query($args);
                $ids = $result->posts;
            }
            wp_reset_postdata();
            return is_array($ids) ? implode(',', $ids) : '';
        }
        return $productIds;
    }

    public function getProductContentBackend($params, $preview = false) {
        $productIds = $this->calcProductIds($params);

        if(empty($params['tableid']) || empty($productIds) ){
            return false;
        }
        $tableId = $params['tableid'];

        $table = $this->getModel('wootablepress')->getById($tableId);
        $tableSettings = $this->getModule()->unserialize($table['setting_data']);
        $this->setOrderColumns(isset($params['order']) ? $params['order'] : false, true);
        $tableSettings['settings']['order'] = json_encode($this->orderColumns);
        $settings = $this->getTableSetting($tableSettings, 'settings', array());

        if(!$preview || !(frameWtbp::_()->isPro() && $this->getTableSetting($settings, 'pagination_ssp', false))) {

            $dataArr = $this->getProductContent($productIds, $tableSettings, $preview);
        }

        $postIdsReturn = '';
        $count = count($dataArr);
        $i = 1;
        foreach ($dataArr as $data){
            if($count === $i){
                $postIdsReturn .= $data['id'];
            }else{
                $postIdsReturn .= $data['id'] . ',';
            }
            $i++;
        }
        //$dateAndTimeFormat = $this->getDateTimeFormat($tableSettings);
        $html = $this->generateTableHtml($dataArr, $preview, $settings);

        $return = array();
        $return['html'] = $html;
        $return['filter'] = dispatcherWtbp::applyFilters('getTableFilters', '', $tableId);
        $return['settings'] = $tableSettings;
        $return['css'] = $preview ? $this->getCustomCss($tableSettings, 'wtbpPreviewTable') : '';
        $return['ids'] = $postIdsReturn;

        return $return;
    }
    public function getProductThumbnailLink($id, $imgSize, $add = 'class="wtbpMainImage"') {
        $link = '';
        $postThumbnailId = get_post_thumbnail_id($id);
        if($postThumbnailId) {
            $postImg = wp_get_attachment_image($postThumbnailId, $imgSize);
            $postImgSrc = wp_get_attachment_image_src($postThumbnailId, 'full');
            $link = '<a href="'.$postImgSrc[0].'" data-lightbox="'.$id.'" '.$add.'>'.$postImg.'</a>';
        }
        return $link;
    }

    public function getProductContent($productIds, $tableSettings, $preview = true, &$page = array()) {
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        $frontend = !is_admin() || $preview;
        $orders = $this->orderColumns;

        $settings = isset($tableSettings['settings']) ? $tableSettings['settings'] : array();
        $isPage = !empty($page);

        $postStatuses = array('publish');
        if($this->getTableSetting($settings, 'show_private', false) || !$frontend) {
            $postStatuses[] = 'private';
        }
        $args = array(
            //'post__in' => $productIds,
            'post_type' => array('product', 'product_variation'),
            'ignore_sticky_posts' => true,
            'post_status' => $postStatuses,
            'posts_per_page' => -1,
            'tax_query' => array()
        );
        //$args['tax_query'] = $this->addHiddenFilterQuery($args['tax_query']);

        if(!empty($settings['hide_out_of_stock'])) {
            $args['meta_query'][] = array(
                'key'     => '_stock_status',
                'value'   => 'outofstock',
                'compare' => 'NOT LIKE'
            );
        }
        if(is_array($productIds['in'])) {
            $args['post__in'] = $productIds['in'];
        } else if(is_array($productIds['not'])) {
            $args['post__not_in'] = $productIds['not'];
            $args['post_type'] = 'product';
            $args['post_status'] = 'publish';
        }
        if (!empty($settings['sorting_custom'])) {
            $args['orderby'] = 'post__in';
        }
        $multyAddToCart = $this->getTableSetting($settings, 'multiple_add_cart', false);
        $showVarImages = $this->getTableSetting($settings, 'show_variation_image', false);

        if($isPage) {
            $args = dispatcherWtbp::applyFilters('setSSPQueryFilters', $settings, $args, $page);
        }

        $dataExist = new WP_Query($args);
        dispatcherWtbp::doAction('removeSSPQueryFilters');
        $postExist = $dataExist->posts;

        $imgSize = !empty($settings['thumbnail_size']) ? $settings['thumbnail_size'] : 'thumbnail';
        if($frontend){
            if($imgSize == 'set_size') {
                $imgSize = array(
                    (!empty($settings['thumbnail_width']) ? $settings['thumbnail_width'] : 0),
                    (!empty($settings['thumbnail_height']) ? $settings['thumbnail_height'] : 0)
                );
            }
        }

        $stockNames = wc_get_product_stock_status_options();
        //$taxonomies = array();
        $dataArr = array();
        foreach($orders as $i => $column) {
            switch ($column['main_slug']) {
                case 'thumbnail':
                    $mobileThubmnailWidth = !empty($column['mobile_thumbnail_size_width']) ? $column['mobile_thumbnail_size_width'] : '';
                    $mobileThubmnailHeight = !empty($column['mobile_thumbnail_size_height']) ? $column['mobile_thumbnail_size_height'] : '';
                    if(isset($settings['responsive_mode']) && wp_is_mobile() && $settings['responsive_mode'] !== 'disable') {
                        if (!empty($mobileThubmnailWidth) && !empty($mobileThubmnailWidth)) {
                            $mobileStyles = '"style=width:'.$mobileThubmnailWidth.'px; height:'.$mobileThubmnailHeight.'px;"';
                            $imgSize = array(
                                $mobileThubmnailWidth,
                                $mobileThubmnailHeight
                            );
                        }
                    }
                    $mobileStyles = isset($mobileStyles) ? $mobileStyles : '';
                    break;
                case 'description':
                    $stripDescription = isset($column['cut_description_text']) ? $column['cut_description_text'] : true;
                    $stripSize = !empty($column['cut_description_text_size']) ? $column['cut_description_text_size'] : 100;
                    break;
                case 'short_description':
                    $stripDescriptionShort = isset($column['cut_short_description_text']) ? $column['cut_short_description_text'] : false;
                    $stripSizeShort = !empty($column['cut_short_description_text_size']) ? $column['cut_short_description_text_size'] : 100;
                    break;
                default:
            }
        }
        
        $parents = array();
        $isPro = frameWtbp::_()->isPro();

        foreach($postExist as $post) {
            $id = $post->ID;
            $postTitle = $post->post_title;
            $postContent = $post->post_content;
            $postDate = $post->post_date;
            $post = null;
            $_product = wc_get_product($id);
            $parentId = $_product->post_type == 'product_variation' ? $_product->get_parent_id() : 0;
            if(!empty($parentId)) $parents[$parentId] = array();
            $mainId = empty($parentId) ? $id : $parentId;

            $sku = $_product->get_sku();
            $data = array('id' => $id);
            foreach($orders as $column) {
                switch ($column['main_slug']) {
                    case 'thumbnail':
                        $value = $frontend ? $this->getProductThumbnailLink($id, $imgSize) : get_the_post_thumbnail($id, 'thumbnail', $mobileStyles);
                        if(!empty($parentId) && empty($value)) {
                            if(!isset($parents[$parentId]['thumbnail'])) {
                                $value = $frontend ? $this->getProductThumbnailLink($parentId, $imgSize) : get_the_post_thumbnail($parentId, 'thumbnail', $mobileStyles);
                                $parents[$parentId]['thumbnail'] = $value;
                            } else {
                                $value = $parents[$parentId]['thumbnail'];
                            }
                        }
                        $data['thumbnail'] = $value;

                        break;
                    case 'product_title':
                        $url = get_permalink($id);
                        if (!isset($column['product_title_link']) || !empty($column['product_title_link'])) {
                            $onlick = isset($column['product_title_link_blank']) && !empty($column['product_title_link_blank']) ? ' onclick="window.open(this.href,\'_blank\'); return false;"' : '';
                            $data['product_title'] = '<a href="'. $url .'"'. $onlick. '>'.$postTitle.'</a>';
                        } else {
                            $data['product_title'] = $postTitle;
                        }
                        break;
                    case 'featured':
                        //$data['featured'] = ($_product->get_featured() ? __('Featured', 'woocommerce') : '');
                        $featured = '';
                        if($_product->get_featured()) {
                            $showAs = $isPro ? $this->getTableSetting($column, 'featured_show_as', 'text') : 'text';
                            if($showAs == 'icon') $featured = '<i class="fa fa-fw fa-star"></i>';
                            else if($showAs == 'image') $featured = '<img class="wtbpFeaturedImage" src="'.$this->getTableSetting($column, 'featured_image_path', WTBP_IMG_PATH.'default.png').'">';
                            else $featured = __('Featured', 'woocommerce');
                        }
                        $data['featured'] = $featured;
                        break;
                    case 'sku':
                        $data['sku'] = $sku;
                        break;
                    case 'categories':
                        $categories = get_the_term_list($mainId, 'product_cat', '', ', ', '');
                        $data['categories'] = $frontend ? $categories : str_ireplace('<a', '<a target="_blank"', $categories);
                        break;
                    case 'description':
                        if($stripDescription){
                            $postContent = strip_tags(mb_strimwidth($postContent, 0, $stripSize, "..."));
                        }
                        $data['description'] = $postContent;
                        break;
                    case 'short_description':
                        $postContent = $_product->get_short_description();
                        if($stripDescriptionShort){
                            $postContent = strip_tags(mb_strimwidth($postContent, 0, $stripSizeShort, "..."));
                        }
                        $data['short_description'] = $postContent;
                        break;
                    case 'reviews':
                        $reviews = '';
                        if($average = $_product->get_average_rating()) {
                            $reviews .= '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average).'"><span style="width:'.(($average / 5) * 100) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__('out of 5', 'woocommerce').'</span></div>';
                        }
                        $data['reviews'] = $reviews;
                        break;
                    case 'stock':
                        $data['stock'] = $stockNames[$_product->get_stock_status()];
                        if ((isset($column['stock_item_counts']) && !empty($column['stock_item_counts'])) || $_product->is_type('variable')) {
                            $quantity = $_product->get_stock_quantity();
                            if ($quantity) {
                                $quantityTxt = isset($settings['stock_quantity_text']) && !empty($settings['stock_quantity_text'])
                                    ? sprintf('<span class="stock-count" data-quantity="%1$d">%2$d</span> %3$s', $quantity, $quantity, $settings['stock_quantity_text'])
                                    : sprintf('<span class="stock-count" data-quantity="%1$d">%2$d</span> item(s)', $quantity, $quantity);
                            } else {
                                $quantityTxt = isset($settings['stock_quantity_text']) && !empty($settings['stock_quantity_text'])
                                    ? sprintf('<span class="stock-count"></span> %1$s', $settings['stock_quantity_text'])
                                    : '<span class="stock-count"></span> item(s)';
                            }
                            $hidden = !$quantity ? ' wtbpHidden' : '';
                            $data['stock'] .= '<br><span class="stock-item-counts'. $hidden. '">'. $quantityTxt. '</span>';
                        }
                        break;
                    case 'date':
                        $data['date'] = $postDate;
                        break;
                    case 'price':
                        $data['price'] = array($_product->get_price_html(), $_product->get_price());
                        break;
                    case 'add_to_cart':
                        $varid = '';
                        
                        if($_product->get_stock_status() == 'outofstock') {
                            if($frontend && $multyAddToCart) {
                                $data['check_multy'] = '';
                            }
                            $data['add_to_cart'] = '<div class="wtbpOutOfStockCart">'.$stockNames['outofstock'].'</div>';
                        } else {
                            if($frontend) {
                                $variablesHtml = '';
                                $varPricesHtml = '';
                                $varImagesHtml = '';
                                $view = frameWtbp::_()->getModule('wootablepress')->getView();

                                if($_product->is_type('variable')) {
                                    $variations = array();
                                    $attributes = array();
                                    foreach($_product->get_available_variations() as $variation) {
                                        if($variation['variation_is_visible']) {
                                            $varId = $variation['variation_id'];
                                            $varAttributes = array();
                                            foreach($variation['attributes'] as $key => $value) {
                                                $taxonomy = str_replace('attribute_', '', $key);
                                                if(taxonomy_exists($taxonomy)) {
                                                    if(!isset($taxonomies[$taxonomy])) {
                                                        $terms = get_terms($taxonomy);
                                                        foreach($terms as $term) {
                                                            $taxonomies[$taxonomy]['terms'][$term->slug] = $term->name;
                                                        }
                                                        $taxonomies[$taxonomy]['label'] = get_taxonomy($taxonomy)->labels->singular_name;
                                                    }
                                                } else {
                                                    if(!isset($taxonomies[$taxonomy])) {
                                                        $taxonomies[$taxonomy] = ['label' => $taxonomy, 'terms' => []];
                                                    }
                                                    if(!empty($value)) {
                                                        $taxonomies[$taxonomy]['terms'][$value] = $value;
                                                    }
                                                }

                                                if(!isset($taxonomies[$taxonomy])) break;
                                                if(empty($value)) {
                                                    $attributes[$taxonomy] = $taxonomies[$taxonomy]['terms'];
                                                    $varAttributes[$taxonomy] = '';
                                                } else {
                                                    $attributes[$taxonomy][$value] = $taxonomies[$taxonomy]['terms'][$value];
                                                    $varAttributes[$taxonomy] = $value;
                                                }
                                            }

                                            $variationQuantity = isset($variation['max_qty']) ? ' data-quantity="'. $variation['max_qty']. '"' : ' data-quantity="'. __('n/a', WTBP_LANG_CODE). '"';
                                            $variations[$varId] = $varAttributes;
                                            $varPricesHtml .= '<div class="wtbpVarPrice wtbpHidden" data-variation_id="'.$varId.'"'. $variationQuantity. '>'.$variation['price_html'].'</div>';
                                            if($showVarImages) {
                                                $varImagesHtml .= $view->getProductThumbnailLink($varId, $imgSize, 'class="wtbpVarImage wtbpHidden" data-variation_id="'.$varId.'"');
                                            }
                                        }
                                    }
                                    $this->taxonomies = $taxonomies;
                                    if(!empty($varPricesHtml)) {
                                        $varPricesHtml = '<div class="wtbpVarPrices">'.$varPricesHtml.'</div>';
                                    }
                                    if(!empty($varImagesHtml)) {
                                        $varImagesHtml = '<div class="wtbpVarImages">'.$varImagesHtml.'</div>';
                                    }
                                    if(sizeof($attributes) > 0) {
                                        $variablesHtml = '<div class="wtbpVarAttributes" data-variations="'.htmlspecialchars(json_encode($variations), ENT_QUOTES, 'UTF-8').'">';
                                        foreach($attributes as $taxonomy => $terms) {
                                            $variablesHtml .= '<select class="wtbpVarAttribute" data-attribute="'.$taxonomy.'"><option value="">'.$taxonomies[$taxonomy]['label'].'</option>';
                                            foreach($terms as $slug => $value) {
                                                $variablesHtml .= '<option value="'.$slug.'">'.$value.'</option>';
                                            }
                                            $variablesHtml .= '</select>';
                                        }
                                        $variablesHtml .= '</div>';
                                    }
                                }
                                $quantityHtml = woocommerce_quantity_input(array(), $_product, false);
                                $cartUrl = wc_get_cart_url();
                                $addToCartUrl = do_shortcode('[add_to_cart_url id="'.$id.'"]');
                                if($multyAddToCart) {
                                    $data['check_multy'] = '<input type="checkbox" class="wtbpAddMulty" value="'.$id.'" data-quantity="1" data-variation_id="0"'.(empty($variablesHtml) ? '' : ' disabled').'>';
                                }
                                $id = !empty($varId) ? $varId : $id;
                                if ( get_post_meta($id, '_wc_measurement_price_calculator_min_price', false) ) {
                                    ob_start();
                                    woocommerce_template_single_add_to_cart();
                                    $data['add_to_cart'] = ob_get_contents();
                                    ob_end_clean();
                                    $shortcode = '<div class="mpc_add_to_cart_shortcode">'.do_shortcode('[add_to_cart id="'.$id.'" style="" class="product_button_mpc" show_price="false" sku ="'.$sku.'"]').'</div>';

                                    $addToCartClass = 'add_to_cart_button ajax_add_to_cart product_mpc';
                                    $shortcode =  str_replace("add_to_cart_button", $addToCartClass, $shortcode);

                                    $data['add_to_cart'] =  str_replace('<form class="cart"', '<form class="cart form_product_mpc"', $data['add_to_cart']);
                                    $data['add_to_cart'] =  str_replace('</form>', $shortcode.'</form>', $data['add_to_cart']);
                                } else {
                                    $data['add_to_cart'] = $variablesHtml.'<div class="wtbpAddToCartWrapper'.(empty($variablesHtml) ? '' : ' wtbpDisabledLink').'">'.$quantityHtml.do_shortcode('[add_to_cart id="'.$id.'" class="" style="" show_price="false" sku ="'.$sku.'"]').'</div>'.$varPricesHtml.$varImagesHtml;
                                }
                                $varId = '';
                            } else {
                                $data['add_to_cart'] = do_shortcode('[add_to_cart id="'.$id.'" class="" style=""  show_price="false" sku ="'.$sku.'"]');
                            }
                        }
                        break;
                    default:
                        $data = dispatcherWtbp::applyFilters(
                            'getColumnContent',
                            $data,
                            array(
                                'column' => $column,
                                'product' => $_product,
                                'frontend' => $frontend,
                                'settings' => $settings,
                                'stockNames' => $stockNames,
                                'imgSize' => $imgSize
                            )
                        );
                        break;
                }
            }
            $dataArr[] = $data;
        }
        if($isPage) {
            $page['total'] = $dataExist->found_posts;
            $page['filtered'] = sizeof($dataArr);
        }
        return $dataArr;
    }

    public function getColumnNiceName($slug){
        if(empty($this->columnNiceNames)) {
            $orders = $this->orderColumns;
            $names = array();
            if(empty($orders)) {
                $tableColumns = $this->getModel('columns')->getFromTbl();
                foreach($tableColumns as $columns) {
                    $names[$columns['columns_name']] = $columns['columns_nice_name'];
                }
            } else {
                foreach($orders as $order) {
                    $name = (!empty($order['show_display_name']) && $order['show_display_name'] === '1') ? $order['display_name'] : $order['original_name'];
                    $names[$order['slug']] = $name;
                }
            }
            $this->columnNiceNames = $names;
        }
        return array_key_exists($slug, $this->columnNiceNames) ? $this->columnNiceNames[$slug] : $slug;
    }

    public function sortProductColumns(){
        $orders = $this->orderColumns;
        $sortArray = array();
        if(!empty($orders)){
            foreach ($orders as $order){
                $sortArray[] = $order['slug'];
            }
        }else{
            $orders = array('product_title', 'thumbnail', 'categories', 'price', 'date');
            foreach ($orders as $order){
                $sortArray[] = $order;
            }
        }
        /*$sortedPostList = array();

        foreach ($sortArray as $order) {
            $i = 0;
            foreach ($listPost as $key=>$post) {
                if (is_array($post) && array_key_exists($order, $post)) {
                    $sortedPostList[$key][$order] = $post[$order];
                    $i++;
                }
            }
        }
        return $sortedPostList;*/
        return $sortArray;
    }

    public function generateTableHtml($listPost, $frontend, $settings, $withHeader = true) {
        $dateAndTimeFormat = $this->getDateTimeFormat($settings);
        //$listPost = $this->sortProductColumns($listPost);
        $columns = $this->sortProductColumns();
        if($frontend && $this->getTableSetting($settings, 'multiple_add_cart', false)) {
            array_unshift($columns, 'check_multy');
        }
        if($withHeader) {
            $this->columnNiceNames = array();
            $tableHeader = '<tr>';
            if(!$frontend) {
                $tableHeader .= '<th class="no-sort"><input class="wtbpCheckAll" type="checkbox"/></th>';
            }
            foreach($columns as $key){
                $tableHeader .=  '<th data-key="'.$key.'">'.($key == 'check_multy' ? '<input type="checkbox" class="wtbpAddMultyAll">': $this->getColumnNiceName($key)).'</th>';
            }
            $tableHeader .= '</tr>';
        }
        $tableBody = '';
        for($i = 0; $i < count($listPost); $i++) {
            $tableBody .=  $frontend ? '<tr>' : '<tr><td><input type="checkbox" data-id="'.$listPost[$i]['id'].'"></td>';
            $product = $listPost[$i];
            foreach($columns as $key) {
                $data = isset($product[$key]) ? $product[$key] : '';
                if(is_array($data)) {
                    $order = ' data-order="'.$data[1].'"';
                    $data = $data[0];
                } else {
                    $order = '';
                }
                if($key === 'date' && $dateAndTimeFormat){
                    $date = $data;
                    $dateTimestamp = strtotime($date);
                    $outputDate = date($dateAndTimeFormat, $dateTimestamp);

                    $tableBody .=  '<td data-order="'.$dateTimestamp.'" class="'.$key.'"><div class="wtbpNoBreak">'.$outputDate.'</div></td>';
                } else if($key === 'product_title') {
                    $tableBody .=  '<td class="'.$key.'">'.$data.'</td>';
                } else {
                    $tableBody .=  '<td class="'.$key.'"'.$order.'>'.$data.'</td>';
                }
            }
            $tableBody .=  '</tr>';
        }

        $table = '';
        if($withHeader) {
            $table = '<thead>'.$tableHeader.'</thead>';
            if($this->getTableSetting($settings, 'footer_show', false)) {
                $table .= '<tfoot>'.$tableHeader.'</tfoot>';
            }
        }
        $table .= '<tbody>'.$tableBody.'</tbody>';

        return $table;
    }

    public function generateTableSearchData($listPost){
        $table = array();
        $yes = __('yes', WTBP_LANG_CODE);
        $no = __('no', WTBP_LANG_CODE);
        foreach ($listPost as $post){
            $table[] = array(
                '0' => '<input type="checkbox" data-id="'.$post['id'].'">',
                '1' => ($post['in_table'] ? '<label class="wtbpPropuctInTable">'.$yes.'</label>' : $no),
                '2' => $post['thumbnail'],
                '3' => $post['product_title'],
                '4' => $post['variation'],
                '5' => $post['categories'],
                '6' => $post['sku'],
                '7' => $post['stock'],
                '8' => $post['price'],
                '9' => $post['date'],
                '10' => $post['attributes'],
            );
        }
        return $table;
    }

    public function getDateTimeFormat($settings) {

        $dateFormat = $this->getTableSetting($settings, 'date_formats', false);
        $timeFormat = $this->getTableSetting($settings, 'time_formats', false);
        $dateAndTimeFormat = false;
        if($timeFormat && $dateFormat){
            $dateAndTimeFormat = $dateFormat . ' ' . $timeFormat;
        }else if($dateFormat){
            $dateAndTimeFormat = $dateFormat;
        }else if($timeFormat){
            $dateAndTimeFormat = $timeFormat;
        }
        return $dateAndTimeFormat;
    }

    public function showEditTablepressFormControls() {
        parent::display('wootablepressEditFormControls');
    }

    public function getTaxonomyHierarchyHtml($parent = 0, $pre = '', $tax = 'product_cat') {
        $args = array(
            'hide_empty' => true,
            'parent' => $parent
        );
        $terms = get_terms($tax, $args);
        $options = '';
        foreach($terms as $term){
            if(!empty($term->term_id)){
                $options .= '<option data-parent="'.$parent.'" value="'.$term->term_id.'">'.$pre.$term->name.'</option>';
                $options .= $this->getTaxonomyHierarchyHtml($term->term_id, $pre.'&nbsp;&nbsp;&nbsp;', $tax);
            }
        }
        return $options;
    }
    public function getAuthorsHtml() {
        $options = '';
        foreach(get_users() as $user) 
        {
            $options .= '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
        }
        return $options;
    }

    public function getChildrenAttributesHierarchy($parent = 0, $slugname = '', $pre = '') {
        $terms = get_terms($slugname, array(
            'hide_empty' => true,
            'parent' => 0
        ));
        $options = '';
        foreach($terms as $term){
            if(!empty($term->term_id)){
                $options .= '<option data-parent="'.$parent.'" value="'.$term->term_id.'">'.$pre.$term->name.'</option>';
            }
        }
        return $options;
    }
    public function getAttributesHierarchy($parent = 0, $pre = '') {
        $listOfProducts = wc_get_products( array( 'return' => 'ids', 'limit' => -1 ) );
        $producstListArray = array();
        $attributesListArray = array();

        $options = '';

        foreach ($listOfProducts as $product) {
            $productId = $product;
            $product = wc_get_product( $product );
            $attributesList = $product->get_attributes();
            if (!empty($attributesList)) {
                foreach ($attributesList as $attribute) {
                    $attributesListArray[$attribute['id']] = $attribute['name'];
                }
            }
        }
        foreach($attributesListArray as $attributeId => $attribute) {
            $options .= '<option data-parent="'.$parent.'" value="'.$attributeId.'">'.$attribute.'</option>';
            $options .= self::getChildrenAttributesHierarchy($attributeId, $attribute, '&nbsp;&nbsp;&nbsp;');
        }

        return $options;
    }
    public function getLeerSearchTable() {
        $th = '<th class="no-sort"><input class="wtbpCheckAll" type="checkbox"/></th>'.
            '<th class="no-sort">'.__('In table', WTBP_LANG_CODE).'</th>'.
            '<th class="no-sort">'.__('Thumbnail', WTBP_LANG_CODE).'</th>'.
            '<th>'.__('Name', WTBP_LANG_CODE).'</th>'.
            '<th class="no-sort">'.__('Variation', WTBP_LANG_CODE).'</th>'.
            '<th class="no-sort">'.__('Categories', WTBP_LANG_CODE).'</th>'.
            '<th>'.__('SKU', WTBP_LANG_CODE).'</th>'.
            '<th>'.__('Stock status', WTBP_LANG_CODE).'</th>'.
            '<th>'.__('Price', WTBP_LANG_CODE).'</th>'.
            '<th>'.__('Date', WTBP_LANG_CODE).'</th>'.
            '<th>'.__('Attributes', WTBP_LANG_CODE).'</th>';
        return '<thead><tr>'.$th.'</tr></thead>';//<tfoot><tr>'.$th.'</tr></tfoot>';
    }
}