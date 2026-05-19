<?php
$title   = 'Nouveau mot de passe — Ju Coach Sportif';
$pageCss = 'auth.css';
ob_start();
?>

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-header">
            <h1>NOUVEAU MOT DE PASSE</h1>
            <p>Choisissez un nouveau mot de passe sécurisé</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert--error" role="alert" aria-live="polite">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="/reinitialiser-mdp" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

            <div class="form-group">
                <label for="password">Nouveau mot de passe <span aria-hidden="true">*</span></label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password"
                           placeholder="Votre nouveau mot de passe"
                           required autocomplete="new-password"
                           aria-required="true"
                           aria-describedby="password-rules">
                    <button type="button" class="toggle-password"
                            onclick="togglePassword('password', 'toggleIcon1')"
                            aria-label="Afficher ou masquer le mot de passe">
                        <i class="fa-solid fa-eye" id="toggleIcon1" aria-hidden="true"></i>
                    </button>
                </div>
                <p id="password-rules" class="password-hint">
                    10 caractères minimum — 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.
                </p>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe <span aria-hidden="true">*</span></label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirm" name="password_confirm"
                           placeholder="Confirmez votre nouveau mot de passe"
                           required autocomplete="new-password"
                           aria-required="true"
                           aria-describedby="<?= !empty($errors['password']) ? 'password-error' : '' ?>">
                    <button type="button" class="toggle-password"
                            onclick="togglePassword('password_confirm', 'toggleIcon2')"
                            aria-label="Afficher ou masquer la confirmation">
                        <i class="fa-solid fa-eye" id="toggleIcon2" aria-hidden="true"></i>
                    </button>
                </div>
                <?php if (!empty($errors['password'])): ?>
                    <span id="password-error" class="field-error" role="alert">
                        <?= htmlspecialchars($errors['password']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn--primary btn--full">VALIDER</button>

            <div class="form-footer">
                <a href="/connexion">← Retour à la connexion</a>
            </div>

        </form>
    </div>
</section>

<script src="/js/password.js"></script>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
