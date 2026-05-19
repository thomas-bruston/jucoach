<?php
$title = 'Statistiques — Ju Coach Sportif';
ob_start();
?>

<div class="btn-container">
    <h2 class="main-btn">STATISTIQUES</h2>
</div>

<!-- Filtre par période -->
<div class="stats-filtres">
    <form method="GET" action="/admin/statistiques">
        <label for="date_debut">Du</label>
        <input type="date" id="date_debut" name="date_debut"
               value="<?= htmlspecialchars($dateDebut) ?>">
        <label for="date_fin">Au</label>
        <input type="date" id="date_fin" name="date_fin"
               value="<?= htmlspecialchars($dateFin) ?>">
        <button type="submit" class="btn-save">Filtrer</button>
    </form>
</div>

<div class="container">

    <!-- TABLEAU -->
    <div class="table-section">
        <table>
            <caption class="table-caption">TABLEAU DES VENTES PAR PROGRAMME</caption>
            <thead>
                <tr>
                    <th scope="col">Programme</th>
                    <th scope="col">Type</th>
                    <th scope="col">Nb ventes</th>
                    <th scope="col">CA (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($statsParProgramme)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Aucune donnée sur cette période.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($statsParProgramme as $stat): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($stat['programme_titre']) ?></th>
                            <td><?= htmlspecialchars($stat['programme_type']) ?></td>
                            <td class="nbCommande"><?= (int) $stat['nb_commandes'] ?></td>
                            <td class="total"><?= number_format((float) $stat['ca_total'], 2, ',', ' ') ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total">
                        <th scope="row" colspan="2">TOTAL</th>
                        <td><?= array_sum(array_column($statsParProgramme, 'nb_commandes')) ?></td>
                        <td><?= number_format((float) $ca_total, 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- GRAPHIQUE -->
    <div class="chart-section">
        <div class="chart-title">GRAPHIQUE DES VENTES PAR PROGRAMME</div>
        <div style="height: 400px;">
            <canvas id="graphiqueStats"
                    role="img"
                    aria-label="Graphique barres — ventes par programme"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    'use strict';
    const labels   = <?= json_encode(array_column($statsParProgramme, 'programme_titre')) ?>;
    const nbVentes = <?= json_encode(array_column($statsParProgramme, 'nb_commandes')) ?>;

    new Chart(document.getElementById('graphiqueStats').getContext('2d'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Nb ventes',
                data: nbVentes,
                backgroundColor: '#F4C52C',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true }
            },
            scales: {
                x: { beginAtZero: true },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
})();
</script>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
