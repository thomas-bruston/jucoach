<?php
$title = 'Gestion des programmes — Ju Coach Sportif';
ob_start();
?>

<div class="btn-container">
    <a href="/admin/programme/nouveau" class="btn-save">NOUVEAU PROGRAMME</a>
</div>

<div class="tableContainer">
    <table>
        <caption class="caption">Tableau des programmes</caption>
        <thead>
            <tr>
                <th scope="col">Titre</th>
                <th scope="col">Type</th>
                <th scope="col">Prix</th>
                <th scope="col">Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($programmes)): ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun programme.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($programmes as $programme): ?>
                    <tr class="tableContent">
                        <th scope="row" class="tableContentItem">
                            <?= htmlspecialchars($programme->getTitre()) ?>
                        </th>
                        <td class="tableContentItem">
                            <?= htmlspecialchars($programme->getType()) ?>
                        </td>
                        <td class="tableContentItem">
                            <?= htmlspecialchars($programme->getPrixFormate()) ?>
                        </td>
                        
                        <td class="tableContentItem">
                            <a href="/admin/programme/modifier?id=<?= (int) $programme->getId() ?>"
                               aria-label="Modifier <?= htmlspecialchars($programme->getTitre()) ?>">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
