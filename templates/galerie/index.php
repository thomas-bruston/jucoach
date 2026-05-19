<?php
$title           = 'Galerie — Ju Coach Sportif';
$metaDescription = 'Galerie photos et vidéos de Ju Coach Sportif à Nosy Be, Madagascar.';
$pageCss         = 'galerie.css';
ob_start();
?>

<section class="galerie-section">

    <div class="galerie-header">
        <h1>GALERIE</h1>
    </div>

    <!-- Photos -->
    <?php if (!empty($photos)): ?>
        <div class="galerie-grid" aria-label="Galerie photos">
            <?php foreach ($photos as $photo): ?>
                <figure class="galerie-item">
                    <img src="/images/galerie/<?= htmlspecialchars($photo->getFichier()) ?>"
                         alt="<?= htmlspecialchars($photo->getLegende() ?? 'Photo Ju Coach Sportif') ?>"
                         loading="lazy">
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

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
