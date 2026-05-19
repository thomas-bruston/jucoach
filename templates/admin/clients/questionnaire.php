<?php
$title   = 'Questionnaire — ' . htmlspecialchars($client->getPrenom() . ' ' . $client->getNom());
$pageJs  = null;
$pageCss = 'questionnaire-admin.css';
ob_start();
/** @var \Entity\Questionnaire|null $questionnaire */
/** @var \Entity\User $client */
?>

<div class="btn-container">
    <a href="/admin/clients" class="btn-cancel">← Retour aux clients</a>
    <h2 class="main-btn">
        Questionnaire de <?= htmlspecialchars($client->getPrenom() . ' ' . $client->getNom()) ?>
    </h2>
</div>

<?php if ($questionnaire === null): ?>
    <div class="qadmin-container">
        <p class="qadmin-empty">Ce client n'a pas encore rempli son questionnaire.</p>
    </div>
<?php else: ?>
    <div class="qadmin-container">

        <!-- Informations personnelles -->
        <div class="qadmin-section">
            <h3 class="qadmin-section__titre">Informations personnelles</h3>
            <div class="qadmin-grid">
                <div class="qadmin-item">
                    <span class="qadmin-label">Âge</span>
                    <span class="qadmin-value"><?= $questionnaire->getAge() ? (int) $questionnaire->getAge() . ' ans' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Genre</span>
                    <span class="qadmin-value"><?= htmlspecialchars(str_replace('_', ' ', $questionnaire->getGenre() ?? '—')) ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Taille</span>
                    <span class="qadmin-value"><?= $questionnaire->getTaille() ? (int) $questionnaire->getTaille() . ' cm' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Poids</span>
                    <span class="qadmin-value"><?= $questionnaire->getPoids() ? htmlspecialchars((string)$questionnaire->getPoids()) . ' kg' : '—' ?></span>
                </div>
            </div>
        </div>

        <!-- Objectifs -->
        <div class="qadmin-section">
            <h3 class="qadmin-section__titre">Objectifs</h3>
            <div class="qadmin-grid">
                <div class="qadmin-item">
                    <span class="qadmin-label">Objectif principal</span>
                    <span class="qadmin-value"><?= htmlspecialchars(str_replace('_', ' ', $questionnaire->getObjectifPrincipal() ?? '—')) ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Délai souhaité</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getObjectifDelai() ?? '—') ?></span>
                </div>
            </div>
            <?php if ($questionnaire->getObjectifDescription()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Description</span>
                    <p><?= htmlspecialchars($questionnaire->getObjectifDescription()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getObjectifImportance()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Importance</span>
                    <p><?= htmlspecialchars($questionnaire->getObjectifImportance()) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Condition physique -->
        <div class="qadmin-section">
            <h3 class="qadmin-section__titre">Condition physique</h3>
            <div class="qadmin-grid">
                <div class="qadmin-item">
                    <span class="qadmin-label">Condition physique</span>
                    <span class="qadmin-value"><?= $questionnaire->getConditionPhysique() ? (int) $questionnaire->getConditionPhysique() . '/10' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Pratique sportive</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getPratiqueSport() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Ressenti corps (note)</span>
                    <span class="qadmin-value"><?= $questionnaire->getResentiCorpsNote() ? (int) $questionnaire->getResentiCorpsNote() . '/10' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Qualité du sommeil</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getQualiteSommeil() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Niveau de stress</span>
                    <span class="qadmin-value"><?= $questionnaire->getNiveauStress() ? (int) $questionnaire->getNiveauStress() . '/10' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Activité professionnelle</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getActiviteProfessionnelle() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Profession</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getProfession() ?? '—') ?></span>
                </div>
            </div>
            <?php if ($questionnaire->getHistoriqueSport()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Historique sportif</span>
                    <p><?= htmlspecialchars($questionnaire->getHistoriqueSport()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getResentiCorps()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Ressenti corps</span>
                    <p><?= htmlspecialchars($questionnaire->getResentiCorps()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getQualiteSommeilDescription()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Qualité sommeil (détail)</span>
                    <p><?= htmlspecialchars($questionnaire->getQualiteSommeilDescription()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getNiveauStressDescription()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Stress (détail)</span>
                    <p><?= htmlspecialchars($questionnaire->getNiveauStressDescription()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getBlessuresDouleurs()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Blessures / douleurs</span>
                    <p><?= htmlspecialchars($questionnaire->getBlessuresDouleurs()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getProblemesSante()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Problèmes de santé</span>
                    <p><?= htmlspecialchars($questionnaire->getProblemesSante()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getChangementPrioritaire()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Changement prioritaire</span>
                    <p><?= htmlspecialchars($questionnaire->getChangementPrioritaire()) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Nutrition -->
        <div class="qadmin-section">
            <h3 class="qadmin-section__titre">Nutrition</h3>
            <div class="qadmin-grid">
                <div class="qadmin-item">
                    <span class="qadmin-label">Alimentation</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getAlimentation() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Note alimentation</span>
                    <span class="qadmin-value"><?= $questionnaire->getAlimentationNote() ? (int) $questionnaire->getAlimentationNote() . '/10' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Note hydratation</span>
                    <span class="qadmin-value"><?= $questionnaire->getHydratationNote() ? (int) $questionnaire->getHydratationNote() . '/10' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Tendance alimentaire</span>
                    <span class="qadmin-value"><?= htmlspecialchars(str_replace('_', ' ', $questionnaire->getTendanceAlimentaire() ?? '—')) ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Consommation alcool</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getConsommationAlcool() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Régime particulier</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getRegimeParticulier() ?? '—') ?></span>
                </div>
            </div>
            <?php if ($questionnaire->getDifficulteAlimentaire()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Difficultés alimentaires</span>
                    <p><?= htmlspecialchars($questionnaire->getDifficulteAlimentaire()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getAllergies()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Allergies</span>
                    <p><?= htmlspecialchars($questionnaire->getAllergies()) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Entraînement -->
        <div class="qadmin-section">
            <h3 class="qadmin-section__titre">Entraînement</h3>
            <div class="qadmin-grid">
                <div class="qadmin-item">
                    <span class="qadmin-label">Lieu d'entraînement</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getLieuEntrainement() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Durée de séance</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getDureeSeance() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Niveau de motivation</span>
                    <span class="qadmin-value"><?= $questionnaire->getNiveauMotivation() ? (int) $questionnaire->getNiveauMotivation() . '/10' : '—' ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Programme structuré</span>
                    <span class="qadmin-value"><?= htmlspecialchars($questionnaire->getProgrammeStructureSuivi() ?? '—') ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Changements mode de vie</span>
                    <span class="qadmin-value"><?= htmlspecialchars(str_replace('_', ' ', $questionnaire->getChangementsModeVie() ?? '—')) ?></span>
                </div>
                <div class="qadmin-item">
                    <span class="qadmin-label">Date début souhaitée</span>
                    <span class="qadmin-value"><?= htmlspecialchars(str_replace('_', ' ', $questionnaire->getDateDebutSouhaitee() ?? '—')) ?></span>
                </div>
            </div>
            <?php if ($questionnaire->getSentimentBlockage()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Sentiment de blocage</span>
                    <p><?= htmlspecialchars($questionnaire->getSentimentBlockage()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getBlocageRaison()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Raison du blocage</span>
                    <p><?= htmlspecialchars($questionnaire->getBlocageRaison()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getPratiqueIrreguliere()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Pratique irrégulière</span>
                    <p><?= htmlspecialchars($questionnaire->getPratiqueIrreguliere()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getProgrammeCeQuiFonctionne()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Ce qui fonctionne</span>
                    <p><?= htmlspecialchars($questionnaire->getProgrammeCeQuiFonctionne()) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($questionnaire->getProgrammeCeQuiEchoue()): ?>
                <div class="qadmin-texte">
                    <span class="qadmin-label">Ce qui échoue</span>
                    <p><?= htmlspecialchars($questionnaire->getProgrammeCeQuiEchoue()) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <p class="qadmin-date">
            Questionnaire rempli le <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($questionnaire->getDateRempli() ?? ''))) ?>
        </p>

    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
