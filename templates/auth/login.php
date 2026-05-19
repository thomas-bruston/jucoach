<?php
$title       = 'Connexion — Ju Coach Sportif';
$pageCss     = 'auth.css';
ob_start();
?>

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-header">
            <h1>SE CONNECTER</h1>
            <p>Accédez à votre espace personnel</p>
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

        <form class="auth-form" method="POST" action="/connexion" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="form-group">
                <label for="email">Votre e-mail</label>
                <input type="email" id="email" name="email"
                       placeholder="votre@email.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                       required autocomplete="email"
                       aria-required="true">
            </div>

            <div class="form-group">
                <label for="password">Votre mot de passe</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password"
                           placeholder="Mot de passe"
                           required autocomplete="current-password"
                           aria-required="true">
                    <button type="button" class="toggle-password"
                            onclick="togglePassword('password', 'toggleIcon1')"
                            aria-label="Afficher ou masquer le mot de passe">
                        <i class="fa-solid fa-eye" id="toggleIcon1" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="form-links">
                <a href="/mot-de-passe-oublie">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn btn--primary btn--full">CONNEXION</button>

            <div class="form-footer">
                <a href="/inscription">Pas encore inscrit ? Créer un compte</a>
            </div>

        </form>
    </div>
</section>

<script src="/js/password.js"></script>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
