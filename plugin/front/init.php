<?php

/**
 * @package Syntax Highlighting
 * @version 0.1
 */

defined('ABSPATH') or exit();

class slwsu_syntax_highlighting_front_init{
    
    /**
     * 
     */
    public function __construct(){
        $this->_init();
    }
    
    /**
     * 
     */
    private function _init(){
        $this->assets();
    }
    
    public function assets(){
        include_once plugin_dir_path(__FILE__) . 'assets.php';
        new slwsu_syntax_highlighting_front_assets();
    }
    
}