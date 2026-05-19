<?php

declare(strict_types=1);

namespace Entity;

/* Entité vidéo YouTube de galerie */

class GalerieVideo
{
    private ?int    $id;
    private string  $urlYoutube;
    private string  $titre;
    private ?string $description;
    private int     $ordre;
    private ?string $dateAjout;

    public function __construct(
        string  $urlYoutube  = '',
        string  $titre       = '',
        ?string $description = null,
        int     $ordre       = 0,
        ?int    $id          = null,
        ?string $dateAjout   = null
    ) {
        $this->urlYoutube  = $urlYoutube;
        $this->titre       = $titre;
        $this->description = $description;
        $this->ordre       = $ordre;
        $this->id          = $id;
        $this->dateAjout   = $dateAjout;
    }

    /* Getters */

    public function getId(): ?int             { return $this->id; }
    public function getUrlYoutube(): string   { return $this->urlYoutube; }
    public function getTitre(): string        { return $this->titre; }
    public function getDescription(): ?string { return $this->description; }
    public function getOrdre(): int           { return $this->ordre; }
    public function getDateAjout(): ?string   { return $this->dateAjout; }

    /* Setters */

    public function setUrlYoutube(string $url): void
    {
        $url = trim($url);
        if (empty($url)) throw new \InvalidArgumentException('URL YouTube invalide.');
        $this->urlYoutube = $url;
    }

    public function setTitre(string $titre): void
    {
        $titre = trim($titre);
        if (empty($titre)) throw new \InvalidArgumentException('Titre invalide.');
        $this->titre = $titre;
    }

    public function setDescription(?string $description): void { $this->description = $description; }
    public function setOrdre(int $ordre): void                 { $this->ordre = $ordre; }

    /* Retourne l'ID YouTube pour l'embed */

    public function getYoutubeId(): string
    {
        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->urlYoutube, $matches);
        return $matches[1] ?? '';
    }

    public function getEmbedUrl(): string
    {
        $id = $this->getYoutubeId();
        return $id ? "https://www.youtube.com/embed/{$id}" : '';
    }

    public static function fromArray(array $data): static
    {
        return new static(
            urlYoutube:  $data['url_youtube']  ?? '',
            titre:       $data['titre']        ?? '',
            description: $data['description']  ?? null,
            ordre:       isset($data['ordre']) ? (int) $data['ordre'] : 0,
            id:          isset($data['id'])    ? (int) $data['id']    : null,
            dateAjout:   $data['date_ajout']   ?? null,
        );
    }
}
