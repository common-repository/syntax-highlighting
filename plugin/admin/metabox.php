<?php

/**
 * @package Hightlight Support
 * @since 1.0.0
 */
defined('ABSPATH') or exit();

class slwsu_syntax_highlighting_metabox {
    
    public $post_types;

    /**
     * Constructeur
     */
    public function __construct() {
        $this->post_types = get_option('slwsu_syntax_highlighting_post_types', '');
        $this->_init();
    }

    /**
     * Init
     */
    private function _init() {
        if ('' !== $this->post_types):
            add_action('add_meta_boxes', array($this, 'add_metabox'));
            add_action('save_post', array($this, 'save_metabox'));
        endif;
    }

    /**
     * Add metabox
     */
    public function add_metabox() {
        $cpts = array_map('trim', explode(',', $this->post_types));

        foreach ($cpts as $cpt):
            add_meta_box('slwsu-syntax-highlighting', __('Syntax Hightlighting', 'syng'), array($this, 'template_metabox'), $cpt, 'side');
        endforeach;
    }

    /**
     * Template metabox 
     * @param type $post
     */
    public function template_metabox($post) {
        $input = get_post_meta($post->ID, 'slwsu_syntax_highlighting', true);
        echo '<label for="syntax_highlighting">Indiquez l\'état du support :</label>';
        echo '<select name="syntax_highlighting" style="width:100%;">';
        echo '<option ' . selected('false', $input, false) . ' value="false">'. __('Off', 'syng').'</option>';
        echo '<option ' . selected('true', $input, false) . ' value="true">'. __('On', 'syng').'</option>';
        echo '</select>';
    }

    /**
     * 
     * @param type $post_id
     */
    public function save_metabox($post_id) {
        if (isset($_POST['syntax_highlighting'])) {
            update_post_meta($post_id, 'slwsu_syntax_highlighting', $_POST['syntax_highlighting']);
        }
    }

}
