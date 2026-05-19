<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Entity\Commande;
use Repository\CommandeRepository;
use Repository\ProgrammeRepository;
use Service\MongoService;
use Service\MailService;

class CommandeController extends Controller
{
    private CommandeRepository  $commandeRepository;
    private ProgrammeRepository $programmeRepository;
    private MongoService        $mongoService;
    private MailService         $mailService;

    public function __construct()
    {
        $this->commandeRepository  = new CommandeRepository();
        $this->programmeRepository = new ProgrammeRepository();
        $this->mongoService        = new MongoService();
        $this->mailService         = new MailService();
    }

    /* Le client choisit un programme */

    public function choisir(): void
    {
        $this->verifyCsrf();

        if (!Session::isLoggedIn()) {
            $this->redirect('/connexion');
        }

        $programmeId = (int) $this->post('programme_id');
        $user        = Session::get('user');
        $utilisateurId = (int) ($user['id'] ?? 0);

        if ($programmeId <= 0 || $utilisateurId <= 0) {
            $this->redirect('/programmes');
        }

        $programme = $this->programmeRepository->findById($programmeId);

        if ($programme === null) {
            $this->redirect('/programmes');
        }

        // Vérifie si le client a déjà choisi ce programme
        if ($this->commandeRepository->existsForUtilisateur($utilisateurId, $programmeId)) {
            Session::setFlash('error', 'Vous avez déjà choisi ce programme.');
            $this->redirect('/programmes/detail?id=' . $programmeId);
        }

        try {
            $commande = new Commande();
            $commande->setUtilisateurId($utilisateurId);
            $commande->setProgrammeId($programmeId);
            $commande->setMontant($programme->getPrix());

            $commandeId = $this->commandeRepository->create($commande);

            // Enregistrement dans MongoDB pour les stats
            $this->mongoService->enregistrerCommande(
                $commandeId,
                $programmeId,
                $programme->getTitre(),
                $programme->getType(),
                date('Y-m-d'),
                $programme->getPrix()
            );

            // Mail de confirmation au client
            $this->mailService->sendConfirmationAchat(
                $user['email'] ?? '',
                $user['prenom'] ?? '',
                $programme->getTitre(),
                $programme->getPrix()
            );

            // Notification à Ju
            $this->mailService->sendNotificationCommande(
                $user['prenom'] ?? '',
                $user['nom'] ?? '',
                $user['email'] ?? '',
                $programme->getTitre(),
                $programme->getPrix()
            );

            Session::setFlash('success', 'Programme choisi ! Ju va vous contacter très prochainement.');
            $this->redirect('/mon-programme');

        } catch (\Exception $e) {
            error_log('[CommandeController::choisir] ' . $e->getMessage());
            Session::setFlash('error', 'Une erreur est survenue. Veuillez réessayer.');
            $this->redirect('/programmes/detail?id=' . $programmeId);
        }
    }
}
