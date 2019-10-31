<?php
/*
* Initial db retrieval
*/
function db_op_retrieve_dbs() {
	global $wpdb;
	$mytables=$wpdb->get_results("SHOW TABLES");
	return $mytables;
}


?>