<?php

/**
 * @package Syntax Highlighting
 * @version 0.1
 */

defined('WP_UNINSTALL_PLUGIN') or exit();

// Options
include_once plugin_dir_path(__FILE__) . 'plugin/options.php';
$aOptions = slwsu_syntax_highlighting_options::get_options();
foreach ($aOptions as $k => $v):
    delete_option($k);
endforeach;
unset($k, $v);

// Transient
delete_transient('slwsu_syntax_highlighting_options');