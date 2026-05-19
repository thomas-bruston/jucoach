<?php
$title   = 'Mot de passe oublié — Ju Coach Sportif';
$pageCss = 'auth.css';
ob_start();
?>

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-header">
            <h1>MOT DE PASSE OUBLIÉ</h1>
            <p>Entrez votre e-mail pour recevoir un lien de réinitialisation</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert--error" role="alert" aria-live="polite">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php $success = \Core\Session::getFlash('success'); if ($success): ?>
            <div class="alert alert--success" role="alert" aria-live="polite">
                <p><?= htmlspecialchars($success) ?></p>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="/mot-de-passe-oublie" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="form-group">
                <label for="email">Votre e-mail</label>
                <input type="email" id="email" name="email"
                       placeholder="votre@email.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                       required autocomplete="email"
                       aria-required="true">
            </div>

            <button type="submit" class="btn btn--primary btn--full">ENVOYER LE LIEN</button>

            <div class="form-footer">
                <a href="/connexion">← Retour à la connexion</a>
            </div>

        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
