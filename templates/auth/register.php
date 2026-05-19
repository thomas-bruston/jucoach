<?php
$title   = 'Inscription — Ju Coach Sportif';
$pageCss = 'auth.css';
ob_start();
?>

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-header">
            <h1>CRÉER UN COMPTE</h1>
            <p>Rejoignez la communauté !</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert--error" role="alert" aria-live="polite">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="/inscription" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom <span aria-hidden="true">*</span></label>
                    <input type="text" id="nom" name="nom"
                           placeholder="Votre nom"
                           value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
                           required autocomplete="family-name"
                           aria-required="true"
                           aria-describedby="<?= !empty($errors['nom']) ? 'nom-error' : '' ?>">
                    <?php if (!empty($errors['nom'])): ?>
                        <span id="nom-error" class="field-error" role="alert"><?= htmlspecialchars($errors['nom']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom <span aria-hidden="true">*</span></label>
                    <input type="text" id="prenom" name="prenom"
                           placeholder="Votre prénom"
                           value="<?= htmlspecialchars($old['prenom'] ?? '') ?>"
                           required autocomplete="given-name"
                           aria-required="true"
                           aria-describedby="<?= !empty($errors['prenom']) ? 'prenom-error' : '' ?>">
                    <?php if (!empty($errors['prenom'])): ?>
                        <span id="prenom-error" class="field-error" role="alert"><?= htmlspecialchars($errors['prenom']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email">E-mail <span aria-hidden="true">*</span></label>
                <input type="email" id="email" name="email"
                       placeholder="votre@email.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                       required autocomplete="email"
                       aria-required="true">
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone <span aria-hidden="true">*</span></label>
                <input type="tel" id="telephone" name="telephone"
                       placeholder="+33 6 12 34 56 78"
                       value="<?= htmlspecialchars($old['telephone'] ?? '') ?>"
                       required autocomplete="tel"
                       aria-required="true">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse"
                       placeholder="Votre adresse"
                       value="<?= htmlspecialchars($old['adresse'] ?? '') ?>"
                       autocomplete="street-address">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe <span aria-hidden="true">*</span></label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password"
                           placeholder="Mot de passe"
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
                           placeholder="Confirmation"
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

            <button type="submit" id="submit-btn" class="btn btn--primary btn--full">S'INSCRIRE</button>

            <div class="form-footer">
                <a href="/connexion">Déjà inscrit ? Se connecter</a>
            </div>

        </form>
    </div>
</section>

<script src="/js/password.js"></script>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>