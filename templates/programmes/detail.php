<?php
$title           = htmlspecialchars($programme->getTitre()) . ' — Ju Coach Sportif';
$metaDescription = 'Découvrez le programme ' . htmlspecialchars($programme->getTitre()) . ' de Ju Coach Sportif.';
$pageCss         = 'programmes.css';
ob_start();
?>

<section class="programme-detail-section">

    <div class="programme-detail-container">

        <?php if ($programme->isRecommande()): ?>
            <div class="programme-detail__badge">⭐ Offre recommandée</div>
        <?php endif; ?>

        <div class="programme-detail__images">
            <img src="/images/leftcard.webp" alt="" aria-hidden="true"
                 class="programme-detail__img" loading="lazy">
            <img src="/images/rightcard.webp" alt="" aria-hidden="true"
                 class="programme-detail__img" loading="lazy">
        </div>

        <div class="programme-detail__body">

            <h1 class="programme-detail__titre">
                <?= htmlspecialchars($programme->getTitre()) ?>
            </h1>

            <p class="programme-detail__description">
                <?= htmlspecialchars($programme->getDescription()) ?>
            </p>

            <?php if ($programme->getObjectifs()): ?>
                <div class="programme-detail__section">
                    <h2>Objectifs</h2>
                    <ul class="programme-detail__liste">
                        <?php foreach (array_filter(explode("\n", $programme->getObjectifs()), fn($l) => trim($l) !== '') as $item): ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($programme->getInclut()): ?>
                <div class="programme-detail__section">
                    <h2>Inclut</h2>
                    <ul class="programme-detail__liste">
                        <?php foreach (array_filter(explode("\n", $programme->getInclut()), fn($l) => trim($l) !== '') as $item): ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($programme->getTarifs()): ?>
                <div class="programme-detail__section">
                    <h2>Tarif</h2>
                    <ul class="programme-detail__liste programme-detail__liste--tarifs">
                        <?php foreach (array_filter(explode("\n", $programme->getTarifs()), fn($l) => trim($l) !== '') as $item): ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="programme-detail__actions">
                <?php if (\Core\Session::isLoggedIn()): ?>
                    <form method="POST" action="/programme/choisir">
                        <input type="hidden" name="csrf_token"
                               value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                        <input type="hidden" name="programme_id"
                               value="<?= (int) $programme->getId() ?>">
                        <button type="submit" class="btn btn--primary btn--full">
                            CHOISIR CE PROGRAMME
                        </button>
                    </form>
                <?php else: ?>
                    <a href="/connexion" class="btn btn--primary btn--full">
                        SE CONNECTER POUR CHOISIR CE PROGRAMME
                    </a>
                <?php endif; ?>
                <a href="/programmes" class="btn btn--outline btn--full">
                    ← Retour aux programmes
                </a>
            </div>

        </div>

    </div>

</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
