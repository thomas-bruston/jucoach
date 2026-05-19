<?php
$title = 'Gestion de la galerie — Ju Coach Sportif';
ob_start();
?>

<div class="btn-container">
    <h2 class="main-btn">Galerie</h2>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?>
            <p><?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- SECTION PHOTOS -->
<div class="admin-galerie-section">
    <h2>Photos</h2>

    <div class="admin-gallery-grid">
        <?php if (empty($photos)): ?>
            <p>Aucune photo.</p>
        <?php else: ?>
            <?php foreach ($photos as $photo): ?>
                <div class="admin-gallery-item">
                    <img src="/images/galerie/<?= htmlspecialchars($photo->getFichier()) ?>"
                         alt="<?= htmlspecialchars($photo->getLegende() ?? '') ?>"
                         loading="lazy">
                    <p class="admin-gallery-titre"><?= htmlspecialchars($photo->getLegende() ?? '—') ?></p>
                    <form method="POST" action="/admin/galerie/photo/supprimer"
                          onsubmit="return confirm('Supprimer cette photo ?')">
                        <input type="hidden" name="csrf_token"
                               value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="photo_id"
                               value="<?= (int) $photo->getId() ?>">
                        <button type="submit" class="btn-delete"
                                aria-label="Supprimer la photo">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Ajouter une photo -->
    <div class="admin-add-section">
        <button class="btn-save" onclick="toggleForm('add-photo')">+ Ajouter une photo</button>
        <div id="add-photo" style="display:none; margin-top:1rem;">
            <form method="POST" action="/admin/galerie/photo/ajouter"
                  enctype="multipart/form-data" class="edit-form-content">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <div class="form-group">
                    <label for="legende">Légende (optionnel)</label>
                    <input type="text" id="legende" name="legende" placeholder="Légende de la photo">
                </div>
                <div class="form-group">
                    <label for="ordre">Ordre d'affichage</label>
                    <input type="number" id="ordre" name="ordre" value="0" min="0">
                </div>
                <div class="form-group">
                    <label for="photo">Photo (JPG, PNG, WebP — max 5 Mo) <span aria-hidden="true">*</span></label>
                    <input type="file" id="photo" name="photo"
                           accept=".jpg,.jpeg,.png,.webp" required aria-required="true">
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-save">AJOUTER</button>
                    <button type="button" class="btn-cancel"
                            onclick="toggleForm('add-photo')">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SECTION VIDÉOS -->
<div class="admin-galerie-section">
    <h2>Vidéos YouTube</h2>

    <div class="tableContainer">
        <table>
            <caption class="caption">Tableau des vidéos</caption>
            <thead>
                <tr>
                    <th scope="col">Ordre</th>
                    <th scope="col">Titre</th>
                    <th scope="col">URL</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($videos)): ?>
                    <tr><td colspan="4" class="text-center">Aucune vidéo.</td></tr>
                <?php else: ?>
                    <?php foreach ($videos as $video): ?>
                        <tr class="tableContent">
                            <td class="tableContentItem text-center"><?= (int) $video->getOrdre() ?></td>
                            <th scope="row" class="tableContentItem">
                                <?= htmlspecialchars($video->getTitre()) ?>
                            </th>
                            <td class="tableContentItem">
                                <a href="<?= htmlspecialchars($video->getUrlYoutube()) ?>"
                                   target="_blank" rel="noopener noreferrer">
                                    <?= htmlspecialchars($video->getUrlYoutube()) ?>
                                </a>
                            </td>
                            <td class="tableContentItem">
                                <form method="POST" action="/admin/galerie/video/supprimer"
                                      onsubmit="return confirm('Supprimer cette vidéo ?')">
                                    <input type="hidden" name="csrf_token"
                                           value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <input type="hidden" name="video_id"
                                           value="<?= (int) $video->getId() ?>">
                                    <button type="submit" class="btn-delete"
                                            aria-label="Supprimer la vidéo <?= htmlspecialchars($video->getTitre()) ?>">
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

    <!-- Ajouter une vidéo -->
    <div class="admin-add-section">
        <button class="btn-save" onclick="toggleForm('add-video')">+ Ajouter une vidéo</button>
        <div id="add-video" style="display:none; margin-top:1rem;">
            <form method="POST" action="/admin/galerie/video/ajouter" class="edit-form-content">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <div class="form-group">
                    <label for="titre_video">Titre <span aria-hidden="true">*</span></label>
                    <input type="text" id="titre_video" name="titre"
                           placeholder="Titre de la vidéo" required aria-required="true">
                </div>
                <div class="form-group">
                    <label for="url_youtube">URL YouTube <span aria-hidden="true">*</span></label>
                    <input type="url" id="url_youtube" name="url_youtube"
                           placeholder="https://www.youtube.com/watch?v=..."
                           required aria-required="true">
                </div>
                <div class="form-group">
                    <label for="description_video">Description (optionnel)</label>
                    <textarea id="description_video" name="description" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="ordre_video">Ordre d'affichage</label>
                    <input type="number" id="ordre_video" name="ordre" value="0" min="0">
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-save">AJOUTER</button>
                    <button type="button" class="btn-cancel"
                            onclick="toggleForm('add-video')">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/js/galerie.js"></script>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/admin/layout/base.php';
?>
