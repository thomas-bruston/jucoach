<?php
$title           = 'Mentions Légales — Ju Coach Sportif';
$metaDescription = 'Mentions légales de Ju Coach Sportif.';
$pageCss         = 'cgv-mentions.css';
ob_start();
?>

<div class="cgv-container">
    <h1>MENTIONS LÉGALES</h1>

    <ul>
        <li><strong>Nom de l'entreprise :</strong> Ju Coach Sportif</li>
        <li><strong>Forme juridique :</strong> SARLU</li>
        <li><strong>Siège social :</strong> Nosy Be, Madagascar</li>
        <li><strong>Téléphone :</strong> +261 32 820 99 85</li>
        <li><strong>Email :</strong> <a href="mailto:jucoaching@outlook.com">jucoaching@outlook.com</a></li>
        <li><strong>Directeur de publication :</strong> Julien Fachan</li>
        <li><strong>Hébergeur :</strong> Hostinger</li>
    </ul>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
