<?php
$title           = 'Programmes — Ju Coach Sportif';
$metaDescription = 'Découvrez les programmes de coaching sportif personnalisés de Ju : domicile, salle, nutrition, visio et suivi intensif.';
$pageCss         = 'programmes.css';
$pageJs          = 'programmes.js';
ob_start();
?>

<section class="programmes-section">

    <div class="programmes-header">
        <h1>NOS PROGRAMMES</h1>
        <p>Des programmes conçus pour être pratiqués en autonomie, 100% personnalisés selon votre profil et vos objectifs.</p>
    </div>

    <!-- Filtres JS côté client -->
    <div class="programmes-filtres" role="group" aria-label="Filtrer les programmes">
        <button class="filtre-btn filtre-btn--active" data-type="tous" aria-pressed="true">Tous</button>
        <button class="filtre-btn" data-type="domicile_salle" aria-pressed="false">Entraînement</button>
        <button class="filtre-btn" data-type="nutritionnel"   aria-pressed="false">Nutrition</button>
        <button class="filtre-btn" data-type="pack"           aria-pressed="false">Pack</button>
        <button class="filtre-btn" data-type="transformation" aria-pressed="false">Transformation</button>
        <button class="filtre-btn" data-type="visio"          aria-pressed="false">Visio</button>
        <button class="filtre-btn" data-type="complet"        aria-pressed="false">Complet</button>
        <button class="filtre-btn" data-type="intensif"       aria-pressed="false">Intensif</button>
    </div>

    <!-- Cards programmes -->
    <div class="programmes-grid" id="programmesGrid">
        <?php foreach ($programmes as $programme): ?>
            <article class="programme-card <?= $programme->isRecommande() ? 'programme-card--recommande' : '' ?>"
                     data-type="<?= htmlspecialchars($programme->getType()) ?>"
                     aria-label="Programme <?= htmlspecialchars($programme->getTitre()) ?>">

                <!-- Image gauche -->
                <div class="programme-card__img-left">
                    <img src="/images/leftcard.webp"
                         alt=""
                         aria-hidden="true"
                         loading="lazy">
                </div>

                <!-- Contenu central -->
                <div class="programme-card__body">
                    <div class="programme-card__titre-wrapper">
                        <h2 class="programme-card__titre">
                            <?= htmlspecialchars($programme->getTitre()) ?>
                        </h2>
                        <?php if ($programme->isRecommande()): ?>
                            <span class="programme-card__badge">⭐ OFFRE RECOMMANDÉE</span>
                        <?php endif; ?>
                    </div>

                    <p class="programme-card__description">
                        <?= htmlspecialchars($programme->getDescription()) ?>
                    </p>

                    <?php if ($programme->getInclut()): ?>
                        <p class="programme-card__question">Que contient ce programme ?</p>
                        <ul class="programme-card__liste" aria-label="Contenu du programme">
                            <?php
                            $items = array_filter(
                                explode("\n", $programme->getInclut()),
                                fn($l) => trim($l) !== ''
                            );
                            foreach ($items as $item): ?>
                                <li><?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <p class="programme-card__accroche">Alors, tu attends quoi ?</p>

                    <div class="programme-card__footer">
                        <span class="programme-card__prix">
                            À partir de <?= htmlspecialchars($programme->getPrixFormate()) ?>
                        </span>
                        <a href="/programmes/detail?id=<?= (int) $programme->getId() ?>"
                           class="btn btn--outline"
                           aria-label="En savoir plus sur <?= htmlspecialchars($programme->getTitre()) ?>">
                            En savoir plus
                        </a>
                    </div>
                </div>

                <!-- Image droite -->
                <div class="programme-card__img-right">
                    <img src="/images/rightcard.webp"
                         alt=""
                         aria-hidden="true"
                         loading="lazy">
                </div>

            </article>
        <?php endforeach; ?>
    </div>

</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
