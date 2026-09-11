#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Crée le compte administrateur en production.
 * Usage : docker compose -f docker-compose.prod.yml exec app php bin/create-admin.php
 */

if (PHP_SAPI !== 'cli') {
    exit('Ce script ne peut être exécuté qu\'en ligne de commande.' . PHP_EOL);
}

define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/vendor/autoload.php';

require_once ROOT_PATH . '/src/Core/Env.php';
\Core\Env::load(ROOT_PATH . '/.env');

use Entity\User;
use Repository\UserRepository;
use Service\AuthService;

function prompt(string $label): string
{
    fwrite(STDOUT, $label);
    return trim((string) fgets(STDIN));
}

function promptHidden(string $label): string
{
    fwrite(STDOUT, $label);
    if (stripos(PHP_OS, 'WIN') === 0) {
        return trim((string) fgets(STDIN));
    }
    system('stty -echo 2>/dev/null');
    $value = trim((string) fgets(STDIN));
    system('stty echo 2>/dev/null');
    fwrite(STDOUT, PHP_EOL);
    return $value;
}

$email = prompt('Email de l\'administrateur : ');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, 'Adresse email invalide.' . PHP_EOL);
    exit(1);
}

$userRepository = new UserRepository();
if ($userRepository->emailExists($email)) {
    fwrite(STDERR, "Un compte existe déjà avec cet email." . PHP_EOL);
    exit(1);
}

$prenom = prompt('Prénom : ');
$nom    = prompt('Nom : ');

$password = promptHidden('Mot de passe (min. 10 car., 1 maj., 1 min., 1 chiffre, 1 spécial) : ');
$confirm  = promptHidden('Confirmer le mot de passe : ');

$authService = new AuthService($userRepository);
$errors      = $authService->validatePassword($password, $confirm);
if (!empty($errors)) {
    fwrite(STDERR, implode(PHP_EOL, $errors) . PHP_EOL);
    exit(1);
}

if ($password !== $confirm) {
    fwrite(STDERR, 'Les mots de passe ne correspondent pas.' . PHP_EOL);
    exit(1);
}

$admin = new User(
    email:     $email,
    password:  password_hash($password, PASSWORD_BCRYPT),
    prenom:    $prenom,
    nom:       $nom,
    statut:    'actif',
    role:      'administrateur',
    roleId:    2
);

$id = $userRepository->create($admin);

fwrite(STDOUT, "Compte administrateur créé (id {$id})." . PHP_EOL);
