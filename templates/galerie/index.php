<?php
$title           = 'Galerie — Ju Coach Sportif';
$metaDescription = 'Galerie photos et vidéos de Ju Coach Sportif à Nosy Be, Madagascar.';
$pageCss         = 'galerie.css';
$pageJs          = 'galerie.js';
ob_start();
?>

<section class="galerie-section">

    <div class="galerie-header">
        <h1>PHOTOS</h1>
    </div>

    <!-- Photos -->
    <?php if (!empty($photos)): ?>
        <div class="galerie-grid" aria-label="Galerie photos">
            <?php foreach ($photos as $photo): ?>
                <figure class="galerie-item">
                    <img src="/images/galerie/<?= htmlspecialchars($photo->getFichier()) ?>"
                         alt="<?= htmlspecialchars($photo->getLegende() ?? 'Photo Ju Coach Sportif') ?>"
                         loading="lazy"
                         class="galerie-item__img"
                         data-legende="<?= htmlspecialchars($photo->getLegende() ?? '') ?>">
                    <?php if ($photo->getLegende()): ?>
                        <figcaption class="galerie-legende">
                            <?= htmlspecialchars($photo->getLegende()) ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="galerie-empty">Aucune photo disponible pour le moment.</p>
    <?php endif; ?>

    <!-- Vidéos YouTube -->
    <?php if (!empty($videos)): ?>
        <div class="galerie-videos" aria-label="Galerie vidéos">
            <h2>VIDÉOS</h2>
            <div class="galerie-videos-grid">
                <?php foreach ($videos as $video): ?>
                    <figure class="galerie-video-item">
                        <iframe
                            src="<?= htmlspecialchars($video->getEmbedUrl()) ?>"
                            title="<?= htmlspecialchars($video->getTitre()) ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                        <figcaption><?= htmlspecialchars($video->getTitre()) ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</section>

<!-- Lightbox photo -->
<div id="lightbox" class="lightbox" aria-hidden="true">
    <button type="button" class="lightbox__close" aria-label="Fermer">&times;</button>
    <button type="button" class="lightbox__prev" aria-label="Photo précédente">&#8592;</button>
    <img class="lightbox__img" src="" alt="">
    <button type="button" class="lightbox__next" aria-label="Photo suivante">&#8594;</button>
    <p class="lightbox__legende"></p>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
