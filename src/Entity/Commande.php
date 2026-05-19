<?php

declare(strict_types=1);

namespace Entity;

class Commande
{
    private ?int    $id;
    private int     $utilisateurId;
    private int     $programmeId;
    private ?string $date;
    private float   $montant;

    // Champs joints (non stockés en BDD)
    private ?string $programmeTitre;
    private ?string $programmeType;
    private ?string $utilisateurNom;
    private ?string $utilisateurPrenom;
    private ?string $utilisateurEmail;

    public function __construct(
        ?int    $id                 = null,
        int     $utilisateurId     = 0,
        int     $programmeId       = 0,
        ?string $date              = null,
        float   $montant           = 0.0,
        ?string $programmeTitre    = null,
        ?string $programmeType     = null,
        ?string $utilisateurNom    = null,
        ?string $utilisateurPrenom = null,
        ?string $utilisateurEmail  = null,
    ) {
        $this->id                = $id;
        $this->utilisateurId     = $utilisateurId;
        $this->programmeId       = $programmeId;
        $this->date              = $date;
        $this->montant           = $montant;
        $this->programmeTitre    = $programmeTitre;
        $this->programmeType     = $programmeType;
        $this->utilisateurNom    = $utilisateurNom;
        $this->utilisateurPrenom = $utilisateurPrenom;
        $this->utilisateurEmail  = $utilisateurEmail;
    }

    /* Getters */

    public function getId(): ?int                    { return $this->id; }
    public function getUtilisateurId(): int          { return $this->utilisateurId; }
    public function getProgrammeId(): int            { return $this->programmeId; }
    public function getDate(): ?string               { return $this->date; }
    public function getMontant(): float              { return $this->montant; }
    public function getProgrammeTitre(): ?string     { return $this->programmeTitre; }
    public function getProgrammeType(): ?string      { return $this->programmeType; }
    public function getUtilisateurNom(): ?string     { return $this->utilisateurNom; }
    public function getUtilisateurPrenom(): ?string  { return $this->utilisateurPrenom; }
    public function getUtilisateurEmail(): ?string   { return $this->utilisateurEmail; }

    /* Setters */

    public function setId(?int $id): void            { $this->id = $id; }
    public function setUtilisateurId(int $id): void  { $this->utilisateurId = $id; }
    public function setProgrammeId(int $id): void    { $this->programmeId = $id; }

    public function setMontant(float $montant): void
    {
        if ($montant < 0) {
            throw new \InvalidArgumentException('Le montant ne peut pas être négatif.');
        }
        $this->montant = $montant;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            id:                 isset($data['id'])             ? (int) $data['id']  : null,
            utilisateurId:      (int) ($data['utilisateur_id'] ?? 0),
            programmeId:        (int) ($data['programme_id']   ?? 0),
            date:               $data['date']                  ?? null,
            montant:            (float) ($data['montant']       ?? 0),
            programmeTitre:     $data['programme_titre']        ?? null,
            programmeType:      $data['programme_type']         ?? null,
            utilisateurNom:     $data['utilisateur_nom']        ?? null,
            utilisateurPrenom:  $data['utilisateur_prenom']     ?? null,
            utilisateurEmail:   $data['utilisateur_email']      ?? null,
        );
    }
}
