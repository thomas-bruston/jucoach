<?php
$title           = 'Mentions Légales — Ju Coach Sportif';
$metaDescription = 'Mentions légales de Ju Coach Sportif.';
$pageCss         = 'cgv-mentions.css';
ob_start();
?>

<div class="cgv-container">
    <h1>MENTIONS LÉGALES</h1>
    <p>Mentions légales à mettre ici</p>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
