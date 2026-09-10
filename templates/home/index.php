<?php
$title           = 'Ju Coach Sportif — Coaching personnalisé à Nosy Be, Madagascar';
$metaDescription = 'Ju Coach Sportif — Programmes de coaching personnalisés en salle, à domicile et nutrition. Basé à Nosy Be, Madagascar.';
$pageCss         = 'home.css';
$extraCss        = 'reviews.css';
$extraJs         = 'reviews.js';
ob_start();
?>

<!-- HERO -->
<section class="hero" aria-label="Présentation">
    <img src="/images/banner.png"
         alt="Salle de sport avec coach sportif"
         class="hero__image">
</section>

<!-- PRÉSENTATION DU COACH -->
<section class="coach-section" aria-label="Présentation du coach">
    <div class="coach-container">

        <div class="coach-card">
            <img src="/images/portrait.webp"
                 alt="Portrait de Ju, coach sportif"
                 class="coach-card__portrait">
            <div class="coach-card__texte">
                <p>Coach sportif depuis 15 ans je travaille en salle de sport et à domicile afin de vous accompagner grâce à mes programmes personnalisés. Je m'adapte à votre corps, vos objectifs et vos capacités afin d'obtenir les meilleurs résultats.</p>
            </div>
        </div>

        <img src="/images/accueil.webp"
             alt="Séance de coaching"
             class="coach-section__side-img">

    </div>
</section>

<!-- ICÔNES TYPES DE PROGRAMMES -->
<section class="types-section" aria-label="Types de programmes">
    <div class="types-container">

        <div class="type-item">
            <img src="/images/icon-salle.webp"
                 alt="Programme en salle"
                 class="type-item__icon">
            <p class="type-item__label">En salle</p>
        </div>

        <div class="type-item">
            <img src="/images/icon-nutri.webp"
                 alt="Programme nutrition"
                 class="type-item__icon">
            <p class="type-item__label">Nutrition</p>
        </div>

        <div class="type-item">
            <img src="/images/icon-home.webp"
                 alt="Programme à domicile"
                 class="type-item__icon">
            <p class="type-item__label">À domicile</p>
        </div>

    </div>
</section>

<!-- CARD PROGRAMME MIS EN AVANT -->
<?php if ($programme !== null): ?>
<section class="programme-mise-en-avant" aria-label="Programme mis en avant">
    <article class="programme-card programme-card--home"
             aria-label="Programme <?= htmlspecialchars($programme->getTitre()) ?>">

        <div class="programme-card__images">
            <img src="/images/programmehome.webp"
                 alt=""
                 aria-hidden="true"
                 class="programme-card__img"
                 loading="lazy">
        </div>

        <div class="programme-card__body">
            <h2 class="programme-card__titre">
                <?= htmlspecialchars($programme->getTitre()) ?>
            </h2>

            <p class="programme-card__question">Que contient ce programme ?</p>

            <ul class="programme-card__liste" aria-label="Contenu du programme">
                <?php
                $lignes = array_filter(
                    explode("\n", $programme->getDescription()),
                    fn($l) => trim($l) !== ''
                );
                foreach ($lignes as $ligne): ?>
                    <li><?= htmlspecialchars(trim($ligne)) ?></li>
                <?php endforeach; ?>
            </ul>

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

    </article>
</section>
<?php endif; ?>

<!-- SECTION ACCROCHE -->
<section class="accroche-section" aria-label="Accroche">
    <div class="accroche-container">
        <p>Vous faites du sport…mais sans résultats ?<br>
        Manque de motivation, programmes inefficaces, entraînements irréguliers…<br>
        Sans méthode claire et sans suivi,<br>
        <strong>les progrès restent limités.</strong></p>
        <a href="/programmes" class="btn btn--primary">Trouvez votre programme</a>
    </div>
</section>

<!-- CARROUSEL AVIS GOOGLE -->
<section class="reviews-section" id="reviewsCarousel" aria-label="Avis clients Google">
    <div class="reviews-header">
        <h2>CE QUE DISENT MES CLIENTS</h2>
        <p>Avis vérifiés Google</p>
    </div>
    <div class="reviews-wrapper">
        <button class="reviews-prev" aria-label="Avis précédents">&#8592;</button>
        <div class="reviews-track" role="list"></div>
        <button class="reviews-next" aria-label="Avis suivants">&#8594;</button>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
