<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Ju Coach Sportif — Programmes de coaching personnalisés en salle, à domicile et nutrition. Basé à Nosy Be, Madagascar.') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/webp" href="/images/ju2.webp">
    <?php
    // Icônes Font Awesome utilisées sur le site : dumbbell, image, location-dot,
    // power-off, circle-user (solid + regular), comment-dots, whatsapp, instagram,
    // facebook-f, eye, pen, trash. On ne charge que les feuilles de style nécessaires
    // (fontawesome + solid + regular + brands) au lieu du bundle complet "all.min.css",
    // et en chargement non bloquant car ce sont des icônes décoratives (aria-hidden).
    $faBase = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/';
    foreach (['fontawesome.min.css', 'solid.min.css', 'regular.min.css', 'brands.min.css'] as $faFile):
    ?>
    <link rel="preload" as="style" class="fa-preload" href="<?= $faBase . $faFile ?>"
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <?php endforeach; ?>
    <script nonce="<?= CSP_NONCE ?>">
        document.querySelectorAll('link.fa-preload').forEach(function (link) {
            link.addEventListener('load', function () {
                link.rel = 'stylesheet';
            }, { once: true });
        });
    </script>
    <noscript>
        <link rel="stylesheet" href="<?= $faBase ?>fontawesome.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="<?= $faBase ?>solid.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="<?= $faBase ?>regular.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="<?= $faBase ?>brands.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    </noscript>
    <link rel="stylesheet" href="/css/main.css">

    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="/css/<?= htmlspecialchars($pageCss) ?>">
    <?php endif; ?>

    <?php if (!empty($extraCss)): ?>
    <link rel="stylesheet" href="/css/<?= htmlspecialchars($extraCss) ?>">
    <?php endif; ?>
   
    <title><?= htmlspecialchars($title ?? 'Ju Coach Sportif') ?></title>
</head>

<body>

<?php require_once ROOT_PATH . '/templates/layout/header.php'; ?>

<!-- Flash messages -->
<?php
$flashSuccess = \Core\Session::getFlash('success');
$flashError   = \Core\Session::getFlash('error');
?>
<?php if ($flashSuccess): ?>
    <div class="flash flash--success" id="flashMsg" role="alert" aria-live="polite">
        <?= htmlspecialchars($flashSuccess) ?>
    </div>
<?php endif; ?>
<?php if ($flashError): ?>
    <div class="flash flash--error" id="flashMsg" role="alert" aria-live="polite">
        <?= htmlspecialchars($flashError) ?>
    </div>
<?php endif; ?>
<?php if ($flashSuccess || $flashError): ?>
    <script nonce="<?= CSP_NONCE ?>">
        setTimeout(() => {
            const el = document.getElementById('flashMsg');
            if (el) el.style.display = 'none';
        }, 4000);
    </script>
<?php endif; ?>

<!-- Contenu de la page -->
<main>
    <?= $content ??'' ?>
</main>

<?php require_once ROOT_PATH . '/templates/layout/footer.php'; ?>

<script src="/js/header.js"></script>

<?php if (!empty($pageJs)): ?>
<script src="/js/<?= htmlspecialchars($pageJs) ?>"></script>
<?php endif; ?>

<?php if (!empty($extraJs)): ?>
<script src="/js/<?= htmlspecialchars($extraJs) ?>"></script>
<?php endif; ?>


</body>
</html>
