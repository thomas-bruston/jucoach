<?php
$title = 'Modifier le programme — ' . htmlspecialchars($programme->getTitre());
ob_start();
?>

<div class="edit-form-content">
    <h2>Modifier le programme</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/programme/modifier" novalidate>

        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <input type="hidden" name="programme_id"
               value="<?= (int) $programme->getId() ?>">

        <div class="form-group">
            <label for="type">Type <span aria-hidden="true">*</span></label>
            <select id="type" name="type" required aria-required="true">
                <option value="domicile_salle"  <?= $programme->getType() === 'domicile_salle'  ? 'selected' : '' ?>>Domicile / Salle</option>
                <option value="nutritionnel"    <?= $programme->getType() === 'nutritionnel'    ? 'selected' : '' ?>>Suivi Nutritionnel</option>
                <option value="pack"            <?= $programme->getType() === 'pack'            ? 'selected' : '' ?>>Pack Sport + Nutrition</option>
                <option value="transformation"  <?= $programme->getType() === 'transformation'  ? 'selected' : '' ?>>Transformation 3 Mois</option>
                <option value="visio"           <?= $programme->getType() === 'visio'           ? 'selected' : '' ?>>Coaching Visio</option>
                <option value="complet"         <?= $programme->getType() === 'complet'         ? 'selected' : '' ?>>Coaching Complet</option>
                <option value="intensif"        <?= $programme->getType() === 'intensif'        ? 'selected' : '' ?>>Suivi Intensif Premium</option>
            </select>
        </div>

        <div class="form-group">
            <label for="titre">Titre <span aria-hidden="true">*</span></label>
            <input type="text" id="titre" name="titre"
                   value="<?= htmlspecialchars($programme->getTitre()) ?>"
                   required aria-required="true">
        </div>

        <div class="form-group">
            <label for="description">Description <span aria-hidden="true">*</span></label>
            <textarea id="description" name="description"
                      rows="3" required aria-required="true"><?= htmlspecialchars($programme->getDescription()) ?></textarea>
        </div>

        <div class="form-group">
            <label for="objectifs">Objectifs (une ligne par objectif)</label>
            <textarea id="objectifs" name="objectifs" rows="4"><?= htmlspecialchars($programme->getObjectifs() ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="inclut">Inclut (une ligne par élément)</label>
            <textarea id="inclut" name="inclut" rows="4"><?= htmlspecialchars($programme->getInclut() ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="tarifs">Tarifs</label>
            <textarea id="tarifs" name="tarifs" rows="3"><?= htmlspecialchars($programme->getTarifs() ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="prix">Prix (€) <span aria-hidden="true">*</span></label>
            <input type="number" id="prix" name="prix"
                   value="<?= htmlspecialchars($programme->getPrix()) ?>"
                   min="0" step="0.01"
                   required aria-required="true">
        </div>


        <div class="form-buttons">
            <button type="submit" class="btn-save">ENREGISTRER</button>
            <a href="/admin/programmes" class="btn-cancel">Annuler</a>
        </div>

    </form>

    <!-- Suppression -->
    <div class="footer-btn">
        <form method="POST" action="/admin/programme/supprimer"
              onsubmit="return confirm('Désactiver ce programme ?')">
            <input type="hidden" name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="hidden" name="programme_id"
                   value="<?= (int) $programme->getId() ?>">
            <button type="submit" class="btn-supprimer">DÉSACTIVER CE PROGRAMME</button>
        </form>
    </div>

</div>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
