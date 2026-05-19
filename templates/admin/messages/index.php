<?php
$title = 'Messages — Ju Coach Sportif';
ob_start();
?>

<div class="btn-container">
    <h2 class="main-btn">Messages clients</h2>
</div>

<div class="tableContainer">
    <table>
        <caption class="caption">Tableau des messages</caption>
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun message.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($messages as $m): ?>
                    <tr class="tableContent <?= !$m->isLu() ? 'message--non-lu' : '' ?>">
                        <th scope="row" class="tableContentItem">
                            <?= htmlspecialchars($m->getNom()) ?>
                        </th>
                        <td class="tableContentItem">
                            <a href="mailto:<?= htmlspecialchars($m->getEmail()) ?>">
                                <?= htmlspecialchars($m->getEmail()) ?>
                            </a>
                        </td>
                        <td class="tableContentItem">
                            <?= nl2br(htmlspecialchars($m->getMessage())) ?>
                        </td>
                        <td class="tableContentItem">
                            <?= htmlspecialchars(date('d/m/Y H:i', strtotime($m->getDateEnvoi() ?? ''))) ?>
                        </td>
                        <td class="tableContentItem">
                            <form method="POST"
                                  action="/admin/message/supprimer"
                                  onsubmit="return confirm('Supprimer ce message ?')">
                                <input type="hidden" name="csrf_token"
                                       value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                <input type="hidden" name="contact_id"
                                       value="<?= (int) $m->getId() ?>">
                                <button type="submit" class="btn-delete"
                                        aria-label="Supprimer le message de <?= htmlspecialchars($m->getNom()) ?>">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
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
