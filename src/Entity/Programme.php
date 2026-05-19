<?php

declare(strict_types=1);

namespace Entity;

/* Entité programme */

class Programme
{
    private ?int    $id;
    private string  $type;
    private string  $titre;
    private string  $description;
    private ?string $objectifs;
    private ?string $inclut;
    private ?string $tarifs;
    private float   $prix;
    private ?string $createdAt;

    public function __construct(
        ?int    $id          = null,
        string  $type        = '',
        string  $titre       = '',
        string  $description = '',
        ?string $objectifs   = null,
        ?string $inclut      = null,
        ?string $tarifs      = null,
        float   $prix        = 0.0,
        ?string $createdAt   = null
    ) {
        $this->id          = $id;
        $this->type        = $type;
        $this->titre       = $titre;
        $this->description = $description;
        $this->objectifs   = $objectifs;
        $this->inclut      = $inclut;
        $this->tarifs      = $tarifs;
        $this->prix        = $prix;
        $this->createdAt   = $createdAt;
    }

    /* Getters */

    public function getId(): ?int          { return $this->id; }
    public function getType(): string      { return $this->type; }
    public function getTitre(): string     { return $this->titre; }
    public function getDescription(): string { return $this->description; }
    public function getObjectifs(): ?string { return $this->objectifs; }
    public function getInclut(): ?string   { return $this->inclut; }
    public function getTarifs(): ?string   { return $this->tarifs; }
    public function getPrix(): float       { return $this->prix; }
    public function getCreatedAt(): ?string { return $this->createdAt; }

    /* Setters */

    public function setType(string $type): void
    {
        $typesValides = ['domicile_salle', 'nutritionnel', 'pack', 'transformation', 'visio', 'complet', 'intensif'];
        if (!in_array($type, $typesValides, true)) {
            throw new \InvalidArgumentException('Type de programme invalide.');
        }
        $this->type = $type;
    }

    public function setTitre(string $titre): void
    {
        $titre = trim($titre);
        if (empty($titre) || strlen($titre) > 255) {
            throw new \InvalidArgumentException('Titre invalide.');
        }
        $this->titre = $titre;
    }

    public function setDescription(string $description): void
    {
        if (empty(trim($description))) {
            throw new \InvalidArgumentException('Description invalide.');
        }
        $this->description = $description;
    }

    public function setPrix(float $prix): void
    {
        if ($prix <= 0) {
            throw new \InvalidArgumentException('Le prix doit être positif.');
        }
        $this->prix = $prix;
    }

    public function setObjectifs(?string $objectifs): void { $this->objectifs = $objectifs; }
    public function setInclut(?string $inclut): void { $this->inclut = $inclut; }
    public function setTarifs(?string $tarifs): void { $this->tarifs = $tarifs; }

    /* Helpers */

    public function isRecommande(): bool
    {
        return $this->type === 'transformation';
    }

    public function getPrixFormate(): string
    {
        return number_format($this->prix, 0, ',', '') . '€';
    }

    public static function fromArray(array $data): static
    {
        return new static(
            id:          isset($data['id'])         ? (int) $data['id']      : null,
            type:        $data['type']               ?? '',
            titre:       $data['titre']              ?? '',
            description: $data['description']        ?? '',
            objectifs:   $data['objectifs']          ?? null,
            inclut:      $data['inclut']             ?? null,
            tarifs:      $data['tarifs']             ?? null,
            prix:        isset($data['prix'])        ? (float) $data['prix'] : 0.0,
            createdAt:   $data['created_at']         ?? null,
        );
    }
}
