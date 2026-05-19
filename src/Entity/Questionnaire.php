<?php

declare(strict_types=1);

namespace Entity;

/* Entité questionnaire sportif */

class Questionnaire
{
    private ?int    $id;
    private int     $utilisateurId;

    // Informations personnelles
    private ?int    $age;
    private ?string $genre;
    private ?int    $taille;
    private ?float  $poids;

    // Objectifs
    private string  $objectifPrincipal;
    private ?string $objectifDescription;
    private ?string $objectifDelai;
    private ?string $objectifImportance;

    // Conditions physiques
    private ?int    $conditionPhysique;
    private ?string $pratiqueSport;
    private ?string $historiqueSport;
    private ?string $resentiCorps;
    private ?int    $resentiCorpsNote;
    private ?string $changementPrioritaire;
    private ?string $blessuresDouleurs;
    private ?string $problemesSante;
    private ?string $qualiteSommeil;
    private ?string $qualiteSommeilDescription;
    private ?int    $niveauStress;
    private ?string $niveauStressDescription;
    private ?string $activiteProfessionnelle;
    private ?string $profession;

    // Nutrition
    private ?string $alimentation;
    private ?int    $alimentationNote;
    private ?int    $hydratationNote;
    private ?string $tendanceAlimentaire;
    private ?string $consommationAlcool;
    private ?string $difficulteAlimentaire;
    private ?string $regimeParticulier;
    private ?string $allergies;

    // Entraînement
    private ?string $programmeStructureSuivi;
    private ?string $programmeCeQuiFonctionne;
    private ?string $programmeCeQuiEchoue;
    private ?string $sentimentBlockage;
    private ?string $blocageRaison;
    private ?string $pratiqueIrreguliere;
    private ?string $dureeSeance;
    private ?string $lieuEntrainement;
    private ?int    $niveauMotivation;
    private ?string $accompagnementSerieux;
    private ?string $changementsModeVie;
    private ?string $dateDebutSouhaitee;

    private ?string $dateRempli;

    public function __construct(
        int     $utilisateurId,
        string  $objectifPrincipal,
        ?int    $age                           = null,
        ?string $genre                         = null,
        ?int    $taille                        = null,
        ?float  $poids                         = null,
        ?string $objectifDescription           = null,
        ?string $objectifDelai                 = null,
        ?string $objectifImportance            = null,
        ?int    $conditionPhysique             = null,
        ?string $pratiqueSport                 = null,
        ?string $historiqueSport               = null,
        ?string $resentiCorps                  = null,
        ?int    $resentiCorpsNote              = null,
        ?string $changementPrioritaire         = null,
        ?string $blessuresDouleurs             = null,
        ?string $problemesSante                = null,
        ?string $qualiteSommeil                = null,
        ?string $qualiteSommeilDescription     = null,
        ?int    $niveauStress                  = null,
        ?string $niveauStressDescription       = null,
        ?string $activiteProfessionnelle       = null,
        ?string $profession                    = null,
        ?string $alimentation                  = null,
        ?int    $alimentationNote              = null,
        ?int    $hydratationNote               = null,
        ?string $tendanceAlimentaire           = null,
        ?string $consommationAlcool            = null,
        ?string $difficulteAlimentaire         = null,
        ?string $regimeParticulier             = null,
        ?string $allergies                     = null,
        ?string $programmeStructureSuivi       = null,
        ?string $programmeCeQuiFonctionne      = null,
        ?string $programmeCeQuiEchoue          = null,
        ?string $sentimentBlockage             = null,
        ?string $blocageRaison                 = null,
        ?string $pratiqueIrreguliere           = null,
        ?string $dureeSeance                   = null,
        ?string $lieuEntrainement              = null,
        ?int    $niveauMotivation              = null,
        ?string $accompagnementSerieux         = null,
        ?string $changementsModeVie            = null,
        ?string $dateDebutSouhaitee            = null,
        ?int    $id                            = null,
        ?string $dateRempli                    = null
    ) {
        $this->utilisateurId              = $utilisateurId;
        $this->objectifPrincipal          = $objectifPrincipal;
        $this->age                        = $age;
        $this->genre                      = $genre;
        $this->taille                     = $taille;
        $this->poids                      = $poids;
        $this->objectifDescription        = $objectifDescription;
        $this->objectifDelai              = $objectifDelai;
        $this->objectifImportance         = $objectifImportance;
        $this->conditionPhysique          = $conditionPhysique;
        $this->pratiqueSport              = $pratiqueSport;
        $this->historiqueSport            = $historiqueSport;
        $this->resentiCorps               = $resentiCorps;
        $this->resentiCorpsNote           = $resentiCorpsNote;
        $this->changementPrioritaire      = $changementPrioritaire;
        $this->blessuresDouleurs          = $blessuresDouleurs;
        $this->problemesSante             = $problemesSante;
        $this->qualiteSommeil             = $qualiteSommeil;
        $this->qualiteSommeilDescription  = $qualiteSommeilDescription;
        $this->niveauStress               = $niveauStress;
        $this->niveauStressDescription    = $niveauStressDescription;
        $this->activiteProfessionnelle    = $activiteProfessionnelle;
        $this->profession                 = $profession;
        $this->alimentation               = $alimentation;
        $this->alimentationNote           = $alimentationNote;
        $this->hydratationNote            = $hydratationNote;
        $this->tendanceAlimentaire        = $tendanceAlimentaire;
        $this->consommationAlcool         = $consommationAlcool;
        $this->difficulteAlimentaire      = $difficulteAlimentaire;
        $this->regimeParticulier          = $regimeParticulier;
        $this->allergies                  = $allergies;
        $this->programmeStructureSuivi    = $programmeStructureSuivi;
        $this->programmeCeQuiFonctionne   = $programmeCeQuiFonctionne;
        $this->programmeCeQuiEchoue       = $programmeCeQuiEchoue;
        $this->sentimentBlockage          = $sentimentBlockage;
        $this->blocageRaison              = $blocageRaison;
        $this->pratiqueIrreguliere        = $pratiqueIrreguliere;
        $this->dureeSeance                = $dureeSeance;
        $this->lieuEntrainement           = $lieuEntrainement;
        $this->niveauMotivation           = $niveauMotivation;
        $this->accompagnementSerieux      = $accompagnementSerieux;
        $this->changementsModeVie         = $changementsModeVie;
        $this->dateDebutSouhaitee         = $dateDebutSouhaitee;
        $this->id                         = $id;
        $this->dateRempli                 = $dateRempli;
    }

    /* Getters */

    public function getId(): ?int                              { return $this->id; }
    public function getUtilisateurId(): int                   { return $this->utilisateurId; }
    public function getAge(): ?int                            { return $this->age; }
    public function getGenre(): ?string                       { return $this->genre; }
    public function getTaille(): ?int                         { return $this->taille; }
    public function getPoids(): ?float                        { return $this->poids; }
    public function getObjectifPrincipal(): string            { return $this->objectifPrincipal; }
    public function getObjectifDescription(): ?string         { return $this->objectifDescription; }
    public function getObjectifDelai(): ?string               { return $this->objectifDelai; }
    public function getObjectifImportance(): ?string          { return $this->objectifImportance; }
    public function getConditionPhysique(): ?int              { return $this->conditionPhysique; }
    public function getPratiqueSport(): ?string               { return $this->pratiqueSport; }
    public function getHistoriqueSport(): ?string              { return $this->historiqueSport; }
    public function getResentiCorps(): ?string                { return $this->resentiCorps; }
    public function getResentiCorpsNote(): ?int               { return $this->resentiCorpsNote; }
    public function getChangementPrioritaire(): ?string       { return $this->changementPrioritaire; }
    public function getBlessuresDouleurs(): ?string           { return $this->blessuresDouleurs; }
    public function getProblemesSante(): ?string              { return $this->problemesSante; }
    public function getQualiteSommeil(): ?string              { return $this->qualiteSommeil; }
    public function getQualiteSommeilDescription(): ?string   { return $this->qualiteSommeilDescription; }
    public function getNiveauStress(): ?int                   { return $this->niveauStress; }
    public function getNiveauStressDescription(): ?string     { return $this->niveauStressDescription; }
    public function getActiviteProfessionnelle(): ?string     { return $this->activiteProfessionnelle; }
    public function getProfession(): ?string                  { return $this->profession; }
    public function getAlimentation(): ?string                { return $this->alimentation; }
    public function getAlimentationNote(): ?int               { return $this->alimentationNote; }
    public function getHydratationNote(): ?int                { return $this->hydratationNote; }
    public function getTendanceAlimentaire(): ?string         { return $this->tendanceAlimentaire; }
    public function getConsommationAlcool(): ?string          { return $this->consommationAlcool; }
    public function getDifficulteAlimentaire(): ?string       { return $this->difficulteAlimentaire; }
    public function getRegimeParticulier(): ?string           { return $this->regimeParticulier; }
    public function getAllergies(): ?string                    { return $this->allergies; }
    public function getProgrammeStructureSuivi(): ?string     { return $this->programmeStructureSuivi; }
    public function getProgrammeCeQuiFonctionne(): ?string    { return $this->programmeCeQuiFonctionne; }
    public function getProgrammeCeQuiEchoue(): ?string        { return $this->programmeCeQuiEchoue; }
    public function getSentimentBlockage(): ?string           { return $this->sentimentBlockage; }
    public function getBlocageRaison(): ?string               { return $this->blocageRaison; }
    public function getPratiqueIrreguliere(): ?string         { return $this->pratiqueIrreguliere; }
    public function getDureeSeance(): ?string                 { return $this->dureeSeance; }
    public function getLieuEntrainement(): ?string            { return $this->lieuEntrainement; }
    public function getNiveauMotivation(): ?int               { return $this->niveauMotivation; }
    public function getAccompagnementSerieux(): ?string       { return $this->accompagnementSerieux; }
    public function getChangementsModeVie(): ?string          { return $this->changementsModeVie; }
    public function getDateDebutSouhaitee(): ?string          { return $this->dateDebutSouhaitee; }
    public function getDateRempli(): ?string                  { return $this->dateRempli; }

    /* Setters */

    public function setAge(?int $age): void
    {
        if ($age !== null && ($age < 5 || $age > 120)) {
            throw new \InvalidArgumentException('Âge invalide.');
        }
        $this->age = $age;
    }

    public function setTaille(?int $taille): void
    {
        if ($taille !== null && ($taille < 50 || $taille > 300)) {
            throw new \InvalidArgumentException('Taille invalide.');
        }
        $this->taille = $taille;
    }

    public function setPoids(?float $poids): void
    {
        if ($poids !== null && ($poids < 20 || $poids > 500)) {
            throw new \InvalidArgumentException('Poids invalide.');
        }
        $this->poids = $poids;
    }

    public function setConditionPhysique(?int $note): void
    {
        if ($note !== null && ($note < 1 || $note > 10)) {
            throw new \InvalidArgumentException('La note doit être entre 1 et 10.');
        }
        $this->conditionPhysique = $note;
    }

    public function setResentiCorpsNote(?int $note): void
    {
        if ($note !== null && ($note < 1 || $note > 10)) {
            throw new \InvalidArgumentException('La note doit être entre 1 et 10.');
        }
        $this->resentiCorpsNote = $note;
    }

    public function setNiveauStress(?int $note): void
    {
        if ($note !== null && ($note < 1 || $note > 10)) {
            throw new \InvalidArgumentException('La note doit être entre 1 et 10.');
        }
        $this->niveauStress = $note;
    }

    public function setAlimentationNote(?int $note): void
    {
        if ($note !== null && ($note < 1 || $note > 10)) {
            throw new \InvalidArgumentException('La note doit être entre 1 et 10.');
        }
        $this->alimentationNote = $note;
    }

    public function setHydratationNote(?int $note): void
    {
        if ($note !== null && ($note < 1 || $note > 10)) {
            throw new \InvalidArgumentException('La note doit être entre 1 et 10.');
        }
        $this->hydratationNote = $note;
    }

    public function setNiveauMotivation(?int $note): void
    {
        if ($note !== null && ($note < 1 || $note > 10)) {
            throw new \InvalidArgumentException('La note doit être entre 1 et 10.');
        }
        $this->niveauMotivation = $note;
    }

    public function setGenre(?string $genre): void                              { $this->genre = $genre; }
    public function setObjectifPrincipal(string $objectif): void                { $this->objectifPrincipal = $objectif; }
    public function setObjectifDescription(?string $desc): void                 { $this->objectifDescription = $desc; }
    public function setObjectifDelai(?string $delai): void                      { $this->objectifDelai = $delai; }
    public function setObjectifImportance(?string $importance): void            { $this->objectifImportance = $importance; }
    public function setPratiqueSort(?string $pratique): void                    { $this->pratiqueSport = $pratique; }
    public function setHistoriqueSport(?string $historique): void                { $this->historiqueSport = $historique; }
    public function setResentiCorps(?string $ressenti): void                    { $this->resentiCorps = $ressenti; }
    public function setChangementPrioritaire(?string $changement): void         { $this->changementPrioritaire = $changement; }
    public function setBlessuresDouleurs(?string $blessures): void              { $this->blessuresDouleurs = $blessures; }
    public function setProblemesSante(?string $problemes): void                 { $this->problemesSante = $problemes; }
    public function setQualiteSommeil(?string $qualite): void                   { $this->qualiteSommeil = $qualite; }
    public function setQualiteSommeilDescription(?string $desc): void           { $this->qualiteSommeilDescription = $desc; }
    public function setNiveauStressDescription(?string $desc): void             { $this->niveauStressDescription = $desc; }
    public function setActiviteProfessionnelle(?string $activite): void         { $this->activiteProfessionnelle = $activite; }
    public function setProfession(?string $profession): void                    { $this->profession = $profession; }
    public function setAlimentation(?string $alimentation): void                { $this->alimentation = $alimentation; }
    public function setTendanceAlimentaire(?string $tendance): void             { $this->tendanceAlimentaire = $tendance; }
    public function setConsommationAlcool(?string $consommation): void          { $this->consommationAlcool = $consommation; }
    public function setDifficulteAlimentaire(?string $difficulte): void         { $this->difficulteAlimentaire = $difficulte; }
    public function setRegimeParticulier(?string $regime): void                 { $this->regimeParticulier = $regime; }
    public function setAllergies(?string $allergies): void                      { $this->allergies = $allergies; }
    public function setProgrammeStructureSuivi(?string $suivi): void            { $this->programmeStructureSuivi = $suivi; }
    public function setProgrammeCeQuiFonctionne(?string $ce): void              { $this->programmeCeQuiFonctionne = $ce; }
    public function setProgrammeCeQuiEchoue(?string $ce): void                  { $this->programmeCeQuiEchoue = $ce; }
    public function setSentimentBlockage(?string $sentiment): void              { $this->sentimentBlockage = $sentiment; }
    public function setBlocageRaison(?string $raison): void                     { $this->blocageRaison = $raison; }
    public function setPratiqueIrreguliere(?string $pratique): void             { $this->pratiqueIrreguliere = $pratique; }
    public function setDureeSeance(?string $duree): void                        { $this->dureeSeance = $duree; }
    public function setLieuEntrainement(?string $lieu): void                    { $this->lieuEntrainement = $lieu; }
    public function setAccompagnementSerieux(?string $accompagnement): void     { $this->accompagnementSerieux = $accompagnement; }
    public function setChangementsModeVie(?string $changements): void           { $this->changementsModeVie = $changements; }
    public function setDateDebutSouhaitee(?string $date): void                  { $this->dateDebutSouhaitee = $date; }

    public static function fromArray(array $data): static
    {
        return new static(
            utilisateurId:             (int) $data['utilisateur_id'],
            objectifPrincipal:         $data['objectif_principal'],
            age:                       isset($data['age'])                  ? (int) $data['age']                  : null,
            genre:                     $data['genre']                       ?? null,
            taille:                    isset($data['taille'])               ? (int) $data['taille']               : null,
            poids:                     isset($data['poids'])                ? (float) $data['poids']              : null,
            objectifDescription:       $data['objectif_description']        ?? null,
            objectifDelai:             $data['objectif_delai']              ?? null,
            objectifImportance:        $data['objectif_importance']         ?? null,
            conditionPhysique:         isset($data['condition_physique'])   ? (int) $data['condition_physique']   : null,
            pratiqueSport:              $data['pratique_sport']              ?? null,
            historiqueSport:            $data['historique_sport']            ?? null,
            resentiCorps:              $data['ressenti_corps']              ?? null,
            resentiCorpsNote:          isset($data['ressenti_corps_note'])  ? (int) $data['ressenti_corps_note']  : null,
            changementPrioritaire:     $data['changement_prioritaire']      ?? null,
            blessuresDouleurs:         $data['blessures_douleurs']          ?? null,
            problemesSante:            $data['problemes_sante']             ?? null,
            qualiteSommeil:            $data['qualite_sommeil']             ?? null,
            qualiteSommeilDescription: $data['qualite_sommeil_description'] ?? null,
            niveauStress:              isset($data['niveau_stress'])        ? (int) $data['niveau_stress']        : null,
            niveauStressDescription:   $data['niveau_stress_description']   ?? null,
            activiteProfessionnelle:   $data['activite_professionnelle']    ?? null,
            profession:                $data['profession']                  ?? null,
            alimentation:              $data['alimentation']                ?? null,
            alimentationNote:          isset($data['alimentation_note'])    ? (int) $data['alimentation_note']    : null,
            hydratationNote:           isset($data['hydratation_note'])     ? (int) $data['hydratation_note']     : null,
            tendanceAlimentaire:       $data['tendance_alimentaire']        ?? null,
            consommationAlcool:        $data['consommation_alcool']         ?? null,
            difficulteAlimentaire:     $data['difficulte_alimentaire']      ?? null,
            regimeParticulier:         $data['regime_particulier']          ?? null,
            allergies:                 $data['allergies']                   ?? null,
            programmeStructureSuivi:   $data['programme_structure_suivi']   ?? null,
            programmeCeQuiFonctionne:  $data['programme_ce_qui_fonctionne'] ?? null,
            programmeCeQuiEchoue:      $data['programme_ce_qui_echoue']     ?? null,
            sentimentBlockage:         $data['sentiment_blocage']           ?? null,
            blocageRaison:             $data['blocage_raison']              ?? null,
            pratiqueIrreguliere:       $data['pratique_irreguliere']        ?? null,
            dureeSeance:               $data['duree_seance']                ?? null,
            lieuEntrainement:          $data['lieu_entrainement']           ?? null,
            niveauMotivation:          isset($data['niveau_motivation'])    ? (int) $data['niveau_motivation']    : null,
            accompagnementSerieux:     $data['accompagnement_serieux']      ?? null,
            changementsModeVie:        $data['changements_mode_vie']        ?? null,
            dateDebutSouhaitee:        $data['date_debut_souhaitee']        ?? null,
            id:                        isset($data['id'])                   ? (int) $data['id']                   : null,
            dateRempli:                $data['date_rempli']                 ?? null,
        );
    }
}
