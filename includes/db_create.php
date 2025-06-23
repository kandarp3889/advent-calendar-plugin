<?php

function ac_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'advents_calander_users';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,	
		name varchar(50)  NULL,
		email varchar(50)  NULL,
        dayid int(11)  NULL,
        terms int(1)  NULL,
        rule int(1)  NULL,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		Primary KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}