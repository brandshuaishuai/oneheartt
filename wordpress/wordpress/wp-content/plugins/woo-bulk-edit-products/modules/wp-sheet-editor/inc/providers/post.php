<?php

class VGSE_Provider_Post {

	static private $instance = false;
	var $key = 'post';
	var $is_post_type = true;
	static $data_store = array();

	private function __construct() {
		
	}

	function get_provider_read_capability($post_type_key) {
		return $this->get_provider_edit_capability($post_type_key);
	}

	function get_provider_edit_capability($post_type_key) {
		if (!post_type_exists($post_type_key)) {
			return false;
		}
		$post_type_object = get_post_type_object($post_type_key);
		return $post_type_object->cap->edit_posts;
	}

	function init() {
		
	}

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return  Foo A single instance of this class.
	 */
	static function get_instance() {
		if (null == VGSE_Provider_Post::$instance) {
			VGSE_Provider_Post::$instance = new VGSE_Provider_Post();
			VGSE_Provider_Post::$instance->init();
		}
		return VGSE_Provider_Post::$instance;
	}

	function get_post_data_table_id_key($post_type = null) {
		if (!$post_type) {
			$post_type = VGSE()->helpers->get_provider_from_query_string();
		}

		$post_id_key = apply_filters('vgse_sheet_editor/provider/post/post_data_table_id_key', 'ID', $post_type);
		if (!$post_id_key) {
			$post_id_key = 'ID';
		}
		return $post_id_key;
	}

	function get_meta_table_post_id_key($post_type = null) {
		if (!$post_type) {
			$post_type = VGSE()->helpers->get_provider_from_query_string();
		}

		$post_id_key = apply_filters('vgse_sheet_editor/provider/post/meta_table_post_id_key', 'post_id', $post_type);
		if (!$post_id_key) {
			$post_id_key = 'post_id';
		}
		return $post_id_key;
	}

	function get_meta_table_name($post_type = null) {
		global $wpdb;
		if (!$post_type) {
			$post_type = VGSE()->helpers->get_provider_from_query_string();
		}

		$table_name = apply_filters('vgse_sheet_editor/provider/post/meta_table_name', $wpdb->postmeta, $post_type);
		if (!$table_name) {
			$table_name = $wpdb->postmeta;
		}
		return $table_name;
	}

	function prefetch_data($post_ids, $post_type, $spreadsheet_columns) {

		if (!isset(VGSE_Provider_Post::$data_store)) {
			VGSE_Provider_Post::$data_store = array(
				'terms' => array(),
				'meta' => array(),
				'item' => array()
			);
		}
		$new_terms = $this->_get_all_terms($post_ids, $post_type, $spreadsheet_columns);
		VGSE_Provider_Post::$data_store['terms'] = (!empty(VGSE_Provider_Post::$data_store['terms']) ) ? array_merge(VGSE_Provider_Post::$data_store['terms'], $new_terms) : $new_terms;

		$new_meta = $this->_get_all_meta($post_ids, $post_type, $spreadsheet_columns);
		VGSE_Provider_Post::$data_store['meta'] = (!empty(VGSE_Provider_Post::$data_store['meta']) ) ? array_merge(VGSE_Provider_Post::$data_store['meta'], $new_meta) : $new_meta;
	}

	function _get_all_meta($post_ids, $post_type, $spreadsheet_columns) {
		global $wpdb;
		$post_meta = array();
		$post_ids = array_map('intval', array_unique($post_ids));
		$raw_meta_columns = wp_list_filter($spreadsheet_columns, array('data_type' => 'meta_data'));
		$meta_columns = apply_filters('vgse_sheet_editor/provider/post/prefetch/meta_keys', array_unique(array_values(array_merge(array_keys($raw_meta_columns), wp_list_pluck($raw_meta_columns, 'key_for_formulas')))), $post_type);

		$post_meta_table = $this->get_meta_table_name($post_type);
		$post_meta_post_id_key = $this->get_meta_table_post_id_key($post_type);

		$meta_columns_groups = array_chunk($meta_columns, 100);
		$post_meta_raw = array();

		foreach ($meta_columns_groups as $meta_columns_group) {

			$meta_sql = "SELECT m1.* 
FROM $post_meta_table as m1 USE INDEX () 
WHERE m1.meta_key IN ('" . implode("','", array_map('esc_sql', array_map('trim', array_unique($meta_columns_group)))) . "') AND 
m1.$post_meta_post_id_key IN (" . implode(',', $post_ids) . ")  AND 
	m1.meta_value <> ''  
	GROUP BY m1.$post_meta_post_id_key, m1.meta_key";

			$post_meta_raw = array_merge($post_meta_raw, $wpdb->get_results($meta_sql, ARRAY_A));
		}

		foreach ($post_meta_raw as $post_meta_per_key) {
			$post_id = 'item' . $post_meta_per_key[$post_meta_post_id_key];
			if (!isset($post_meta[$post_id])) {
				$post_meta[$post_id] = array();
			}
			$post_meta[$post_id][$post_meta_per_key['meta_key']] = maybe_unserialize($post_meta_per_key['meta_value']);
		}

		$post_meta = $this->_prepare_prefetched_data($post_meta, $post_ids, $meta_columns);

		return $post_meta;
	}

	function _prepare_prefetched_data($post_meta, $post_ids, $columns) {

		// Find posts from original list that are missing from the mysql results, so we assume 
		// that they don't have any meta for the required field keys, so we auto generate the array with empty values.
		$posts_missing_meta = array_diff($post_ids, array_map('intval', explode(',', preg_replace('/[^0-9,]/', '', implode(',', array_keys($post_meta))))));
		if (!empty($posts_missing_meta)) {
			foreach ($posts_missing_meta as $post_id) {
				$post_meta['item' . $post_id] = array();
			}
		}

		$default_meta_values = array_fill_keys($columns, '');
		foreach ($post_meta as $post_id => $post_meta_fields) {
			$post_meta_fields = wp_parse_args($post_meta_fields, $default_meta_values);
			$post_meta[$post_id] = $post_meta_fields;
		}
		return $post_meta;
	}

	function _get_all_terms($post_ids, $post_type, $spreadsheet_columns) {
		global $wpdb;
		$post_terms = array();
		$post_ids = array_map('intval', array_unique($post_ids));
		$taxonomy_columns = apply_filters('vgse_sheet_editor/provider/post/prefetch/taxonomy_keys', array_keys(wp_list_filter($spreadsheet_columns, array('data_type' => 'post_terms'))), $post_type);

		$separator = (!empty(VGSE()->options['be_taxonomy_terms_separator']) ) ? esc_sql(VGSE()->options['be_taxonomy_terms_separator']) : ',';
		$post_terms_sql = "SELECT tr.object_id, tt.taxonomy, GROUP_CONCAT(t.name SEPARATOR '$separator ') as terms, GROUP_CONCAT(tt.parent SEPARATOR '') as parents
FROM $wpdb->terms AS t 
INNER JOIN $wpdb->term_taxonomy AS tt
ON t.term_id = tt.term_id
INNER JOIN $wpdb->term_relationships AS tr
ON tr.term_taxonomy_id = tt.term_taxonomy_id
AND tt.taxonomy IN ('" . implode("','", array_map('esc_sql', array_map('trim', $taxonomy_columns))) . "') 
AND tr.object_id IN (" . implode(',', $post_ids) . ")  
GROUP BY tr.object_id, tt.taxonomy  
ORDER BY t.name ASC";
		$post_terms_raw = $wpdb->get_results($post_terms_sql, ARRAY_A);

		foreach ($post_terms_raw as $post_terms_per_taxonomy) {

			// When a post is using a term with a parent, we set a placeholder to remove the taxonomy later
			// because we'll generate it with PHP to have hierarchy like parent > child
			if (!preg_match('/^0+$/', $post_terms_per_taxonomy['parents'])) {
				$post_terms_per_taxonomy['terms'] = 'wpse-has-parents';
			}

			$post_id = 'item' . $post_terms_per_taxonomy['object_id'];
			if (!isset($post_terms[$post_id])) {
				$post_terms[$post_id] = array();
			}
			$post_terms[$post_id][$post_terms_per_taxonomy['taxonomy']] = $post_terms_per_taxonomy['terms'];
		}

		$post_terms = $this->_prepare_prefetched_data($post_terms, $post_ids, $taxonomy_columns);

		// We remove the empty hierarchical taxonomies to generate them with PHP with the hierarchy
		foreach ($post_terms as $post_key => $taxonomies) {
			foreach ($taxonomies as $taxonomy_key => $terms) {
				if ($terms === 'wpse-has-parents') {
					unset($post_terms[$post_key][$taxonomy_key]);
				}
			}
		}

		return $post_terms;
	}

	function get_item_terms($post_id, $taxonomy) {
		if (isset(VGSE_Provider_Post::$data_store['terms']['item' . $post_id]) && isset(VGSE_Provider_Post::$data_store['terms']['item' . $post_id][$taxonomy])) {
			$raw_value = VGSE_Provider_Post::$data_store['terms']['item' . $post_id][$taxonomy];
		} else {
			$raw_value = VGSE()->data_helpers->prepare_post_terms_for_display(wp_get_post_terms($post_id, $taxonomy, array(
				'update_term_meta_cache' => false
			)));
			VGSE_Provider_Post::$data_store['terms']['item' . $post_id][$taxonomy] = $raw_value;
		}
		return apply_filters('vg_sheet_editor/provider/post/get_items_terms', $raw_value, $post_id, $taxonomy);
	}

	function get_statuses() {
		$post_statuses = get_post_statuses();
		$post_type = VGSE()->helpers->get_provider_from_query_string();
		if (!isset($post_statuses['trash'])) {
			$post_statuses['trash'] = 'Trash';
		}
		if (( $post_type === 'page' && !current_user_can('publish_pages') ) || ( $post_type !== 'page' && !current_user_can('publish_posts'))) {
			unset($post_statuses['publish']);
		}
		if (($post_type === 'page' && !current_user_can('delete_pages')) || ($post_type !== 'page' && !current_user_can('delete_posts'))) {
			unset($post_statuses['trash']);
		}

		$post_statuses['future'] = __('Scheduled');
		return $post_statuses;
	}

	function get_items($query_args) {
		$query = new WP_Query(apply_filters('vg_sheet_editor/provider/post/get_items_args', $query_args));
		if (empty($query_args['fields']) || $query_args['fields'] !== 'ids') {
			foreach ($query->posts as $item) {
				VGSE_Provider_Post::$data_store['item'][$item->ID] = $item;
			}
		}

		return $query;
	}

	function get_item($id, $format = null) {
		if (isset(VGSE_Provider_Post::$data_store['item'][$id])) {
			$item = VGSE_Provider_Post::$data_store['item'][$id];
		} else {
			$item = get_post($id);
			VGSE_Provider_Post::$data_store['item'][$id] = $item;
		}

		if ($format === ARRAY_A && is_object($item)) {
			$item = (array) $item;
		}
		return apply_filters('vg_sheet_editor/provider/post/get_item', $item, $id, $format);
	}

	function get_item_meta($post_id, $key, $single, $context = 'save', $bypass_cache = false) {
		if (!$bypass_cache && isset(VGSE_Provider_Post::$data_store['meta']['item' . $post_id]) && isset(VGSE_Provider_Post::$data_store['meta']['item' . $post_id][$key])) {
			$raw_value = VGSE_Provider_Post::$data_store['meta']['item' . $post_id][$key];
		} else {
			$raw_value = get_post_meta($post_id, $key, $single);
			VGSE_Provider_Post::$data_store['meta']['item' . $post_id][$key] = $raw_value;
		}
		$original_value = $raw_value;
		$raw_value = apply_filters('vg_sheet_editor/provider/post/get_item_meta', $raw_value, $post_id, $key, $single, $context);

		if (!is_null($original_value) && is_null($raw_value) && VGSE_DEBUG) {
			throw new Exception("Post meta was filtered and didn't return a value.", E_USER_ERROR);
		}

		return $raw_value;
	}

	function get_item_data($id, $key) {
		$raw_item = $this->get_item($id);
		$item = get_object_vars($raw_item);
		$second_key = 'wp_' . $key;
		$out = false;
		if (isset($item[$key])) {
			$out = $item[$key];
		}
		if (isset($item[$second_key])) {
			$out = $item[$second_key];
		}
		$out = apply_filters('vg_sheet_editor/provider/post/get_item_data', $out, $id, $key, true, 'read');

		return $out;
	}

	function update_item_data($values, $wp_error = false) {
		global $wpdb;

		$out = true;
		if (isset($values['post_status']) && $values['post_status'] === 'delete') {
			VGSE()->deleted_rows_ids[] = $values['ID'];
			VGSE()->deleted_rows_ids = array_map('intval', array_merge($wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_parent = " . (int) $values['ID']), VGSE()->deleted_rows_ids));
			wp_delete_post($values['ID'], true);
		} else {
			$out = wp_update_post($values, $wp_error);
		}

		return $out;
	}

	function update_item_meta($id, $key, $value) {
		$result = update_post_meta($id, $key, apply_filters('vg_sheet_editor/provider/post/update_item_meta', $value, $id, $key));

		// clear internal cache
		if (isset(VGSE_Provider_Post::$data_store['meta']['item' . $id][$key])) {
			unset(VGSE_Provider_Post::$data_store['meta']['item' . $id][$key]);
		}
		return $result;
	}

	function get_object_taxonomies($post_type) {
		return get_object_taxonomies($post_type, 'objects');
	}

	function set_object_terms($post_id, $terms_saved, $key) {
		return wp_set_object_terms($post_id, $terms_saved, $key);
	}

	function get_total($current_post) {
		global $wpdb;

		$numeroposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = '" . $current_post . "'");
		if (0 < $numeroposts) {
			$numeroposts = (int) $numeroposts;
		} else {
			$numeroposts = 0;
		}
		return $numeroposts;
	}

	function create_item($values) {
		return wp_insert_post($values);
	}

	function get_item_ids_by_keyword($keyword, $post_type = null, $operator = 'LIKE') {
		global $wpdb;
		$operator = ( $operator === 'LIKE') ? 'LIKE' : 'NOT LIKE';

		$checks = array();
		$keywords = array_map('trim', explode(';', $keyword));
		foreach ($keywords as $single_keyword) {
			$checks[] = " post_title $operator '%" . esc_sql($single_keyword) . "%' ";
		}
		if (empty($checks)) {
			return array();
		}
		$sql = "SELECT DISTINCT ID FROM $wpdb->posts WHERE  ( " . implode(' OR ', $checks) . " ) ";
		if (!empty($post_type)) {
			$sql .= "post_type = '" . esc_sql($post_type) . "'";
		}

		$ids = $wpdb->get_col($sql);
		return $ids;
	}

	function get_meta_object_id_field($field_key, $column_settings) {
		$post_meta_post_id_key = $this->get_meta_table_post_id_key();
		return $post_meta_post_id_key;
	}

	function get_table_name_for_field($field_key, $column_settings) {
		global $wpdb;
		$table_name = ( $column_settings['data_type'] === 'post_data' ) ? $wpdb->posts : $this->get_meta_table_name();
		return $table_name;
	}

	function get_meta_field_unique_values($meta_key, $post_type = 'post') {
		global $wpdb;
		$post_meta_table = $this->get_meta_table_name($post_type);
		$post_meta_post_id_key = $this->get_meta_table_post_id_key($post_type);
		$sql = "SELECT m.meta_value FROM $wpdb->posts p LEFT JOIN $post_meta_table m ON p.ID = m.$post_meta_post_id_key WHERE p.post_type = '" . esc_sql($post_type) . "' AND m.meta_key = '" . esc_sql($meta_key) . "' GROUP BY m.meta_value ORDER BY LENGTH(m.meta_value) DESC LIMIT 4";
		$values = apply_filters('vg_sheet_editor/provider/post/meta_field_unique_values', $wpdb->get_col($sql), $meta_key, $post_type);
		return $values;
	}

	function get_all_meta_fields($post_type = 'post') {
		global $wpdb;
		$pre_value = apply_filters('vg_sheet_editor/provider/post/all_meta_fields_pre_value', null, $post_type);

		if (is_array($pre_value)) {
			return $pre_value;
		}
		$post_meta_table = $this->get_meta_table_name($post_type);
		$post_meta_post_id_key = $this->get_meta_table_post_id_key($post_type);
		$meta_keys_sql = "SELECT m.meta_key FROM $wpdb->posts p LEFT JOIN $post_meta_table m ON p.ID = m.$post_meta_post_id_key WHERE p.post_type = '" . esc_sql($post_type) . "' AND m.meta_value NOT LIKE 'field_%' GROUP BY m.meta_key";
		$meta_keys = $wpdb->get_col($meta_keys_sql);
		return apply_filters('vg_sheet_editor/provider/post/all_meta_fields', $meta_keys, $post_type);
	}

}
