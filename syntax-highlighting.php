<?php

/*
  Plugin Name: Syntax Highlighting
  Plugin URI: http://web-startup.fr/
  Description: Syntax Highlighting allows you to add syntax highlighting to the snippets contained in your posts.
  Version: 0.1
  Author: Steeve Lefebvre
  Author URI: web-startup.fr/
  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: syng
  Contributors: webstartup, Benoti
  ------------------------------------------------------------------------------
  Note pour les anglophones : quand un code commenté en anglais me plait
  et qu'aucune traduction n'est disponible, je dois me démerder.
  Merci de bien vouloir me rendre la pareille :-þ
 */

defined('ABSPATH') or exit();
__('Syntax Highlighting allows you to add syntax highlighting to the snippets contained in your posts.', 'syng');


/**
 * Grouper support
 */
if (!is_admin()):
    $GROUPER_SYNTAX_HIGHLIGHTING = false;
else:
    if ('true' === get_option('slwsu_is_active_grouper', 'false')):
        if (!class_exists('slwsu_grouper_init')):
            require_once WP_PLUGIN_DIR . '/grouper/init.php';
        endif;
        $GROUPER_SYNTAX_HIGHLIGHTING = new slwsu_grouper_init(get_option('slwsu_syntax_highlighting_grouper'), '4.4', '5.5');
    endif;
endif;

/**
 * Entrée du plugin
 */
class slwsu_syntax_highlighting {

    public function __construct() {

        // Hook
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        add_action('plugins_loaded', array($this, 'text_domain'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'setting_links'));

        // Grouper 
        global $GROUPER_SYNTAX_HIGHLIGHTING;
        if (is_object($GROUPER_SYNTAX_HIGHLIGHTING)):
            if (false === $GROUPER_SYNTAX_HIGHLIGHTING->wp_status or false === $GROUPER_SYNTAX_HIGHLIGHTING->php_status):
                add_action('admin_init', array($this, 'deactivate_auto'));
            endif;
        endif;

        // Plugin
        $this->plugin();
    }

    /**
     * Plugin
     */
    private function plugin() {
        include_once plugin_dir_path(__FILE__) . 'plugin/init.php';
        new slwsu_syntax_highlighting_plugin_init();
    }

    /**
     * Languages
     */
    public static function text_domain() {
        load_plugin_textdomain('syng', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Liens
     */
    public function setting_links($aLinks) {
        $links[] = '<a href="https://web-startup.fr/syntax-highlighting/">' . __('Page', 'syng') . '</a>';
        $links[] = '<a href="' . admin_url('admin.php?page=syntax-highlighting') . '">' . __('Settings', 'syng') . '</a>';
        return array_merge($links, $aLinks);
    }

    /**
     * Activation
     */
    public static function activate() {
        $option = slwsu_syntax_highlighting::options();
        foreach ($option as $k => $v):
            add_option($k, $v);
        endforeach;
        unset($k, $v);
    }

    /**
     * Désactivation
     */
    public static function deactivate() {
        if ('true' === get_option('slwsu_syntax_highlighting_delete_options', 'false')):
            $option = slwsu_syntax_highlighting::options();
            foreach ($option as $k => $v):
                delete_option($k);
            endforeach;
            unset($k, $v);
        endif;
    }

    /**
     * Options
     */
    public static function options() {
        include_once plugin_dir_path(__FILE__) . 'plugin/options.php';
        return slwsu_syntax_highlighting_options::get_options();
    }

    /**
     * Désactivation automatique
     */
    public static function deactivate_auto() {
        // On désactive le plugin
        deactivate_plugins(plugin_basename(__FILE__));
    }

}

/**
 * 
 */
new slwsu_syntax_highlighting();
