<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Repository\UserRepository;
use Repository\CommandeRepository;
use Repository\QuestionnaireRepository;

/* AdminController */

class AdminController extends Controller
{
    private UserRepository          $userRepository;
    private CommandeRepository      $commandeRepository;
    private QuestionnaireRepository $questionnaireRepository;

    public function __construct()
    {
        $this->userRepository          = new UserRepository();
        $this->commandeRepository      = new CommandeRepository();
        $this->questionnaireRepository = new QuestionnaireRepository();
    }

    /* Dashboard admin */

    public function dashboard(): void
    {
        $this->render('admin/dashboard');
    }

    /* Liste des clients */

    public function clients(): void
    {
        $clients = $this->userRepository->findAllClients();

        // Pour chaque client, charger son questionnaire et ses commandes
        $questionnaires = [];
        $commandes      = [];
        foreach ($clients as $client) {
            $questionnaires[$client->getId()] = $this->questionnaireRepository->findByUtilisateurId($client->getId());
            $commandes[$client->getId()]      = $this->commandeRepository->findByUtilisateurId($client->getId());
        }

        $this->render('admin/clients/index', [
            'clients'        => $clients,
            'questionnaires' => $questionnaires,
            'commandes'      => $commandes,
            'csrf_token'     => Session::generateCsrfToken(),
            'success'        => Session::getFlash('success'),
            'error'          => Session::getFlash('error'),
        ]);
    }

    /* Voir le questionnaire complet d'un client */

    public function voirQuestionnaire(): void
    {
        $userId = (int) $this->get('id');

        if ($userId <= 0) {
            $this->redirect('/admin/clients');
        }

        $client        = $this->userRepository->findById($userId);
        $questionnaire = $this->questionnaireRepository->findByUtilisateurId($userId);

        if ($client === null) {
            $this->redirect('/admin/clients');
        }

        $this->render('admin/clients/questionnaire', [
            'client'        => $client,
            'questionnaire' => $questionnaire,
        ]);
    }

    /* Supprime un client */

    public function supprimerClient(): void
    {
        $this->verifyCsrf();

        $userId = (int) $this->post('user_id');

        try {
            $this->userRepository->delete($userId);
            Session::setFlash('success', 'Client supprimé.');
        } catch (\RuntimeException $e) {
            error_log('[AdminController::supprimerClient] ' . $e->getMessage());
            Session::setFlash('error', 'Une erreur est survenue lors de la suppression du client.');
        }

        $this->redirect('/admin/clients');
    }
}
