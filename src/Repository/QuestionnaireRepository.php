<?php

declare(strict_types=1);

namespace Repository;

use Entity\Questionnaire;

class QuestionnaireRepository extends AbstractRepository
{

    public function findByUtilisateurId(int $utilisateurId): ?Questionnaire
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM questionnaire WHERE utilisateur_id = :utilisateur_id LIMIT 1'
            );
            $stmt->execute([':utilisateur_id' => $utilisateurId]);
            $row = $stmt->fetch();

            return $row ? Questionnaire::fromArray($row) : null;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la recherche du questionnaire : ' . $e->getMessage());
        }
    }

    public function create(Questionnaire $q): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO questionnaire (
                    utilisateur_id,
                    age, genre, taille, poids,
                    objectif_principal, objectif_description, objectif_delai, objectif_importance,
                    condition_physique, pratique_sport, historique_sport,
                    ressenti_corps, ressenti_corps_note, changement_prioritaire,
                    blessures_douleurs, problemes_sante,
                    qualite_sommeil, qualite_sommeil_description,
                    niveau_stress, niveau_stress_description,
                    activite_professionnelle, profession,
                    alimentation, alimentation_note, hydratation_note,
                    tendance_alimentaire, consommation_alcool,
                    difficulte_alimentaire, regime_particulier, allergies,
                    programme_structure_suivi, programme_ce_qui_fonctionne, programme_ce_qui_echoue,
                    sentiment_blocage, blocage_raison, pratique_irreguliere,
                    duree_seance, lieu_entrainement,
                    niveau_motivation, accompagnement_serieux, changements_mode_vie, date_debut_souhaitee
                ) VALUES (
                    :utilisateur_id,
                    :age, :genre, :taille, :poids,
                    :objectif_principal, :objectif_description, :objectif_delai, :objectif_importance,
                    :condition_physique, :pratique_sport, :historique_sport,
                    :ressenti_corps, :ressenti_corps_note, :changement_prioritaire,
                    :blessures_douleurs, :problemes_sante,
                    :qualite_sommeil, :qualite_sommeil_description,
                    :niveau_stress, :niveau_stress_description,
                    :activite_professionnelle, :profession,
                    :alimentation, :alimentation_note, :hydratation_note,
                    :tendance_alimentaire, :consommation_alcool,
                    :difficulte_alimentaire, :regime_particulier, :allergies,
                    :programme_structure_suivi, :programme_ce_qui_fonctionne, :programme_ce_qui_echoue,
                    :sentiment_blocage, :blocage_raison, :pratique_irreguliere,
                    :duree_seance, :lieu_entrainement,
                    :niveau_motivation, :accompagnement_serieux, :changements_mode_vie, :date_debut_souhaitee
                )'
            );

            $stmt->execute([
                ':utilisateur_id'              => $q->getUtilisateurId(),
                ':age'                         => $q->getAge(),
                ':genre'                       => $q->getGenre(),
                ':taille'                      => $q->getTaille(),
                ':poids'                       => $q->getPoids(),
                ':objectif_principal'          => $q->getObjectifPrincipal(),
                ':objectif_description'        => $q->getObjectifDescription(),
                ':objectif_delai'              => $q->getObjectifDelai(),
                ':objectif_importance'         => $q->getObjectifImportance(),
                ':condition_physique'          => $q->getConditionPhysique(),
                ':pratique_sport'              => $q->getPratiqueSport(),
                ':historique_sport'            => $q->getHistoriqueSport(),
                ':ressenti_corps'              => $q->getResentiCorps(),
                ':ressenti_corps_note'         => $q->getResentiCorpsNote(),
                ':changement_prioritaire'      => $q->getChangementPrioritaire(),
                ':blessures_douleurs'          => $q->getBlessuresDouleurs(),
                ':problemes_sante'             => $q->getProblemesSante(),
                ':qualite_sommeil'             => $q->getQualiteSommeil(),
                ':qualite_sommeil_description' => $q->getQualiteSommeilDescription(),
                ':niveau_stress'               => $q->getNiveauStress(),
                ':niveau_stress_description'   => $q->getNiveauStressDescription(),
                ':activite_professionnelle'    => $q->getActiviteProfessionnelle(),
                ':profession'                  => $q->getProfession(),
                ':alimentation'                => $q->getAlimentation(),
                ':alimentation_note'           => $q->getAlimentationNote(),
                ':hydratation_note'            => $q->getHydratationNote(),
                ':tendance_alimentaire'        => $q->getTendanceAlimentaire(),
                ':consommation_alcool'         => $q->getConsommationAlcool(),
                ':difficulte_alimentaire'      => $q->getDifficulteAlimentaire(),
                ':regime_particulier'          => $q->getRegimeParticulier(),
                ':allergies'                   => $q->getAllergies(),
                ':programme_structure_suivi'   => $q->getProgrammeStructureSuivi(),
                ':programme_ce_qui_fonctionne' => $q->getProgrammeCeQuiFonctionne(),
                ':programme_ce_qui_echoue'     => $q->getProgrammeCeQuiEchoue(),
                ':sentiment_blocage'           => $q->getSentimentBlockage(),
                ':blocage_raison'              => $q->getBlocageRaison(),
                ':pratique_irreguliere'        => $q->getPratiqueIrreguliere(),
                ':duree_seance'                => $q->getDureeSeance(),
                ':lieu_entrainement'           => $q->getLieuEntrainement(),
                ':niveau_motivation'           => $q->getNiveauMotivation(),
                ':accompagnement_serieux'      => $q->getAccompagnementSerieux(),
                ':changements_mode_vie'        => $q->getChangementsModeVie(),
                ':date_debut_souhaitee'        => $q->getDateDebutSouhaitee(),
            ]);

            return (int) $this->pdo->lastInsertId();

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la création du questionnaire : ' . $e->getMessage());
        }
    }

    public function existsForUtilisateur(int $utilisateurId): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT COUNT(*) FROM questionnaire WHERE utilisateur_id = :utilisateur_id'
            );
            $stmt->execute([':utilisateur_id' => $utilisateurId]);

            return (int) $stmt->fetchColumn() > 0;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la vérification du questionnaire : ' . $e->getMessage());
        }
    }
}
