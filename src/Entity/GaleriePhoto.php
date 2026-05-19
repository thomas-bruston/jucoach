<?php

declare(strict_types=1);

namespace Entity;

/* Entité photo de galerie */

class GaleriePhoto
{
    private ?int    $id;
    private string  $fichier;
    private ?string $legende;
    private int     $ordre;
    private ?string $dateAjout;

    public function __construct(
        string  $fichier   = '',
        ?string $legende   = null,
        int     $ordre     = 0,
        ?int    $id        = null,
        ?string $dateAjout = null
    ) {
        $this->fichier   = $fichier;
        $this->legende   = $legende;
        $this->ordre     = $ordre;
        $this->id        = $id;
        $this->dateAjout = $dateAjout;
    }

    /* Getters */

    public function getId(): ?int          { return $this->id; }
    public function getFichier(): string   { return $this->fichier; }
    public function getLegende(): ?string  { return $this->legende; }
    public function getOrdre(): int        { return $this->ordre; }
    public function getDateAjout(): ?string { return $this->dateAjout; }

    /* Setters */

    public function setFichier(string $fichier): void   { $this->fichier = $fichier; }
    public function setLegende(?string $legende): void  { $this->legende = $legende; }
    public function setOrdre(int $ordre): void          { $this->ordre = $ordre; }

    public static function fromArray(array $data): static
    {
        return new static(
            fichier:   $data['fichier']    ?? '',
            legende:   $data['legende']    ?? null,
            ordre:     (int) ($data['ordre'] ?? 0),
            id:        isset($data['id'])  ? (int) $data['id'] : null,
            dateAjout: $data['date_ajout'] ?? null,
        );
    }
}
