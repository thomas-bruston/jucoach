<?php
$title   = 'Mon questionnaire — Ju Coach Sportif';
$pageCss = 'questionnaire.css';
ob_start();
?>

<section class="questionnaire-section">
    <div class="questionnaire-container">

        <div class="questionnaire-header">
            <h1>MON QUESTIONNAIRE</h1>
            <p>Chaque corps est différent. Ce questionnaire me permet de créer un programme 100% adapté à votre profil, vos objectifs et votre mode de vie.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert--error" role="alert" aria-live="polite">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="questionnaire-form" method="POST" action="/questionnaire" novalidate>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <!-- INFORMATIONS PERSONNELLES -->
            <fieldset class="questionnaire-fieldset">
                <legend>Informations personnelles</legend>

                <div class="form-row">
                    <div class="form-group">
                        <label for="age">Âge</label>
                        <input type="number" id="age" name="age"
                               placeholder="Votre âge" min="5" max="120"
                               value="<?= htmlspecialchars($old['age'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre">
                            <option value="">-- Sélectionner --</option>
                            <option value="homme"       <?= ($old['genre'] ?? '') === 'homme'       ? 'selected' : '' ?>>Homme</option>
                            <option value="femme"       <?= ($old['genre'] ?? '') === 'femme'       ? 'selected' : '' ?>>Femme</option>
                            <option value="non_binaire" <?= ($old['genre'] ?? '') === 'non_binaire' ? 'selected' : '' ?>>Non-binaire</option>
                            <option value="autre"       <?= ($old['genre'] ?? '') === 'autre'       ? 'selected' : '' ?>>Autre</option>
                            <option value="non_precise" <?= ($old['genre'] ?? '') === 'non_precise' ? 'selected' : '' ?>>Préfère ne pas préciser</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="taille">Taille (cm)</label>
                        <input type="number" id="taille" name="taille"
                               placeholder="Ex : 175" min="50" max="300"
                               value="<?= htmlspecialchars($old['taille'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="poids">Poids (kg)</label>
                        <input type="number" id="poids" name="poids"
                               placeholder="Ex : 70" min="20" max="500" step="0.1"
                               value="<?= htmlspecialchars($old['poids'] ?? '') ?>">
                    </div>
                </div>
            </fieldset>

            <!-- OBJECTIFS -->
            <fieldset class="questionnaire-fieldset">
                <legend>Objectifs</legend>

                <div class="form-group">
                    <label for="objectif_principal">Quel est votre objectif principal ? <span aria-hidden="true">*</span></label>
                    <select id="objectif_principal" name="objectif_principal" required aria-required="true">
                        <option value="">-- Sélectionner --</option>
                        <option value="perte_de_poids"  <?= ($old['objectif_principal'] ?? '') === 'perte_de_poids'  ? 'selected' : '' ?>>Perte de poids</option>
                        <option value="prise_de_masse"  <?= ($old['objectif_principal'] ?? '') === 'prise_de_masse'  ? 'selected' : '' ?>>Prise de masse</option>
                        <option value="remise_en_forme" <?= ($old['objectif_principal'] ?? '') === 'remise_en_forme' ? 'selected' : '' ?>>Remise en forme</option>
                        <option value="cardio_course"   <?= ($old['objectif_principal'] ?? '') === 'cardio_course'   ? 'selected' : '' ?>>Cardio / Course à pied</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="objectif_description">Décrivez précisément le résultat que vous souhaitez obtenir</label>
                    <textarea id="objectif_description" name="objectif_description" rows="3"
                              placeholder="Soyez le plus précis possible..."><?= htmlspecialchars($old['objectif_description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="objectif_delai">En combien de temps souhaitez-vous obtenir ce résultat ?</label>
                    <input type="text" id="objectif_delai" name="objectif_delai"
                           placeholder="Ex : 3 mois, 6 mois..."
                           value="<?= htmlspecialchars($old['objectif_delai'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="objectif_importance">Pourquoi est-ce important pour vous à l'heure actuelle ?</label>
                    <textarea id="objectif_importance" name="objectif_importance" rows="3"
                              placeholder="Partagez vos motivations..."><?= htmlspecialchars($old['objectif_importance'] ?? '') ?></textarea>
                </div>
            </fieldset>

            <!-- CONDITIONS PHYSIQUES -->
            <fieldset class="questionnaire-fieldset">
                <legend>Conditions physiques</legend>

                <div class="form-group">
                    <label for="condition_physique">Comment évaluez-vous votre condition physique ? (1 à 10)</label>
                    <input type="number" id="condition_physique" name="condition_physique"
                           min="1" max="10" placeholder="Entre 1 et 10"
                           value="<?= htmlspecialchars($old['condition_physique'] ?? '') ?>">
                </div>

                <!-- Point 5 : pratiquez vous une activité sportive -->
                <div class="form-group">
                    <label for="pratique_sport">Pratiquez-vous une activité sportive ?</label>
                    <select id="pratique_sport" name="pratique_sport">
                        <option value="">-- Sélectionner --</option>
                        <option value="oui" <?= ($old['pratique_sport'] ?? '') === 'oui' ? 'selected' : '' ?>>Oui</option>
                        <option value="non" <?= ($old['pratique_sport'] ?? '') === 'non' ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>

                <!-- Point 6 : historique sport -->
                <div class="form-group">
                    <label for="historique_sport">Parlez-moi de toutes vos activités sportives pratiquées de manière régulière <span class="optional">(Optionnel)</span></label>
                    <textarea id="historique_sport" name="historique_sport" rows="3"
                              placeholder="Ex : j'ai fait du foot pendant 5 ans, natation 2x par semaine..."><?= htmlspecialchars($old['historique_sport'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="ressenti_corps">Comment vous sentez-vous dans votre corps à l'heure actuelle ?</label>
                    <textarea id="ressenti_corps" name="ressenti_corps" rows="3"
                              placeholder="Décrivez votre ressenti..."><?= htmlspecialchars($old['ressenti_corps'] ?? '') ?></textarea>
                </div>

                <!-- Point 1 : select 1 à 10 après ressenti corps -->
                <div class="form-group">
                    <label for="ressenti_corps_note">Notez votre ressenti (1 à 10)</label>
                    <select id="ressenti_corps_note" name="ressenti_corps_note">
                        <option value="">-- Sélectionner --</option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>" <?= ((int)($old['ressenti_corps_note'] ?? 0)) === $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="changement_prioritaire">Qu'aimeriez-vous changer en priorité ?</label>
                    <textarea id="changement_prioritaire" name="changement_prioritaire" rows="2"
                              placeholder="Ex : perdre du ventre, gagner en endurance..."><?= htmlspecialchars($old['changement_prioritaire'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="blessures_douleurs">Avez-vous des blessures ou des douleurs ?</label>
                    <textarea id="blessures_douleurs" name="blessures_douleurs" rows="2"
                              placeholder="Précisez si oui, sinon laissez vide..."><?= htmlspecialchars($old['blessures_douleurs'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="problemes_sante">Avez-vous des problèmes de santé particuliers ?</label>
                    <textarea id="problemes_sante" name="problemes_sante" rows="2"
                              placeholder="Précisez si oui, sinon laissez vide..."><?= htmlspecialchars($old['problemes_sante'] ?? '') ?></textarea>
                </div>

                 <!-- Point 7 : select 1 à 10 après qualite_sommeil -->
                    <div class="form-group">
                        <label for="niveau_stress">Vous sentez-vous stressé(e) ? (1 à 10)</label>
                        <select id="niveau_stress" name="niveau_stress">
                            <option value="">-- Sélectionner --</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= ((int)($old['niveau_stress'] ?? 0)) === $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="niveau_stress_description">Décrivez <span class="optional">(Optionnel)</span></label>
                    <textarea id="niveau_stress_description" name="niveau_stress_description" rows="2"
                              placeholder="Ex : stress au travail, difficultés personnelles..."><?= htmlspecialchars($old['niveau_stress_description'] ?? '') ?></textarea>
                </div>
               

                <div class="form-row">
                    <div class="form-group">
                        <label for="qualite_sommeil">Comment qualifieriez-vous votre qualité de sommeil ?</label>
                        <select id="qualite_sommeil" name="qualite_sommeil">
                            <option value="">-- Sélectionner --</option>
                            <option value="mauvaise" <?= ($old['qualite_sommeil'] ?? '') === 'mauvaise' ? 'selected' : '' ?>>Mauvaise</option>
                            <option value="moyenne"  <?= ($old['qualite_sommeil'] ?? '') === 'moyenne'  ? 'selected' : '' ?>>Moyenne</option>
                            <option value="bonne"    <?= ($old['qualite_sommeil'] ?? '') === 'bonne'    ? 'selected' : '' ?>>Bonne</option>
                        </select>
                    </div>
                </div>
                   

                <!-- Point 2 : textarea après qualite_sommeil -->
                <div class="form-group">
                    <label for="qualite_sommeil_description">Décrivez <span class="optional">(Optionnel)</span></label>
                    <textarea id="qualite_sommeil_description" name="qualite_sommeil_description" rows="2"
                              placeholder="Ex : je dors 5h par nuit, je me réveille souvent..."><?= htmlspecialchars($old['qualite_sommeil_description'] ?? '') ?></textarea>
                </div>

              
                

                <div class="form-group">
                    <label for="activite_professionnelle">Activité professionnelle</label>
                    <select id="activite_professionnelle" name="activite_professionnelle">
                        <option value="">-- Sélectionner --</option>
                        <option value="sedentaire" <?= ($old['activite_professionnelle'] ?? '') === 'sedentaire' ? 'selected' : '' ?>>Sédentaire</option>
                        <option value="active"     <?= ($old['activite_professionnelle'] ?? '') === 'active'     ? 'selected' : '' ?>>Active</option>
                        <option value="physique"   <?= ($old['activite_professionnelle'] ?? '') === 'physique'   ? 'selected' : '' ?>>Physique</option>
                    </select>
                </div>

                <!-- Point 4 : textarea profession -->
                <div class="form-group">
                    <label for="profession">Indiquez votre profession <span class="optional">(Optionnel)</span></label>
                    <textarea id="profession" name="profession" rows="1"
                              placeholder="Ex : infirmier, enseignant, développeur..."><?= htmlspecialchars($old['profession'] ?? '') ?></textarea>
                </div>
            </fieldset>

            <!-- NUTRITION -->
            <fieldset class="questionnaire-fieldset">
                <legend>Nutrition</legend>

                <div class="form-group">
                    <label for="alimentation">Décrivez rapidement votre alimentation</label>
                    <select id="alimentation" name="alimentation">
                        <option value="">-- Sélectionner --</option>
                        <option value="saine"    <?= ($old['alimentation'] ?? '') === 'saine'    ? 'selected' : '' ?>>Saine</option>
                        <option value="moyenne"  <?= ($old['alimentation'] ?? '') === 'moyenne'  ? 'selected' : '' ?>>Moyenne</option>
                        <option value="mauvaise" <?= ($old['alimentation'] ?? '') === 'mauvaise' ? 'selected' : '' ?>>Mauvaise</option>
                    </select>
                </div>

                <!-- Point 8 : alimentation_note et hydratation_note -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="alimentation_note">Évaluez votre alimentation (1 à 10)</label>
                        <select id="alimentation_note" name="alimentation_note">
                            <option value="">-- Sélectionner --</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= ((int)($old['alimentation_note'] ?? 0)) === $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hydratation_note">Évaluez votre hydratation (1 à 10)</label>
                        <select id="hydratation_note" name="hydratation_note">
                            <option value="">-- Sélectionner --</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= ((int)($old['hydratation_note'] ?? 0)) === $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tendance_alimentaire">Avez-vous tendance à :</label>
                    <select id="tendance_alimentaire" name="tendance_alimentaire">
                        <option value="">-- Sélectionner --</option>
                        <option value="grignoter"           <?= ($old['tendance_alimentaire'] ?? '') === 'grignoter'           ? 'selected' : '' ?>>Grignoter</option>
                        <option value="manger_sucre"        <?= ($old['tendance_alimentaire'] ?? '') === 'manger_sucre'        ? 'selected' : '' ?>>Manger sucré</option>
                        <option value="sauter_repas"        <?= ($old['tendance_alimentaire'] ?? '') === 'sauter_repas'        ? 'selected' : '' ?>>Sauter des repas</option>
                        <option value="manger_sur_le_pouce" <?= ($old['tendance_alimentaire'] ?? '') === 'manger_sur_le_pouce' ? 'selected' : '' ?>>Manger sur le pouce</option>
                        <option value="aucune"              <?= ($old['tendance_alimentaire'] ?? '') === 'aucune'              ? 'selected' : '' ?>>Aucune de ces propositions</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="consommation_alcool">Consommation d'alcool</label>
                    <select id="consommation_alcool" name="consommation_alcool">
                        <option value="">-- Sélectionner --</option>
                        <option value="jamais"        <?= ($old['consommation_alcool'] ?? '') === 'jamais'        ? 'selected' : '' ?>>Jamais</option>
                        <option value="occasionnelle" <?= ($old['consommation_alcool'] ?? '') === 'occasionnelle' ? 'selected' : '' ?>>Occasionnelle</option>
                        <option value="reguliere"     <?= ($old['consommation_alcool'] ?? '') === 'reguliere'     ? 'selected' : '' ?>>Régulière</option>
                    </select>
                </div>

                <!-- Point 9 : difficulte_alimentaire renommée -->
                <div class="form-group">
                    <label for="difficulte_alimentaire">Quelles sont vos difficultés face à une alimentation optimale ?</label>
                    <textarea id="difficulte_alimentaire" name="difficulte_alimentaire" rows="2"
                              placeholder="Ex : je craque le soir, je mange trop vite..."><?= htmlspecialchars($old['difficulte_alimentaire'] ?? '') ?></textarea>
                </div>

                <!-- Point 10 : regime_particulier et allergies -->
                <div class="form-group">
                    <label for="regime_particulier">Suivez-vous un régime particulier ?</label>
                    <select id="regime_particulier" name="regime_particulier">
                        <option value="">-- Sélectionner --</option>
                        <option value="oui" <?= ($old['regime_particulier'] ?? '') === 'oui' ? 'selected' : '' ?>>Oui</option>
                        <option value="non" <?= ($old['regime_particulier'] ?? '') === 'non' ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="allergies">Avez-vous des allergies ? <span class="optional">(Optionnel)</span></label>
                    <textarea id="allergies" name="allergies" rows="2"
                              placeholder="Ex : gluten, lactose, noix..."><?= htmlspecialchars($old['allergies'] ?? '') ?></textarea>
                </div>
            </fieldset>

            <!-- ENTRAÎNEMENT -->
            <fieldset class="questionnaire-fieldset">
                <legend>Entraînement</legend>

                <div class="form-group">
                    <label for="programme_structure_suivi">Avez-vous déjà suivi un programme structuré ?</label>
                    <select id="programme_structure_suivi" name="programme_structure_suivi">
                        <option value="">-- Sélectionner --</option>
                        <option value="oui" <?= ($old['programme_structure_suivi'] ?? '') === 'oui' ? 'selected' : '' ?>>Oui</option>
                        <option value="non" <?= ($old['programme_structure_suivi'] ?? '') === 'non' ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="programme_ce_qui_fonctionne">Si oui, qu'est-ce qui a fonctionné pour vous ? <span class="optional">(Optionnel)</span></label>
                    <textarea id="programme_ce_qui_fonctionne" name="programme_ce_qui_fonctionne" rows="2"
                              placeholder="..."><?= htmlspecialchars($old['programme_ce_qui_fonctionne'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="programme_ce_qui_echoue">Qu'est-ce qui n'a pas fonctionné ? <span class="optional">(Optionnel)</span></label>
                    <textarea id="programme_ce_qui_echoue" name="programme_ce_qui_echoue" rows="2"
                              placeholder="..."><?= htmlspecialchars($old['programme_ce_qui_echoue'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="sentiment_blocage">Vous sentez-vous bloqué(e) dans votre entraînement ? <span class="optional">(Optionnel)</span></label>
                    <textarea id="sentiment_blocage" name="sentiment_blocage" rows="2"
                              placeholder="..."><?= htmlspecialchars($old['sentiment_blocage'] ?? '') ?></textarea>
                </div>

                <!-- Point 11 : textarea blocage_raison -->
                <div class="form-group">
                    <label for="blocage_raison">Si oui, pourquoi ? <span class="optional">(Optionnel)</span></label>
                    <textarea id="blocage_raison" name="blocage_raison" rows="2"
                              placeholder="..."><?= htmlspecialchars($old['blocage_raison'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="pratique_irreguliere">Le pratiquez-vous de façon irrégulière ? Si oui, depuis combien de temps ? <span class="optional">(Optionnel)</span></label>
                    <textarea id="pratique_irreguliere" name="pratique_irreguliere" rows="2"
                              placeholder="..."><?= htmlspecialchars($old['pratique_irreguliere'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="duree_seance">Combien de temps désirez-vous consacrer à chaque séance ?</label>
                    <input type="text" id="duree_seance" name="duree_seance"
                           placeholder="Ex : 30 minutes, 1 heure..."
                           value="<?= htmlspecialchars($old['duree_seance'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="lieu_entrainement">Où souhaitez-vous vous entraîner ?</label>
                    <select id="lieu_entrainement" name="lieu_entrainement">
                        <option value="">-- Sélectionner --</option>
                        <option value="salle"     <?= ($old['lieu_entrainement'] ?? '') === 'salle'     ? 'selected' : '' ?>>En salle</option>
                        <option value="domicile"  <?= ($old['lieu_entrainement'] ?? '') === 'domicile'  ? 'selected' : '' ?>>À domicile</option>
                        <option value="exterieur" <?= ($old['lieu_entrainement'] ?? '') === 'exterieur' ? 'selected' : '' ?>>En extérieur</option>
                    </select>
                </div>

               
                    <div class="form-group">
                        <label for="niveau_motivation">Quel est votre niveau de motivation ? (1 à 10)</label>
                        <select id="niveau_motivation" name="niveau_motivation">
                            <option value="">-- Sélectionner --</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= ((int)($old['niveau_motivation'] ?? 0)) === $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
 <div class="form-row">
                    <div class="form-group">
                        <label for="accompagnement_serieux">Êtes-vous prêt(e) à suivre un accompagnement sérieux ?</label>
                        <select id="accompagnement_serieux" name="accompagnement_serieux">
                            <option value="">-- Sélectionner --</option>
                            <option value="oui" <?= ($old['accompagnement_serieux'] ?? '') === 'oui' ? 'selected' : '' ?>>Oui</option>
                            <option value="non" <?= ($old['accompagnement_serieux'] ?? '') === 'non' ? 'selected' : '' ?>>Non</option>
                        </select>
                    </div>
                </div>

                <!-- Point 13 : changements_mode_vie avec nouvelles options -->
                <div class="form-group">
                    <label for="changements_mode_vie">Êtes-vous prêt(e) à faire des changements dans votre mode de vie ?</label>
                    <select id="changements_mode_vie" name="changements_mode_vie">
                        <option value="">-- Sélectionner --</option>
                        <option value="non"              <?= ($old['changements_mode_vie'] ?? '') === 'non'              ? 'selected' : '' ?>>Non</option>
                        <option value="un_peu"           <?= ($old['changements_mode_vie'] ?? '') === 'un_peu'           ? 'selected' : '' ?>>Un peu</option>
                        <option value="beaucoup"         <?= ($old['changements_mode_vie'] ?? '') === 'beaucoup'         ? 'selected' : '' ?>>Beaucoup</option>
                        <option value="oui_tout_changer" <?= ($old['changements_mode_vie'] ?? '') === 'oui_tout_changer' ? 'selected' : '' ?>>Oui, je veux tout changer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_debut_souhaitee">Quand souhaitez-vous commencer ?</label>
                    <select id="date_debut_souhaitee" name="date_debut_souhaitee">
                        <option value="">-- Sélectionner --</option>
                        <option value="immediatement" <?= ($old['date_debut_souhaitee'] ?? '') === 'immediatement' ? 'selected' : '' ?>>Immédiatement</option>
                        <option value="cette_semaine" <?= ($old['date_debut_souhaitee'] ?? '') === 'cette_semaine' ? 'selected' : '' ?>>Cette semaine</option>
                        <option value="ce_mois_ci"    <?= ($old['date_debut_souhaitee'] ?? '') === 'ce_mois_ci'    ? 'selected' : '' ?>>Ce mois-ci</option>
                        <option value="plus_tard"     <?= ($old['date_debut_souhaitee'] ?? '') === 'plus_tard'     ? 'selected' : '' ?>>Plus tard</option>
                    </select>
                </div>
            </fieldset>

            <button type="submit" class="btn btn--primary btn--full">ENVOYER</button>

        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
require_once ROOT_PATH . '/templates/layout/base.php';
?>
