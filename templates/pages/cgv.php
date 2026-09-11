<?php
$title           = 'CGV — Ju Coach Sportif';
$metaDescription = 'Conditions Générales de Vente de Ju Coach Sportif.';
$pageCss         = 'cgv-mentions.css';
ob_start();
?>

<div class="cgv-container">
    <h1>CONDITIONS GÉNÉRALES DE VENTE</h1>

    <h3>Objet</h3>
    <p>Les présentes conditions régissent les prestations de coaching sportif proposées par Ju Coach Sportif.</p>

    <h3>Prix</h3>
    <p>Les tarifs sont indiqués selon les formules proposées (séances, forfaits, programmes personnalisés).</p>

    <h3>Paiement</h3>
    <p>Espèces, mobile money ou tout moyen accepté par l'entreprise.</p>

    <h3>Rétractation</h3>
    <p>Annulation possible avant le début de la première séance. Une fois la prestation commencée, aucun remboursement ne pourra être exigé.</p>

    <h3>Forfaits</h3>
    <p>Forfaits personnels, non cessibles et non remboursables. Toute séance annulée moins de 24h à l'avance est due. Tout forfait commencé est intégralement dû.</p>

    <h3>Responsabilité</h3>
    <p>Le client est responsable de son état de santé. Le coach ne peut être tenu responsable d'une mauvaise exécution des exercices ou d'une omission d'informations médicales.</p>

    <h3>Litiges</h3>
    <p>En cas de litige, une solution amiable sera recherchée. À défaut, les juridictions compétentes de Madagascar seront saisies.</p>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
