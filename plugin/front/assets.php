<?php

/**
 * @package Collection
 * version 0.4
 */
defined('ABSPATH') or exit();

class slwsu_syntax_highlighting_front_assets {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'register_css'));
        add_action('wp_enqueue_scripts', array($this, 'register_hilight'));
        add_action('wp_enqueue_scripts', array($this, 'register_js'));
    }

    public function register_css() {
        wp_register_style('syng_front', plugins_url('assets/front.css', __FILE__), false);
        wp_enqueue_style('syng_front');
    }

    public function register_js() {
        wp_register_script('syng_front', plugins_url('assets/front.js', __FILE__), null, '', true);
        wp_enqueue_script('syng_front');
    }

    public function register_hilight() {
        global $post;
        $hightLight = get_post_meta($post->ID, 'slwsu_syntax_highlighting', true);
        if (is_single() && 'true' === $hightLight):
            $input = get_option('slwsu_syntax_highlighting_default_color', 'default');
            wp_register_style('syng_hightlightCss', plugins_url('assets/hightlight/styles/' . $input . '.css', __FILE__), false, null);
            wp_enqueue_style('syng_hightlightCss');
            wp_register_script('syng_hightlightJs', plugins_url('assets/hightlight/highlight.pack.js', __FILE__), array(), null, true);
            wp_enqueue_script('syng_hightlightJs');
        endif;
    }

}
