<?php

declare(strict_types=1);

namespace Service;

use Entity\Questionnaire;
use Repository\QuestionnaireRepository;

/* Logique métier du questionnaire sportif */

class QuestionnaireService
{
    private QuestionnaireRepository $questionnaireRepository;

    public function __construct()
    {
        $this->questionnaireRepository = new QuestionnaireRepository();
    }

    /* Vérifie si l'utilisateur a déjà rempli son questionnaire */

    public function dejaRempli(int $utilisateurId): bool
    {
        return $this->questionnaireRepository->existsForUtilisateur($utilisateurId);
    }

    /* Enregistre le questionnaire */

    public function store(int $utilisateurId, array $data): int
    {
        if ($this->dejaRempli($utilisateurId)) {
            throw new \RuntimeException('Vous avez déjà rempli votre questionnaire.');
        }

        if (($data['consent_sante'] ?? null) === null) {
            throw new \InvalidArgumentException('Vous devez autoriser le traitement de ces informations pour valider le questionnaire.');
        }

        $objectifPrincipal = trim($data['objectif_principal'] ?? '');
        if (empty($objectifPrincipal)) {
            throw new \InvalidArgumentException('L\'objectif principal est obligatoire.');
        }

        $objectifsValides = ['perte_de_poids', 'prise_de_masse', 'remise_en_forme', 'cardio_course'];
        if (!in_array($objectifPrincipal, $objectifsValides, true)) {
            throw new \InvalidArgumentException('Objectif principal invalide.');
        }

        $q = new Questionnaire(
            utilisateurId:             $utilisateurId,
            objectifPrincipal:         $objectifPrincipal,
            age:                       !empty($data['age'])                          ? (int) $data['age']                              : null,
            genre:                     !empty($data['genre'])                        ? trim($data['genre'])                            : null,
            taille:                    !empty($data['taille'])                       ? (int) $data['taille']                           : null,
            poids:                     !empty($data['poids'])                        ? (float) $data['poids']                          : null,
            objectifDescription:       !empty($data['objectif_description'])         ? trim($data['objectif_description'])             : null,
            objectifDelai:             !empty($data['objectif_delai'])               ? trim($data['objectif_delai'])                   : null,
            objectifImportance:        !empty($data['objectif_importance'])          ? trim($data['objectif_importance'])              : null,
            conditionPhysique:         !empty($data['condition_physique'])           ? (int) $data['condition_physique']               : null,
            pratiqueSport:             !empty($data['pratique_sport'])               ? trim($data['pratique_sport'])                   : null,
            historiqueSport:           !empty($data['historique_sport'])             ? trim($data['historique_sport'])                 : null,
            resentiCorps:              !empty($data['ressenti_corps'])               ? trim($data['ressenti_corps'])                   : null,
            resentiCorpsNote:          !empty($data['ressenti_corps_note'])          ? (int) $data['ressenti_corps_note']              : null,
            changementPrioritaire:     !empty($data['changement_prioritaire'])       ? trim($data['changement_prioritaire'])           : null,
            blessuresDouleurs:         !empty($data['blessures_douleurs'])           ? trim($data['blessures_douleurs'])               : null,
            problemesSante:            !empty($data['problemes_sante'])              ? trim($data['problemes_sante'])                  : null,
            qualiteSommeil:            !empty($data['qualite_sommeil'])              ? trim($data['qualite_sommeil'])                  : null,
            qualiteSommeilDescription: !empty($data['qualite_sommeil_description'])  ? trim($data['qualite_sommeil_description'])      : null,
            niveauStress:              !empty($data['niveau_stress'])                ? (int) $data['niveau_stress']                    : null,
            niveauStressDescription:   !empty($data['niveau_stress_description'])    ? trim($data['niveau_stress_description'])        : null,
            activiteProfessionnelle:   !empty($data['activite_professionnelle'])     ? trim($data['activite_professionnelle'])         : null,
            profession:                !empty($data['profession'])                   ? trim($data['profession'])                       : null,
            alimentation:              !empty($data['alimentation'])                 ? trim($data['alimentation'])                     : null,
            alimentationNote:          !empty($data['alimentation_note'])            ? (int) $data['alimentation_note']                : null,
            hydratationNote:           !empty($data['hydratation_note'])             ? (int) $data['hydratation_note']                 : null,
            tendanceAlimentaire:       !empty($data['tendance_alimentaire'])         ? trim($data['tendance_alimentaire'])             : null,
            consommationAlcool:        !empty($data['consommation_alcool'])          ? trim($data['consommation_alcool'])              : null,
            difficulteAlimentaire:     !empty($data['difficulte_alimentaire'])       ? trim($data['difficulte_alimentaire'])           : null,
            regimeParticulier:         !empty($data['regime_particulier'])           ? trim($data['regime_particulier'])               : null,
            allergies:                 !empty($data['allergies'])                    ? trim($data['allergies'])                        : null,
            programmeStructureSuivi:   !empty($data['programme_structure_suivi'])    ? trim($data['programme_structure_suivi'])        : null,
            programmeCeQuiFonctionne:  !empty($data['programme_ce_qui_fonctionne'])  ? trim($data['programme_ce_qui_fonctionne'])      : null,
            programmeCeQuiEchoue:      !empty($data['programme_ce_qui_echoue'])      ? trim($data['programme_ce_qui_echoue'])          : null,
            sentimentBlockage:         !empty($data['sentiment_blocage'])            ? trim($data['sentiment_blocage'])                : null,
            blocageRaison:             !empty($data['blocage_raison'])               ? trim($data['blocage_raison'])                   : null,
            pratiqueIrreguliere:       !empty($data['pratique_irreguliere'])         ? trim($data['pratique_irreguliere'])             : null,
            dureeSeance:               !empty($data['duree_seance'])                 ? trim($data['duree_seance'])                     : null,
            lieuEntrainement:          !empty($data['lieu_entrainement'])            ? trim($data['lieu_entrainement'])                : null,
            niveauMotivation:          !empty($data['niveau_motivation'])            ? (int) $data['niveau_motivation']                : null,
            accompagnementSerieux:     !empty($data['accompagnement_serieux'])       ? trim($data['accompagnement_serieux'])           : null,
            changementsModeVie:        !empty($data['changements_mode_vie'])         ? trim($data['changements_mode_vie'])             : null,
            dateDebutSouhaitee:        !empty($data['date_debut_souhaitee'])         ? trim($data['date_debut_souhaitee'])             : null,
        );

        // Validation des notes
        if ($q->getAge() !== null)              $q->setAge($q->getAge());
        if ($q->getTaille() !== null)           $q->setTaille($q->getTaille());
        if ($q->getPoids() !== null)            $q->setPoids($q->getPoids());
        if ($q->getConditionPhysique() !== null) $q->setConditionPhysique($q->getConditionPhysique());
        if ($q->getResentiCorpsNote() !== null)  $q->setResentiCorpsNote($q->getResentiCorpsNote());
        if ($q->getNiveauStress() !== null)      $q->setNiveauStress($q->getNiveauStress());
        if ($q->getAlimentationNote() !== null)  $q->setAlimentationNote($q->getAlimentationNote());
        if ($q->getHydratationNote() !== null)   $q->setHydratationNote($q->getHydratationNote());
        if ($q->getNiveauMotivation() !== null)  $q->setNiveauMotivation($q->getNiveauMotivation());

        return $this->questionnaireRepository->create($q);
    }
}
