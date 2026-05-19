<?php
$title = 'Gestion des clients — Ju Coach Sportif';
ob_start();
?>

<div class="btn-container">
    <h2 class="main-btn">Clients</h2>
</div>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (empty($clients)): ?>
    <div class="tableContainer">
        <p style="color:var(--color-texte); padding: 20px;">Aucun client inscrit.</p>
    </div>
<?php else: ?>
    <?php foreach ($clients as $client): ?>
        <?php
        $questionnaire = $questionnaires[$client->getId()] ?? null;
        $commandesClient = $commandes[$client->getId()] ?? [];
        ?>
        <div class="client-card">

            <!-- En-tête client -->
            <div class="client-card__header">
                <div class="client-card__info">
                    <h3><?= htmlspecialchars($client->getPrenom() . ' ' . $client->getNom()) ?></h3>
                    <p>
                        <a href="mailto:<?= htmlspecialchars($client->getEmail()) ?>">
                            <?= htmlspecialchars($client->getEmail()) ?>
                        </a>
                        <?php if ($client->getTelephone()): ?>
                            · <?= htmlspecialchars($client->getTelephone()) ?>
                        <?php endif; ?>
                    </p>
                    <p class="client-card__date">
                        Inscrit le <?= htmlspecialchars(date('d/m/Y', strtotime($client->getCreatedAt() ?? ''))) ?>
                    </p>
                </div>
                <form method="POST" action="/admin/client/supprimer"
                      onsubmit="return confirm('Supprimer ce client définitivement ?')">
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="user_id" value="<?= (int) $client->getId() ?>">
                    <button type="submit" class="btn-delete"
                            aria-label="Supprimer <?= htmlspecialchars($client->getPrenom()) ?>">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <!-- Programmes choisis -->
            <div class="client-card__section">
                <h4>Programmes choisis</h4>
                <?php if (empty($commandesClient)): ?>
                    <p class="client-card__empty">Aucun programme choisi.</p>
                <?php else: ?>
                    <ul class="client-card__list">
                        <?php foreach ($commandesClient as $commande): ?>
                            <li>
                                <strong><?= htmlspecialchars($commande->getProgrammeTitre() ?? '—') ?></strong>
                                <span class="client-card__meta">
                                    — <?= htmlspecialchars(date('d/m/Y', strtotime($commande->getDate() ?? ''))) ?>
                                    — <?= htmlspecialchars(number_format($commande->getMontant(), 2)) ?>€
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Questionnaire -->
            <div class="client-card__section">
                <h4>Questionnaire sportif</h4>
                <?php if ($questionnaire === null): ?>
                    <p class="client-card__empty">Questionnaire non rempli.</p>
                <?php else: ?>
                    <a href="/admin/client/questionnaire?id=<?= (int) $client->getId() ?>"
                       class="btn-save">
                        Voir le questionnaire complet
                    </a>
                    <span class="client-card__meta" style="margin-left:12px;">
                        Rempli le <?= htmlspecialchars(date('d/m/Y', strtotime($questionnaire->getDateRempli() ?? ''))) ?>
                    </span>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
