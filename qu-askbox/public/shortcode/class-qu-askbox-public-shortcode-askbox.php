<?php
/**
 * Shortcode [askbox] class
 * 
 * handels the logic of the shortcode
 *
 * @package    Qu_Askbox
 * @subpackage Qu_Askbox/public/shortcode
 */

class QU_Askbox_Public_Shortcode_Askbox
{
    public function run() {
        // do not execute in admin
        if (is_admin()) {
            return '';
        }

        /**
         * Require config. Will be replaced with admin config stuff
         * @see https://github.com/Queer-Lexikon/kummerkasten/issues/1
         *
         * @var     string      $notification_mail
         * @var     string      $spam_mail
         * @var     string      $send_mail_for_spam_entries
         * @var     string      $post_title
         * @var     string      $mail_title
         * @var     int         $post_category
         * @var     int         $post_author
         * @var     int         $post_thumbnail_id
         */

        $output = '';

        $unicornTrap = "Ha! Sekundenkleber!";


        if (isset($_POST['msg']) && isset($_POST['anontoken']) && wp_verify_nonce($_POST['anontoken'], 'anonBox') && (strcmp($unicornTrap, $_POST['botfalle']) == 0)) {
            $spam = 0;
            if (isset($_POST['epoch']) && intval($_SERVER['REQUEST_TIME']) - intval($_POST['epoch']) < 30) {
                $spam = 1;
            }
            if (isset($_POST['phone']) && !empty($_POST['phone'])) {
                $spam = 1;
            }
            if (isset($_POST['msg']) && empty(trim($_POST['msg']))) {
                $spam = 1;
            }

            $message = (string) $_POST['msg'];
            $draft = htmlspecialchars($message);
            $draft = nl2br($draft);
            $draft = "<!-- wp:quote --><blockquote class='wp-block-quote'><p>" . $draft . "</p></blockquote><!-- /wp:quote --><!-- wp:paragraph --><p>Antwort kommt hier</p><!-- /wp:paragraph -->";
            $category = get_category($post_category);
            $postCount = $category->count;
            $postarr = array(
                'post_title' => "Kummerkastenantwort ?" . $postCount . "?",
                'post_content' => $draft,
                'post_author' => $post_author,
                'post_category' => array($post_category)
            );

            $postId = "SPAM";
            if (!$spam) {
                $mail = $notification_mail;
                $postId = wp_insert_post($postarr);
                if (isset($post_thumbnail_id)) {
                    set_post_thumbnail($postId, $post_thumbnail_id);
                }
            }
            $subject = '[' . $postId . '] ' . $mail_title;
            $fullmessage = $message . "\n\n " . get_site_url() . "/wp-admin/post.php?action=edit&post=" . $postId;

            if ($spam && $send_mail_for_spam_entries) {
                $mail = $spam_mail;
                $fullmessage = $fullmessage . "\n\n das war wohl spam \n" . var_export($_POST, true) . var_export($_SERVER, true);
            }

            if (!$spam || $send_mail_for_spam_entries) {
                wp_mail($mail, $subject, $fullmessage, 'Content-Type: text/plain; charset=UTF-8');
            }

            $success = true;
        }


        $template = WP_PLUGIN_DIR . '/qu-askbox/public/partials/shortcode/qu-askbox-public-shortcode-askbox.php';
        $template = apply_filters('qu_askbox_shortcode_template', $template);

        if (!file_exists($template)) {
            return '';
        }

        ob_start();
        include $template;
        $output .= ob_get_clean();

        return $output;
    }
}