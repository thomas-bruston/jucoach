<?php $title = 'Page introuvable — Ju Coach Sportif'; ?>
<?php ob_start(); ?>

<div style="text-align:center; padding: 80px 20px;">
    <h1 style="font-size: 5rem; color: #F4C52C;">404</h1>
    <h2>Page introuvable</h2>
    <p>La page que vous recherchez n'existe pas.</p>
    <a href="/" style="margin-top: 20px; display: inline-block;">Retour à l'accueil</a>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once ROOT_PATH . '/templates/layout/base.php'; ?>
