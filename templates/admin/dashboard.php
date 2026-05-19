<?php
$title = 'Espace Administrateur — Ju Coach Sportif';
ob_start();
?>

<div class="menuContainer">

    <div class="menu-top">
        <a href="/admin" class="menu-btn">Accueil admin</a>
    </div>

    <div class="menu-grid">

        <a href="/admin/clients" class="menu-btn">Clients</a>
        <a href="/admin/messages" class="menu-btn">Messages</a>

        <a href="/admin/programmes" class="menu-btn">Programmes</a>
        <a href="/admin/statistiques" class="menu-btn">Stats</a>

        <a href="/admin/galerie" class="menu-btn">Galerie</a>
        <a href="/deconnexion" class="menu-btn">Déconnexion</a>

    </div>

</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
