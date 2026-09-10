<?php
$title           = 'Site Partenaire — Ju Coach Sportif';
$metaDescription = 'Envie de cours en présentiel à Nosy Be ? Réservez votre séance personnalisée en salle ou à domicile.';
$pageCss         = 'partenaire.css';
ob_start();
?>

<section class="partenaire-section">

    <div class="partenaire-hero">
        <img src="/images/banner.png"
             alt="Salle de sport à Nosy Be, Madagascar"
             class="partenaire-hero__image">
    </div>

    <div class="partenaire-container">

        <div class="partenaire-card">
            <h1>Envie de cours en présentiel à Nosy Be ?</h1>
            <p>Réservez votre séance personnalisée en salle ou à domicile directement sur le site de Julien.</p>
            <a href="https://www.jucoachsportif.com/"
               class="btn btn--primary"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Visiter le site jucoachsportif.com (nouvel onglet)">
                RÉSERVER MA SÉANCE
            </a>
        </div>

    </div>

</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>