<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/Queer-Lexikon/kummerkasten
 * @since      2.0.0
 *
 * @package    Qu_Askbox
 * @subpackage Qu_Askbox/public/partials
 *
 * @var     string      $unicornTrap
 * @var     null|bool   $success
 */
?>

<?php if ($success === true): ?>
<div class="alert alert-success"><?php _e('Vielen Dank für deine Einsendung.', 'qu-askbox'); ?></div>
<?php endif; ?>

<form id="ask_form" class="kummerkasten" action="<?php the_permalink(); ?>" method="post">
    <?php wp_nonce_field('anonBox', 'anontoken'); ?>
    <input type="hidden" name="botfalle" value="<?php $unicornTrap; ?>">
    <input type="hidden" name="epoch" value="">

    <textarea maxlength="2000" rows="5" placeholder="<?php _e('Hier ist Platz für deine Nachricht', 'qu-askbox'); ?>'" name="msg"></textarea>

    <p class="form-submit">
        <input id="ask_btn" type="submit" value="<?php _e('Abschicken', 'qu-askbox'); ?>" />
    </p>

    <input style="display:none;" type="text" name="phone" id="phone" class="sekundenkleber"/>
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
            ask_info.textContent = "<?php _e('Langsam füllt sich das hier.', 'qu-askbox'); ?>";
        }
        if ( ask_box.value.length > 1980 ) {
            ask_info.textContent = "<?php _e('Gleich ist hier voll. Kürze oder komm zum Ende.', 'qu-askbox'); ?>";
        }
        if ( ask_box.value.length < 1900 ) {
            ask_info.textContent = " _e('Hier ist Platz für deine Frage.', 'qu-askbox'); ?>"
        }
    });


    const ask_form = document.getElementById("ask_form");
    const ask_btn = document.getElementById("ask_btn");
    ask_form.addEventListener("submit", (ev) => {
        if (ask_btn.disabled) {
            ev.preventDefault();
            return;
        }
        ask_btn.value =  "<?php _e('wird gesendet...', 'qu-askbox'); ?>";
        ask_btn.disabled = "true";
        ask_btn.style.color = "gray";
    });


    var close = function (className) {
        document.getElementsByClassName(className)[0].hidden = true;
    }
</script>