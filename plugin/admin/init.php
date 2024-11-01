<?php

/**
 * @package Syntax Highlighting
 * @version 0.1
 */
defined('ABSPATH') or exit();

class slwsu_syntax_highlighting_admin_init {

    public $post_types;

    /**
     * 
     */
    public function __construct() {
        $this->post_types = get_option('slwsu_syntax_highlighting_post_types');
        $this->_init();
    }

    /**
     * 
     */
    private function _init() {
        $this->page();
        $this->assets();
        $this->metabox();
    }

    /**
     * 
     */
    public function page() {
        // Page simple
        include_once plugin_dir_path(__FILE__) . 'page.php';
        new slwsu_syntax_highlighting_admin_page();

        // Page onglets
        // include_once plugin_dir_path(__FILE__) . 'panel.php';
        // new slwsu_syntax_highlighting_admin_panel();
    }

    public function assets() {
        include_once plugin_dir_path(__FILE__) . 'assets.php';
        new slwsu_syntax_highlighting_admin_assets();
    }

    /**
     * ...
     */
    public function metabox() {
        include_once plugin_dir_path(__FILE__) . 'metabox.php';
        new slwsu_syntax_highlighting_metabox();
    }

}
