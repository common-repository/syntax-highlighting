<?php
/**
 * @package Syntax Highlighting
 * @version 0.1
 */
defined('ABSPATH') or exit();

include_once plugin_dir_path(__FILE__) . 'form.php';

class slwsu_syntax_highlighting_admin_page {

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
            ?>
            <form method="post" action="options.php">
                <?php
                do_settings_sections('slwsu_syntax_highlighting_options');
                settings_fields('slwsu_syntax_highlighting_options');
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
                'slwsu_syntax_highlighting_section_plugin', __('General', 'syng'), array($this, 'section_plugin'), 'slwsu_syntax_highlighting_options'
        );

        // Section options
        add_settings_field(
                'slwsu_syntax_highlighting_post_types', __('Post types', 'syng'), array($this, 'post_types'), 'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_section_plugin'
        );
        register_setting(
                'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_post_types'
        );

        // ...
        add_settings_field(
                'slwsu_syntax_highlighting_default_color', __('Default color', 'syng'), array($this, 'default_color'), 'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_section_plugin'
        );
        register_setting(
                'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_default_color'
        );

        // ...
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
                    'slwsu_syntax_highlighting_section_grouper', __('Group', 'syng'), array($this, 'section_grouper'), 'slwsu_syntax_highlighting_options'
            );
            // ...
            add_settings_field(
                    'slwsu_syntax_highlighting_grouper', __('Plugin Group', 'syng'), array($this, 'grouper_nom'), 'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_section_grouper'
            );
            register_setting(
                    'slwsu_syntax_highlighting_options', 'slwsu_syntax_highlighting_grouper'
            );
        else:
            // Section NO grouper
            add_settings_section(
                    'slwsu_syntax_highlighting_section_grouper', null, array($this, 'section_grouper_no'), 'slwsu_syntax_highlighting_options'
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

    public function post_types() {
        $input = get_option('slwsu_syntax_highlighting_post_types');
        echo '<input id="slwsu_syntax_highlighting_post_types" name="slwsu_syntax_highlighting_post_types" value="' . $input . '" type="text" class="regular-text" />';
        echo '<p class="description">' . __('Add the different post types here.', 'syng') . '</p>';
    }

    public function default_color() {
        $input = get_option('slwsu_syntax_highlighting_default_color');
        ?>
        <select id="slwsu_syntax_highlighting_default_color" name="slwsu_syntax_highlighting_default_color">
            <option value="github" <?php if ('github' == $input) echo 'selected="selected"'; ?>>github</option>
            <option value="github-gist" <?php if ('github-gist' == $input) echo 'selected="selected"'; ?>>github-gist</option>
            <option value="googlecode" <?php if ('googlecode' == $input) echo 'selected="selected"'; ?>>googlecode</option>
            <option value="agate" <?php if ('agate' == $input) echo 'selected="selected"'; ?>>agate</option>
            <option value="androidstudio" <?php if ('androidstudio' == $input) echo 'selected="selected"'; ?>>androidstudio</option>
            <option value="arta" <?php if ('arta' == $input) echo 'selected="selected"'; ?>>arta</option>
            <option value="atelier-cave.dark" <?php if ('atelier-cave.dark' == $input) echo 'selected="selected"'; ?>>atelier-cave.dark</option>
            <option value="atelier-cave.light" <?php if ('atelier-cave.light' == $input) echo 'selected="selected"'; ?>>atelier-cave.light</option>
            <option value="atelier-dune.dark" <?php if ('atelier-dune.dark' == $input) echo 'selected="selected"'; ?>>atelier-dune.dark</option>
            <option value="atelier-dune.light" <?php if ('atelier-dune.light' == $input) echo 'selected="selected"'; ?>>atelier-dune.light</option>
            <option value="atelier-estuary.dark" <?php if ('atelier-estuary.dark' == $input) echo 'selected="selected"'; ?>>atelier-estuary.dark</option>
            <option value="atelier-estuary.light" <?php if ('atelier-estuary.light' == $input) echo 'selected="selected"'; ?>>atelier-estuary.light</option>
            <option value="atelier-forest.dark" <?php if ('atelier-forest.dark' == $input) echo 'selected="selected"'; ?>>atelier-forest.dark</option>
            <option value="atelier-forest.light" <?php if ('atelier-forest.light' == $input) echo 'selected="selected"'; ?>>atelier-forest.light</option>
            <option value="atelier-heath.dark" <?php if ('atelier-heath.dark' == $input) echo 'selected="selected"'; ?>>atelier-heath.dark</option>
            <option value="atelier-heath.light" <?php if ('atelier-heath.light' == $input) echo 'selected="selected"'; ?>>atelier-heath.light</option>
            <option value="atelier-lakeside.dark" <?php if ('atelier-lakeside.dark' == $input) echo 'selected="selected"'; ?>>atelier-lakeside.dark</option>
            <option value="atelier-lakeside.light" <?php if ('atelier-lakeside.light' == $input) echo 'selected="selected"'; ?>>atelier-lakeside.light</option>
            <option value="atelier-plateau.dark" <?php if ('atelier-plateau.dark' == $input) echo 'selected="selected"'; ?>>atelier-plateau.dark</option>
            <option value="atelier-plateau.light" <?php if ('atelier-plateau.light' == $input) echo 'selected="selected"'; ?>>atelier-plateau.light</option>
            <option value="atelier-savanna.dark" <?php if ('atelier-savanna.dark' == $input) echo 'selected="selected"'; ?>>atelier-savanna.dark</option>
            <option value="atelier-savanna.light" <?php if ('atelier-savanna.light' == $input) echo 'selected="selected"'; ?>>atelier-savanna.light</option>
            <option value="atelier-seaside.dark" <?php if ('atelier-seaside.dark' == $input) echo 'selected="selected"'; ?>>atelier-seaside.dark</option>
            <option value="atelier-seaside.light" <?php if ('atelier-seaside.light' == $input) echo 'selected="selected"'; ?>>atelier-seaside.light</option>
            <option value="atelier-sulphurpool.dark" <?php if ('atelier-sulphurpool.dark' == $input) echo 'selected="selected"'; ?>>atelier-sulphurpool.dark</option>
            <option value="atelier-sulphurpool.light" <?php if ('atelier-sulphurpool.light' == $input) echo 'selected="selected"'; ?>>atelier-sulphurpool.light</option>
            <option value="brown_paper" <?php if ('brown_paper' == $input) echo 'selected="selected"'; ?>>brown_paper</option>
            <option value="codepen-embed" <?php if ('codepen-embed' == $input) echo 'selected="selected"'; ?>>codepen-embed</option>
            <option value="color-brewer" <?php if ('color-brewer' == $input) echo 'selected="selected"'; ?>>color-brewer</option>
            <option value="dark" <?php if ('dark' == $input) echo 'selected="selected"'; ?>>dark</option>
            <option value="darkula" <?php if ('darkula' == $input) echo 'selected="selected"'; ?>>darkula</option>
            <option value="docco" <?php if ('docco' == $input) echo 'selected="selected"'; ?>>docco</option>
            <option value="far" <?php if ('far' == $input) echo 'selected="selected"'; ?>>far</option>
            <option value="foundation" <?php if ('foundation' == $input) echo 'selected="selected"'; ?>>foundation</option>
            <option value="hybrid" <?php if ('hybrid' == $input) echo 'selected="selected"'; ?>>hybrid</option>
            <option value="idea" <?php if ('idea' == $input) echo 'selected="selected"'; ?>>idea</option>
            <option value="ir_black" <?php if ('ir_black' == $input) echo 'selected="selected"'; ?>>ir_black</option>
            <option value="kimbie.dark" <?php if ('kimbie.dark' == $input) echo 'selected="selected"'; ?>>kimbie.dark</option>
            <option value="kimbie.light" <?php if ('kimbie.light' == $input) echo 'selected="selected"'; ?>>kimbie.light</option>
            <option value="magula" <?php if ('magula' == $input) echo 'selected="selected"'; ?>>magula</option>
            <option value="mono-blue" <?php if ('mono-blue' == $input) echo 'selected="selected"'; ?>>mono-blue</option>
            <option value="monokai" <?php if ('monokai' == $input) echo 'selected="selected"'; ?>>monokai</option>
            <option value="monokai_sublime" <?php if ('monokai_sublime' == $input) echo 'selected="selected"'; ?>>monokai_sublime</option>
            <option value="obsidian" <?php if ('obsidian' == $input) echo 'selected="selected"'; ?>>obsidian</option>
            <option value="paraiso.dark" <?php if ('paraiso.dark' == $input) echo 'selected="selected"'; ?>>paraiso.dark</option>
            <option value="paraiso.light" <?php if ('paraiso.light' == $input) echo 'selected="selected"'; ?>>paraiso.light</option>
            <option value="pojoaque" <?php if ('pojoaque' == $input) echo 'selected="selected"'; ?>>pojoaque</option>
            <option value="railscasts" <?php if ('railscasts' == $input) echo 'selected="selected"'; ?>>railscasts</option>
            <option value="rainbow" <?php if ('rainbow' == $input) echo 'selected="selected"'; ?>>rainbow</option>
            <option value="school_book" <?php if ('school_book' == $input) echo 'selected="selected"'; ?>>school_book</option>
            <option value="solarized_dark" <?php if ('solarized_dark' == $input) echo 'selected="selected"'; ?>>solarized_dark</option>
            <option value="solarized_light" <?php if ('solarized_light' == $input) echo 'selected="selected"'; ?>>solarized_light</option>
            <option value="sunburst" <?php if ('sunburst' == $input) echo 'selected="selected"'; ?>>sunburst</option>
            <option value="tomorrow-night-blue" <?php if ('tomorrow-night-blue' == $input) echo 'selected="selected"'; ?>>tomorrow-night-blue</option>
            <option value="tomorrow-night-bright" <?php if ('tomorrow-night-bright' == $input) echo 'selected="selected"'; ?>>tomorrow-night-bright</option>
            <option value="tomorrow-night-eighties" <?php if ('tomorrow-night-eighties' == $input) echo 'selected="selected"'; ?>>tomorrow-night-eighties</option>
            <option value="tomorrow-night" <?php if ('tomorrow-night' == $input) echo 'selected="selected"'; ?>>tomorrow-night</option>
            <option value="tomorrow" <?php if ('tomorrow' == $input) echo 'selected="selected"'; ?>>tomorrow</option>
            <option value="vs" <?php if ('vs' == $input) echo 'selected="selected"'; ?>>vs</option>
            <option value="xcode" <?php if ('xcode' == $input) echo 'selected="selected"'; ?>>xcode</option>
            <option value="zenburn" <?php if ('zenburn' == $input) echo 'selected="selected"'; ?>>zenburn</option>
            <option value="default" <?php if ('default' == $input) echo 'selected="selected"'; ?>>default</option> 
        </select>
        <?php
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
