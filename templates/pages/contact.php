<?php
$title           = 'Contact — Ju Coach Sportif';
$metaDescription = 'Contactez Ju Coach Sportif pour toute question sur les programmes de coaching personnalisés.';
$pageCss         = 'auth.css';
ob_start();
?>

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-header">
            <h1>NOUS CONTACTER</h1>
            <p>Une question ? Je vous répond dans les plus brefs délais.</p>
        </div>

        <div id="contact-feedback" class="alert" role="alert" aria-live="polite" style="display:none;"></div>

        <form class="auth-form" id="contactForm" method="POST" action="/contact" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="form-group">
                <label for="nom">Nom <span aria-hidden="true">*</span></label>
                <input type="text" id="nom" name="nom"
                       placeholder="Votre nom"
                       required aria-required="true"
                       autocomplete="name">
            </div>

            <div class="form-group">
                <label for="email">E-mail <span aria-hidden="true">*</span></label>
                <input type="email" id="email" name="email"
                       placeholder="votre@email.com"
                       required aria-required="true"
                       autocomplete="email">
            </div>

            <div class="form-group">
                <label for="message">Message <span aria-hidden="true">*</span></label>
                <textarea id="message" name="message"
                          placeholder="Votre message..."
                          rows="5"
                          required aria-required="true"></textarea>
            </div>

            <button type="submit" id="contactSubmit" class="btn btn--primary btn--full">ENVOYER</button>

        </form>
    </div>
</section>

<script src="/js/contact.js"></script>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
