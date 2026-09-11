<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Repository\UserRepository;
use Repository\CommandeRepository;

/* ProfilController */

class ProfilController extends Controller
{
    private UserRepository     $userRepository;
    private CommandeRepository $commandeRepository;

    public function __construct()
    {
        $this->userRepository     = new UserRepository();
        $this->commandeRepository = new CommandeRepository();
    }

    /* Affiche et permet la modification des infos personnelles */

    public function showProfil(): void
    {
        $user = $this->userRepository->findById(Session::getUserId());

        $this->render('user/profil', [
            'csrf_token' => Session::generateCsrfToken(),
            'user'       => $user,
            'success'    => Session::getFlash('success'),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    /* Met à jour les infos personnelles */

    public function updateProfil(): void
    {
        $this->verifyCsrf();

        $user = $this->userRepository->findById(Session::getUserId());

        try {
            $user->setNom(trim($this->post('nom')));
            $user->setPrenom(trim($this->post('prenom')));
            $user->setEmail(trim($this->post('email')));
            $user->setTelephone(trim($this->post('telephone')) ?: null);
            $user->setAdresse(trim($this->post('adresse')) ?: null);

            $this->userRepository->update($user);

            // MAJ session
            Session::set('user', [
                'id'     => $user->getId(),
                'prenom' => $user->getPrenom(),
                'nom'    => $user->getNom(),
                'email'  => $user->getEmail(),
                'role'   => $user->getRole(),
            ]);

            Session::setFlash('success', 'Vos informations ont été mises à jour.');
            $this->redirect('/mon-profil');

        } catch (\InvalidArgumentException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
            $this->redirect('/mon-profil');
        }
    }

    /* Supprime définitivement le compte du client connecté (droit à l'effacement RGPD) */

    public function deleteAccount(): void
    {
        $this->verifyCsrf();

        $user     = $this->userRepository->findById(Session::getUserId());
        $password = $this->post('password_confirm_delete');

        if ($user === null || !password_verify($password, $user->getPassword())) {
            Session::setFlash('errors', ['Mot de passe incorrect. Le compte n\'a pas été supprimé.']);
            $this->redirect('/mon-profil');
        }

        try {
            $this->userRepository->delete($user->getId());
        } catch (\RuntimeException $e) {
            error_log('[ProfilController::deleteAccount] ' . $e->getMessage());
            Session::setFlash('errors', ['Une erreur est survenue. Veuillez réessayer.']);
            $this->redirect('/mon-profil');
        }

        // Déconnexion sans détruire immédiatement la session (pour afficher le message)
        Session::remove('user_id');
        Session::remove('user_role');
        Session::remove('user');
        Session::regenerate();

        Session::setFlash('success', 'Votre compte et vos données ont été supprimés.');
        $this->redirect('/connexion');
    }

    /* Affiche les programmes achetés */

    public function monProgramme(): void
    {
        $commandes = $this->commandeRepository->findByUtilisateurId(Session::getUserId());

        $this->render('user/mon-programme', [
            'commandes' => $commandes,
        ]);
    }

    /* Affiche le statut du plan nutritionnel */

    public function monPlanNutritionnel(): void
    {
        $commandes = $this->commandeRepository->findByUtilisateurId(Session::getUserId());

        // Filtre uniquement les commandes de type nutritionnel payées
        $commandesNutri = array_filter(
            $commandes,
            fn($c) => $c->getProgrammeType() === 'nutritionnel' && $c->getStatut() === 'payee'
        );

        $this->render('user/mon-plan-nutritionnel', [
            'commandes' => array_values($commandesNutri),
        ]);
    }
}