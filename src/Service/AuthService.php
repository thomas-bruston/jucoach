<?php

declare(strict_types=1);

namespace Service;

use Core\Session;
use Entity\User;
use Repository\UserRepository;

/* Authentification */

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
{
    $this->userRepository = $userRepository ?? new UserRepository();
}

    // Connexion

    public function login(string $email, string $password): ?User
    {
        if (empty($email) || empty($password)) {
            return null;
        }

        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!$user->isActif()) {
            return null;
        }

        if (!password_verify($password, $user->getPassword())) {
            return null;
        }

        $this->storeInSession($user);
        return $user;
    }

    private function storeInSession(User $user): void
    {
        Session::regenerate();
        Session::set('user_id',   $user->getId());
        Session::set('user_role', $user->getRole());
        Session::set('user', [
            'id'     => $user->getId(),
            'prenom' => $user->getPrenom(),
            'nom'    => $user->getNom(),
            'email'  => $user->getEmail(),
            'role'   => $user->getRole(),
        ]);
    }

    // Déconnexion

    public function logout(): void
    {
        Session::destroy();
    }

    // Inscription

    public function register(array $data): int
    {
        $nom       = trim($data['nom']    ?? '');
        $prenom    = trim($data['prenom'] ?? '');
        $email     = trim($data['email']  ?? '');
        $password  = $data['password']         ?? '';
        $confirm   = $data['password_confirm'] ?? '';
        $telephone = trim($data['telephone']   ?? '') ?: null;
        $adresse   = trim($data['adresse']     ?? '') ?: null;
        $consent   = $data['consent_donnees']  ?? null;

        if (empty($nom) || empty($prenom)) {
            throw new \InvalidArgumentException('Nom et prénom sont obligatoires.');
        }

        if ($consent === null) {
            throw new \InvalidArgumentException('Vous devez accepter la politique de confidentialité pour créer un compte.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Adresse email invalide.');
        }

        if ($this->userRepository->emailExists($email)) {
            throw new \RuntimeException('Cette adresse email est déjà utilisée.');
        }

        $passwordErrors = $this->validatePassword($password, $confirm);
        if (!empty($passwordErrors)) {
            throw new \InvalidArgumentException(implode(' ', $passwordErrors));
        }

        $user = new User(
            email:     $email,
            password:  password_hash($password, PASSWORD_BCRYPT),
            prenom:    $prenom,
            nom:       $nom,
            telephone: $telephone,
            adresse:   $adresse,
            statut:    'actif',
            role:      'utilisateur',
            roleId:    1
        );

        return $this->userRepository->create($user);
    }

    // Mot de passe oublié — génère et sauvegarde un token

    public function forgot(string $email): ?string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Adresse email invalide.');
        }

        $user = $this->userRepository->findByEmail($email);

        // On ne révèle pas si l'email existe ou non (sécurité)
        if ($user === null) {
            return null;
        }

        $token    = bin2hex(random_bytes(32));
        $expireAt = date('Y-m-d H:i:s', time() + 3600); // 1 heure

        $this->userRepository->savePasswordResetToken($user->getId(), $token, $expireAt);

        return $token;
    }

    // Réinitialisation du mot de passe

    public function reset(string $token, string $password, string $confirm): void
    {
        $resetData = $this->userRepository->findByResetToken($token);

        if ($resetData === null) {
            throw new \RuntimeException('Lien de réinitialisation invalide ou expiré.');
        }

        $passwordErrors = $this->validatePassword($password, $confirm);
        if (!empty($passwordErrors)) {
            throw new \InvalidArgumentException(implode(' ', $passwordErrors));
        }

        $this->userRepository->updatePassword(
            (int) $resetData['utilisateur_id'],
            password_hash($password, PASSWORD_BCRYPT)
        );

        $this->userRepository->markResetTokenAsUsed($token);
    }

    // Validation mot de passe

    public function validatePassword(string $password, string $confirm = ''): array
    {
        $errors = [];

        if (strlen($password) < 10) {
            $errors[] = 'Le mot de passe doit contenir au moins 10 caractères.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une majuscule.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins une minuscule.';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un chiffre.';
        }

        if (!preg_match('/[\W_]/', $password)) {
            $errors[] = 'Le mot de passe doit contenir au moins un caractère spécial.';
        }

        if (!empty($confirm) && $password !== $confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        return $errors;
    }
}
