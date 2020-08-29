<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
$table_name = $wpdb->prefix . "customsimpletrading";

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS $table_name");

?>