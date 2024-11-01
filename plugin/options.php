<?php

/**
 * @package Syntax Highlighting
 * @version 0.1
 */

defined('ABSPATH') or exit();

class slwsu_syntax_highlighting_options {
    
    /**
     * ...
     */
    public static function options() {
        $return = [
            'post_types' => 'post',
            'default_color' => 'default',
            'delete_options' => 'false',
            'grouper' => 'Grouper'
        ];
        return $return;
    }
    
    /**
     * ...
     */
    public static function get_options() {
        $return = [];
        foreach (self::options() as $k => $v):
            $return['slwsu_syntax_highlighting_' . $k] = get_option('slwsu_syntax_highlighting_' . $k, $v);
        endforeach;
        unset($k, $v);

        return $return;
    }
    
    /**
     * ...
     */
    public static function get_transient() {
        $return = get_transient('slwsu_syntax_highlighting_options');
        return $return;
    }
    
    /**
     * ...
     */
    public static function set_transient($aOptions) {
        set_transient('slwsu_syntax_highlighting_options', $aOptions, '');
    }

}
