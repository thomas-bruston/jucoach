<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Repository\UserRepository;
use Repository\CommandeRepository;
use Repository\QuestionnaireRepository;
use Service\MongoService;

/* AdminController */

class AdminController extends Controller
{
    private UserRepository          $userRepository;
    private CommandeRepository      $commandeRepository;
    private QuestionnaireRepository $questionnaireRepository;
    private MongoService            $mongoService;

    public function __construct()
    {
        $this->userRepository          = new UserRepository();
        $this->commandeRepository      = new CommandeRepository();
        $this->questionnaireRepository = new QuestionnaireRepository();
        $this->mongoService            = new MongoService();
    }

    /* Dashboard admin */

    public function dashboard(): void
    {
        $this->render('admin/dashboard', [
            'success' => Session::getFlash('success'),
            'error'   => Session::getFlash('error'),
        ]);
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
        $this->userRepository->delete($userId);

        Session::setFlash('success', 'Client supprimé.');
        $this->redirect('/admin/clients');
    }

    /* Statistiques MongoDB */

    public function statistiques(): void
    {
        $dateDebut = $this->get('date_debut', date('Y-01-01'));
        $dateFin   = $this->get('date_fin',   date('Y-m-d'));

        $commandesParProgramme = $this->mongoService->getNombreCommandesParProgramme();
        $caParProgramme        = $this->mongoService->getCAParProgramme($dateDebut, $dateFin);

        $statsParProgramme = [];
        foreach ($commandesParProgramme as $cmd) {
            $programmeId = $cmd['programme_id'];
            $ca = 0;
            foreach ($caParProgramme as $c) {
                if ($c['programme_id'] === $programmeId) {
                    $ca = $c['chiffre_affaires'];
                    break;
                }
            }
            $statsParProgramme[] = [
                'programme_titre' => $cmd['programme_titre'],
                'programme_type'  => $cmd['programme_type'],
                'nb_commandes'    => $cmd['nombre_commandes'],
                'ca_total'        => $ca,
            ];
        }

        $this->render('admin/statistiques', [
            'statsParProgramme' => $statsParProgramme,
            'ca_total'          => $this->mongoService->getCATotalPeriode($dateDebut, $dateFin),
            'dateDebut'         => $dateDebut,
            'dateFin'           => $dateFin,
        ]);
    }
}
