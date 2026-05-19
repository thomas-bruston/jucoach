<?php
$title   = 'Mon programme — Ju Coach Sportif';
$pageCss = 'user.css';
ob_start();
?>

<section class="user-section">
    <div class="user-container">

        <div class="auth-header">
            <h1>MON PROGRAMME</h1>
        </div>

        <?php if (empty($commandes)): ?>
            <div class="user-empty">
                <p>Vous n'avez pas encore choisi de programme.</p>
                <a href="/programmes" class="btn btn--primary">Découvrir les programmes</a>
            </div>
        <?php else: ?>
            <div class="user-commandes">
                <?php foreach ($commandes as $commande): ?>
                   <article class="commande-card" aria-label="<?= htmlspecialchars($commande->getProgrammeTitre()) ?>">
                            <div class="commande-card__header">
                                <h2 class="commande-card__titre">
                                    <?= htmlspecialchars($commande->getProgrammeTitre()) ?>
                                </h2>
                            </div>
                            <div class="commande-card__footer">
                                <p class="commande-card__info">
                                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                    Julien vous contactera par mail ou WhatsApp pour vous transmettre votre programme personnalisé.
                                </p>
                            </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
