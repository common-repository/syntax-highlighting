<?php
/**
 * @package Syntax Highlighting
 * @version 0.1
 */
defined('ABSPATH') or exit();

class slwsu_syntax_highlighting_admin_form {

    /**
     * 
     */
    public static function validation() {
        if (isset($_GET['settings-updated'])) {
            delete_transient('slwsu_syntax_highlighting_options');
            ?>
            <div id="message" class="updated">
                <p><strong><?php echo __('Settings saved', 'syng') ?></strong></p>
            </div>
            <?php
        }
    }

    /**
     * 
     */
    public static function action() {
        ?>
        <a class="syntax-highlighting-modal-link" style="text-decoration:none; font-weight:bold;" href="#openModal"><?php echo __('About', 'syng'); ?> <span class="dashicons dashicons-info"></span></a>
        <?php
    }

    /**
     * 
     * @global type $current_user
     * @param type $post
     */
    public static function message($post) {
        ?>
        <div id="openModal" class="syntax-highlighting-modal">
            <div>
                <a href="#syntax-highlighting-modal-close" title="Close" class="syntax-highlighting-modal-close"><span class="dashicons dashicons-dismiss"></span></a>
                <h2><?php echo __('About', 'syng'); ?></h2>
                <p><span class="dashicons dashicons-admin-users"></span> <?php echo __('By', 'syng'); ?> <?php echo 'Steeve Lefebvre - slWsu'; ?></p>
                <p><span class="dashicons dashicons-admin-site"></span> <?php echo __('More information', 'syng'); ?> : <a href="<?php echo 'https://web-startup.fr/syntax-highlighting/'; ?>" target="_blank"><?php _e('plugin page', 'syng'); ?></a></p>
                <p><span class="dashicons dashicons-admin-tools"></span> <?php echo __('Development for the web', 'syng'); ?> : HTML, PHP, JS, WordPress</p>
                <h2><?php echo __('Support', 'syng'); ?></h2>
                <p><span class="dashicons dashicons-email-alt"></span> <?php echo __('Ask your question', 'syng'); ?></p>
                <?php
                if (isset($post['submit'])) {
                    global $current_user; $to = 'steeve.lfbvr@gmail.com'; $subject = "Support Grouper !!!";
                    $roles = implode(", ", $current_user->roles);
                    $message = "From: " . get_bloginfo('name') . " - " . get_bloginfo('home') . " - " . get_bloginfo('admin_email') . "\n";
                    $message .= "By : " . strip_tags($post['nom']) . " - " . $post['email'] . " - " . $roles . "\n";
                    $message .= strip_tags($post['message']) . "\n";
                    if (wp_mail($to, $subject, $message)):
                        echo '<p class="syntax-highlighting-contact-valide"><strong>' . __('Your message has been sent !', 'syng') . '</strong></p>';
                    else:
                        echo '<p class="syntax-highlighting-contact-error">' . __('Something went wrong, go back and try again !', 'syng') . '</p>';
                    endif;
                }
                ?>
                <form id="syntax-highlighting-contact" action="" method="post">
                    <fieldset>
                        <input id="nom" name="nom" type="text" placeholder="<?php echo __('Your name', 'syng'); ?>" required="required">
                    </fieldset>
                    <fieldset>
                        <input id="email" name="email" type="email" placeholder="<?php echo __('Your Email Address', 'syng'); ?>" required="required">
                    </fieldset>
                    <fieldset>
                        <textarea id="message" name="message" placeholder="<?php echo __('Formulate your support request or feature proposal here...', 'syng'); ?>" required="required"></textarea>
                    </fieldset>
                    <fieldset>
                        <input id="submit" name="submit" type="submit" value="<?php echo __('Send', 'syng'); ?>" class="button button-primary" type="submit" id="syntax-highlighting-contact-submit" data-submit="...Sending" />
                    </fieldset>
                </form>
            </div>
        </div>
        <?php
    }

}
