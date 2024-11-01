<?php

/**
 * @package Syntax Highlighting
 * @version 0.1
 */

defined('ABSPATH') or exit();

include_once plugin_dir_path(__FILE__) . 'form.php';

class slwsu_syntax_highlighting_admin_panel {

    /**
     * ...
     */
    public function __construct() {
        $this->_init();
    }

    /**
     * ...
     */
    private function _init() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'admin_settings'));
    }

    /**
     * ...
     */
    public function admin_menu() {
        global $GROUPER_SYNTAX_HIGHLIGHTING;
        if (is_object($GROUPER_SYNTAX_HIGHLIGHTING)):
            // Grouper
            $GROUPER_SYNTAX_HIGHLIGHTING->add_admin_menu();
            add_submenu_page($GROUPER_SYNTAX_HIGHLIGHTING->grp_id, 'Syntax Highlighting', 'Syntax Highlighting', 'manage_options', 'syntax-highlighting', array($this, 'admin_page'));
        else:
            add_menu_page('Syntax Highlighting', 'Syntax Highlighting', 'activate_plugins', 'syntax-highlighting', array($this, 'admin_page'));
        endif;
    }

    /**
     * ...
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <?php
            slwsu_syntax_highlighting_admin_form::action();
            echo '<h1>Syntax Highlighting</h1>';
            slwsu_syntax_highlighting_admin_form::validation();
            slwsu_syntax_highlighting_admin_form::message($_POST);
            $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'options';
            ?>
            <h2 class = "nav-tab-wrapper">
                <a href="?page=syntax-highlighting&tab=options" class="nav-tab<?php echo ('options' === $active_tab) ? ' nav-tab-active' : ''; ?>">Options</a>
                <a href="?page=syntax-highlighting&tab=grouper" class="nav-tab<?php echo ('grouper' === $active_tab) ? ' nav-tab-active' : ''; ?>">Grouper</a>
            </h2>

            <form method="post" action="options.php">
                <?php
                if ($active_tab == 'options'):
                    do_settings_sections('slwsu_syntax_highlighting_options');
                    settings_fields('slwsu_syntax_highlighting_options');
                elseif ($active_tab == 'grouper') :
                    do_settings_sections('slwsu_syntax_highlighting_grouper');
                    settings_fields('slwsu_syntax_highlighting_grouper');
                else:
                    echo '</br /> Erreur !';
                endif;

                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     *
     */
    public function admin_settings() {
        // Section plugin
        add_settings_section(
                'slwsu_syntax_highlighting_section_plugin', __('Options', 'syng'), array($this, 'section_plugin'), 'slwsu_syntax_highlighting_options'
        );

        // Section options
        add_settings_section(
                'slwsu_syntax_highlighting_section_options', __('Deactivation', 'syng'), array($this, 'section_options'), 'slwsu_syntax_highlighting_options'
        );

        // ...
        add_settings_field(
                'slwsu_syntax_highlighting_delete_options', __('Delete options', 'syng'), array($this, 'delete_options'), 'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_section_options'
        );
        register_setting(
                'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_delete_options'
        );

        /**
         * Support GRP
         */
        if ('true' === get_option('slwsu_is_active_grouper', 'false')):
            // Section grouper
            add_settings_section(
                    'slwsu_syntax_highlighting_section_grouper', __('Group', 'syng'), array($this, 'section_grouper'), 'slwsu_syntax_highlighting_grouper'
            );
            // ...
            add_settings_field(
                    'slwsu_syntax_highlighting_grouper', __('Plugin Group', 'syng'), array($this, 'grouper_nom'), 'slwsu_syntax_highlighting_grouper', 'slwsu_syntax_highlighting_section_grouper'
            );
            register_setting(
                    'slwsu_syntax_highlighting_grouper', 'slwsu_syntax_highlighting_grouper'
            );
        else:
            // Section NO grouper
            add_settings_section(
                    'slwsu_syntax_highlighting_section_grouper', __('Grouper', 'ptro'), array($this, 'section_grouper_no'), 'slwsu_syntax_highlighting_grouper'
            );
        endif;
    }

    /**
     * Plugin
     */
    public function section_plugin() {
        echo __('This section concerns the configuration of the plugin', 'syng') . '&nbsp;<strong><i>Syntax Highlighting</i></strong>';
    }

    /**
     * Options
     */
    public function section_options() {
        echo __('This section is about saving plugin options of', 'syng') . '&nbsp;<strong><i>Syntax Highlighting</i></strong>';
    }

    public function delete_options() {
        $input = get_option('slwsu_syntax_highlighting_delete_options');
        ?>
        <input name="slwsu_syntax_highlighting_delete_options" type="radio" value="true" <?php if ('true' == $input) echo 'checked="checked"'; ?> />
        <span class="description">On</span>
        &nbsp;
        <input name="slwsu_syntax_highlighting_delete_options" type="radio" value="false" <?php if ('false' == $input) echo 'checked="checked"'; ?> />
        <span class="description">Off</span>
        &nbsp;-&nbsp;
        <span class="description"><?php echo __('Delete plugin options when disabling.', 'syng'); ?> </span>
        <?php
    }

    /**
     * Support GRP
     */
    public function section_grouper() {
        echo __('This section concerns the Grouper plugin group of', 'syng') . '&nbsp;<strong><i>Syntax Highlighting</i></strong>';
    }

    public function grouper_nom() {
        $input = get_option('slwsu_syntax_highlighting_grouper', 'Grouper');
        echo '<input id="slwsu_syntax_highlighting_grouper" name="slwsu_syntax_highlighting_grouper" value="' . $input . '" type="text" class="regular-text" />';
        echo '<p class="description">' . __('Specify here the Grouper group to attach', 'syng') . '&nbsp;<strong><i>Syntax Highlighting</i></strong>.</p>';
        echo '<p>' . __('WARNING :: changing the value of this field amounts to modifying the name of the parent link in the WordPress admin menu !', 'syng') . '</p>';
        echo '<p>' . __('You can use this option to isolate this plugin or to add this plugin to an existing Grouper group.', 'syng') . '</p>';
    }

    public function section_grouper_no() {
        echo '<strong><i>Syntax Highlighting</i></strong> ' . __('is compatible with Grouper', 'syng');
        if (file_exists(WP_PLUGIN_DIR . '/grouper')):
            echo '.<br />Grouper ' . __('is installed but does not appear to be enabled', 'syng') . ' : ';
            echo '<a href="plugins.php">' . __('you can activate', 'syng') . ' Grouper</a>';
        else:
            echo ' : <a href="https://web-startup.fr/grouper/" target="_blank">' . __('more information here', 'syng') . '</a>.';
        endif;
    }

}
