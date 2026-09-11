<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/webp" href="/images/ju2.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin.css">
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="/css/<?= htmlspecialchars($pageCss) ?>">
    <?php endif; ?>
    <title><?= htmlspecialchars($title ?? 'Espace Administrateur — Ju Coach Sportif') ?></title>
</head>
<body>

<!-- HEADER ADMIN -->
<div class="admin-header">
    <h1>Bienvenue dans l'espace administrateur</h1>
</div>

<div class="btnContainer">
    <a href="/admin" class="header-btn">Accueil Admin</a>
</div>

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

<!-- Contenu -->
<?= $content ?>

<?php if (!empty($pageJs)): ?>
    <script src="/js/<?= htmlspecialchars($pageJs) ?>"></script>
<?php endif; ?>

</body>
</html>
