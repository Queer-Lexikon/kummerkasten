<?php
/**
 * Plugin Name: qu-askbox
 */

defined('ABSPATH') or die;


add_shortcode('askbox', 'askbox');

function askbox()
{
	include('config.php');

	$einhornfalle = "Ha! Sekundenkleber!";
	$ret = '';

	if (isset($_POST['msg']) && isset($_POST['anontoken']) && wp_verify_nonce($_POST['anontoken'], 'anonBox') && (strcmp($einhornfalle, $_POST['botfalle']) == 0)) {
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

		$ret .= '<div class="alert alert-success">Vielen Dank für deine Einsendung.</div>';

	}

	$ret .= '
							<script type="text/javascript">
								var close = function (className) {
									document.getElementsByClassName(className)[0].hidden = true;
								}
							</script>';



	if (isset($_GET['success'])) {
		$ret .= '
						<div class="success">
							<a href="javascript:close("success");" class="close">x</a>
							<strong>Danke!</strong> Deine Nachricht wurde verschickt.
						</div>';

	}

	$ret .= '<form id="ask_form" class="kummerkasten" action="';
	$ret .= get_permalink();
	$ret .= '" method="post">
				<textarea maxlength="2000" rows="5" placeholder="Hier ist Platz für deine Nachricht" name="msg"></textarea>
				<p class="form-submit"><input id="ask_btn" type="submit" value="Abschicken"></input></p>';
	$ret .= wp_nonce_field('anonBox', 'anontoken');
	$ret .= '<input type="hidden" name="botfalle" value="';
	$ret .= $einhornfalle;
	$ret .= '">
						<input type="hidden" name="epoch" value="';
	$ret .= $time;
	$ret .= '">
						<input style="display: none;" type="text" name="phone" id="phone" class="sekundenkleber"/>
						<label style="display:none;" for="phone" class="sekundenkleber" aria-role="hidden">Ich bin nur eine Botfalle, die so tut, als wolle sie Telefonnummern.</label>
					</form>




					<script type="text/javascript">
						document.body.addEventListener("keydown", function (e) {
							if (!(e.keyCode == 13 && (e.metaKey || e.ctrlKey))) return;
							var target = e.target;
							if (target.form) {
								target.form.submit();
							}
						});
						
						const ask_box = document.getElementById("ask_box");
                                                const ask_info = document.getElementById("ask_info");
                                                ask_box.addEventListener("input", () => {
                                                        if ( ask_box.value.length > 1900 ) {
                                                                ask_info.textContent = "Langsam füllt sich das hier.";
                                                        }
                                                        if ( ask_box.value.length > 1980 ) {
                                                                ask_info.textContent = "Gleich ist hier voll. Kürze oder komm zum Ende.";
                                                        }
                                                        if ( ask_box.value.length < 1900 ) {
                                                                ask_info.textContent = "Hier ist Platz für deine Frage."
                                                        }
                                                });
                                                      
					
						const ask_form = document.getElementById("ask_form");
						const ask_btn = document.getElementById("ask_btn");
						ask_form.addEventListener("submit", (ev) => {
							if (ask_btn.disabled) {
								ev.preventDefault();
								return;
							}
							ask_btn.value =  "wird gesendet...";
							ask_btn.disabled = "true";
							ask_btn.style.color = "gray";
						});
					</script>';
	return $ret;
}

add_filter('category_description', 'do_shortcode');