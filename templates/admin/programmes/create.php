<?php
$title = 'Nouveau programme — Ju Coach Sportif';
ob_start();
?>

<div class="edit-form-content">
    <h2>Créer un programme</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/programme/nouveau" novalidate>

        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="form-group">
            <label for="type">Type <span aria-hidden="true">*</span></label>
            <select id="type" name="type" required aria-required="true">
                <option value="">-- Sélectionner --</option>
                <option value="domicile_salle">Domicile / Salle</option>
                <option value="nutritionnel">Suivi Nutritionnel</option>
                <option value="pack">Pack Sport + Nutrition</option>
                <option value="transformation">Transformation 3 Mois</option>
                <option value="visio">Coaching Visio</option>
                <option value="complet">Coaching Complet</option>
                <option value="intensif">Suivi Intensif Premium</option>
            </select>
        </div>

        <div class="form-group">
            <label for="titre">Titre <span aria-hidden="true">*</span></label>
            <input type="text" id="titre" name="titre"
                   required aria-required="true">
        </div>

        <div class="form-group">
            <label for="description">Description <span aria-hidden="true">*</span></label>
            <textarea id="description" name="description"
                      rows="3" required aria-required="true"
                      placeholder="Texte d'introduction du programme..."></textarea>
        </div>

        <div class="form-group">
            <label for="objectifs">Objectifs (une ligne par objectif)</label>
            <textarea id="objectifs" name="objectifs" rows="4"
                      placeholder="Perte de poids&#10;Prise de masse&#10;Remise en forme"></textarea>
        </div>

        <div class="form-group">
            <label for="inclut">Inclut (une ligne par élément)</label>
            <textarea id="inclut" name="inclut" rows="4"
                      placeholder="Programme d'entraînement personnalisé&#10;Suivi hebdomadaire via WhatsApp"></textarea>
        </div>

        <div class="form-group">
            <label for="tarifs">Tarifs</label>
            <textarea id="tarifs" name="tarifs" rows="3"
                      placeholder="50€ le premier mois&#10;40€ / mois en prolongation"></textarea>
        </div>

        <div class="form-group">
            <label for="prix">Prix (€) <span aria-hidden="true">*</span></label>
            <input type="number" id="prix" name="prix"
                   min="0" step="0.01"
                   required aria-required="true">
        </div>


        <div class="form-buttons">
            <button type="submit" class="btn-save">CRÉER LE PROGRAMME</button>
            <a href="/admin/programmes" class="btn-cancel">Annuler</a>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
