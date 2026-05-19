<?php
$title   = 'Mon profil — Ju Coach Sportif';
$pageCss = 'auth.css';
ob_start();
?>

<section class="auth-section">
    <div class="auth-container">

        <div class="auth-header">
            <h1>MON PROFIL</h1>
            <p>Modifiez vos informations personnelles</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert--error" role="alert" aria-live="polite">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert--success" role="alert" aria-live="polite">
                <p><?= htmlspecialchars($success) ?></p>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="/mon-profil" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom <span aria-hidden="true">*</span></label>
                    <input type="text" id="nom" name="nom"
                           placeholder="Votre nom"
                           value="<?= htmlspecialchars($user->getNom()) ?>"
                           required autocomplete="family-name"
                           aria-required="true">
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom <span aria-hidden="true">*</span></label>
                    <input type="text" id="prenom" name="prenom"
                           placeholder="Votre prénom"
                           value="<?= htmlspecialchars($user->getPrenom()) ?>"
                           required autocomplete="given-name"
                           aria-required="true">
                </div>
            </div>

            <div class="form-group">
                <label for="email">E-mail <span aria-hidden="true">*</span></label>
                <input type="email" id="email" name="email"
                       placeholder="votre@email.com"
                       value="<?= htmlspecialchars($user->getEmail()) ?>"
                       required autocomplete="email"
                       aria-required="true">
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone"
                       placeholder="+33 6 12 34 56 78"
                       value="<?= htmlspecialchars($user->getTelephone() ?? '') ?>"
                       autocomplete="tel">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse"
                       placeholder="Votre adresse"
                       value="<?= htmlspecialchars($user->getAdresse() ?? '') ?>"
                       autocomplete="street-address">
            </div>

            <button type="submit" class="btn btn--primary btn--full">ENREGISTRER</button>

        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
