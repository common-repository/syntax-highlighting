<?php

/**
 * @package Collection
 * version 0.4
 */

class slwsu_syntax_highlighting_admin_assets {

    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'register_css'));
        add_action('admin_enqueue_scripts', array($this, 'register_js'));
    }

    public function register_css() {
        wp_register_style('syng_admin', plugins_url('assets/admin.css', __FILE__));
        wp_enqueue_style('syng_admin');
    }

    public function register_js() {
        wp_register_script('syng_admin', plugins_url('assets/admin.js', __FILE__), null, '', true);
        wp_enqueue_script('syng_admin');
    }

}
