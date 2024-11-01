<?php

/**
 * 
 */
class code_hightLight_widget extends WP_Widget {

    /**
     *
     * @var type 
     */
    function __construct() {
        parent::__construct(
                // ID du widget (on peut mettre "false")
                'syntax_highlighting',
                //  Nom du widget dans le backoffice
                esc_html__('Syntax HighLighting', 'syng'),
                //  Description dans le backoffice
                array('description' => esc_html__('Add syntax highlighting to your sample code.', 'syng'))
        );
    }

    /**
     * Affichage du widget en Frontoffice
     *
     * @see WP_Widget::widget()
     *
     * @param array $args           Arguments du Widget
     * @param array $instance       Données sauvegardées en backoffice
     */
    public function widget($args, $instance) {

        global $post;
        $hightlightStatus = get_post_meta($post->ID, 'slwsu_syntax_highlighting', true);

        if ('true' === $hightlightStatus && is_singular()):
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);

            echo $before_widget;

            if ($title):
                echo $before_title . $title . $after_title;
            endif;
            $linkCss = plugins_url('front/assets/hightlight/styles', __FILE__ );
            ?>
            <script>
                /* global COOKIE, $_ */
                document.addEventListener('DOMContentLoaded', function () {
                    var cookie = COOKIE.get("syntaxHighlightingStyles");
                    var actif = $_.id('actif');

                    console.log(cookie);
                    if (cookie) {
                        var fichier_2 = cookie.split('\\').pop().split('/').pop();
                        var fichier_3 = fichier_2.replace(/\.([a-z]+)$/, '');
                        actif.html(fichier_3);
                    } else {
                        actif.html("default");
                    }

                });
            </script>
            <form>
                <select id="syntax-highlighting" name="select" onchange="CODE_HILIGHT.changeCssPath('<?php echo $linkCss; ?>/' + this[selectedIndex].text + '.css')">

                    <option id="actif"></option>
                    <option>github</option>
                    <option>github-gist</option>
                    <option>googlecode</option>
                    <option>agate</option>
                    <option>androidstudio</option>
                    <option>arta</option>
                    <option>atelier-cave.dark</option>
                    <option>atelier-cave.light</option>
                    <option>atelier-dune.dark</option>
                    <option>atelier-dune.light</option>
                    <option>atelier-estuary.dark</option>
                    <option>atelier-estuary.light</option>
                    <option>atelier-forest.dark</option>
                    <option>atelier-forest.light</option>
                    <option>atelier-heath.dark</option>
                    <option>atelier-heath.light</option>
                    <option>atelier-lakeside.dark</option>
                    <option>atelier-lakeside.light</option>
                    <option>atelier-plateau.dark</option>
                    <option>atelier-plateau.light</option>
                    <option>atelier-savanna.dark</option>
                    <option>atelier-savanna.light</option>
                    <option>atelier-seaside.dark</option>
                    <option>atelier-seaside.light</option>
                    <option>atelier-sulphurpool.dark</option>
                    <option>atelier-sulphurpool.light</option>
                    <option>brown_paper</option>
                    <option>codepen-embed</option>
                    <option>color-brewer</option>
                    <option>dark</option>
                    <option>darkula</option>
                    <option>docco</option>
                    <option>far</option>
                    <option>foundation</option>
                    <option>hybrid</option>
                    <option>idea</option>
                    <option>ir_black</option>
                    <option>kimbie.dark</option>
                    <option>kimbie.light</option>
                    <option>magula</option>
                    <option>mono-blue</option>
                    <option>monokai</option>
                    <option>monokai_sublime</option>
                    <option>obsidian</option>
                    <option>paraiso.dark</option>
                    <option>paraiso.light</option>
                    <option>pojoaque</option>
                    <option>railscasts</option>
                    <option>rainbow</option>
                    <option>school_book</option>
                    <option>solarized_dark</option>
                    <option>solarized_light</option>
                    <option>sunburst</option>
                    <option>tomorrow-night-blue</option>
                    <option>tomorrow-night-bright</option>
                    <option>tomorrow-night-eighties</option>
                    <option>tomorrow-night</option>
                    <option>tomorrow</option>
                    <option>vs</option>
                    <option>xcode</option>
                    <option>zenburn</option>
                    <option>default</option> 
                </select>
            </form>

            <div class="hilightDemo">
                <pre><code class="php">_<?php echo __('credit', 'syng'); ?>: 'HighLight JS',</code>
                </pre>
            </div>
            <?php
            echo $after_widget;
        endif;
    }

    /**
     * Mise à jour des données sauvegardées en backoffice
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance       Données brutes du formulaire du backoffice
     * @param array $old_instance       Données précédentes
     *
     * @return array                    Données filtrées à sauvegarder
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    /**
     * Formulaire du backoffice
     *
     * @see WP_Widget::form()
     *
     * @param array $instance           Données enregistrées
     */
    public function form($instance) {
        $title = (isset($instance['title']) && '' !== $instance['title']) ? $instance['title'] : __('Syntax highlighting', 'syng');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'syng'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>

        <?php
    }

}

// class myWidget
add_action('widgets_init', create_function('', 'return register_widget( "code_hightLight_widget" );'));
