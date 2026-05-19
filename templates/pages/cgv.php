<?php
$title           = 'CGV — Ju Coach Sportif';
$metaDescription = 'Conditions Générales de Vente de Ju Coach Sportif.';
$pageCss         = 'cgv-mentions.css';
ob_start();
?>

<div class="cgv-container">
    <h1>CONDITIONS GÉNÉRALES DE VENTE</h1>
    <p>CGV à mettre ici</p>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
