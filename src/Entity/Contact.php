<?php

declare(strict_types=1);

namespace Entity;

class Contact
{
    private ?int    $id;
    private string  $nom;
    private string  $email;
    private string  $message;
    private ?string $dateEnvoi;
    private bool    $lu;

    public function __construct(
        ?int    $id        = null,
        string  $nom       = '',
        string  $email     = '',
        string  $message   = '',
        ?string $dateEnvoi = null,
        bool    $lu        = false
    ) {
        $this->id        = $id;
        $this->nom       = $nom;
        $this->email     = $email;
        $this->message   = $message;
        $this->dateEnvoi = $dateEnvoi;
        $this->lu        = $lu;
    }

    /* Getters */

    public function getId(): ?int          { return $this->id; }
    public function getNom(): string       { return $this->nom; }
    public function getEmail(): string     { return $this->email; }
    public function getMessage(): string   { return $this->message; }
    public function getDateEnvoi(): ?string { return $this->dateEnvoi; }
    public function isLu(): bool           { return $this->lu; }

    /* Setters */

    public function setId(?int $id): void  { $this->id = $id; }
    public function setLu(bool $lu): void  { $this->lu = $lu; }

    public function setNom(string $nom): void
    {
        $nom = trim($nom);
        if (empty($nom)) throw new \InvalidArgumentException('Nom invalide.');
        $this->nom = $nom;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email invalide.');
        }
        $this->email = trim($email);
    }

    public function setMessage(string $message): void
    {
        $message = trim($message);
        if (empty($message)) throw new \InvalidArgumentException('Message invalide.');
        $this->message = $message;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            id:        isset($data['id']) ? (int) $data['id'] : null,
            nom:       $data['nom']        ?? '',
            email:     $data['email']      ?? '',
            message:   $data['message']    ?? '',
            dateEnvoi: $data['date_envoi'] ?? null,
            lu:        (bool) ($data['lu'] ?? false),
        );
    }
}
