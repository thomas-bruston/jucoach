<?php

declare(strict_types=1);

namespace Entity;

/* Entité utilisateur */

class User
{
    private ?int    $id;
    private string  $email;
    private string  $password;
    private string  $prenom;
    private string  $nom;
    private ?string $telephone;
    private ?string $adresse;
    private string  $statut;
    private string  $role;
    private ?int    $roleId;
    private ?string $createdAt;

    public function __construct(
        string  $email,
        string  $password,
        string  $prenom,
        string  $nom,
        ?string $telephone = null,
        ?string $adresse   = null,
        string  $statut    = 'actif',
        string  $role      = 'utilisateur',
        ?int    $roleId    = null,
        ?int    $id        = null,
        ?string $createdAt = null
    ) {
        $this->email     = $email;
        $this->password  = $password;
        $this->prenom    = $prenom;
        $this->nom       = $nom;
        $this->telephone = $telephone;
        $this->adresse   = $adresse;
        $this->statut    = $statut;
        $this->role      = $role;
        $this->roleId    = $roleId;
        $this->id        = $id;
        $this->createdAt = $createdAt;
    }

    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    // Setters

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    // Helpers

    public function isAdmin(): bool
    {
        return $this->role === 'administrateur';
    }

    public function isUtilisateur(): bool
    {
        return $this->role === 'utilisateur';
    }

    public function isActif(): bool
    {
        return $this->statut === 'actif';
    }

    public function getFullName(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
