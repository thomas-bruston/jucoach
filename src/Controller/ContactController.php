<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Entity\Contact;
use Repository\ContactRepository;
use Service\MailService;

/* ContactController */

class ContactController extends Controller
{
    private ContactRepository $contactRepository;

    public function __construct()
    {
        $this->contactRepository = new ContactRepository();
    }

    public function index(): void
    {
        $this->render('pages/contact', [
            'csrf_token' => Session::generateCsrfToken(),
            'error'      => Session::getFlash('error'),
            'success'    => Session::getFlash('success'),
        ]);
    }

    /* Soumission formulaire contact — AJAX (CP4) */

    public function store(): void
    {
        $this->verifyCsrf();

        try {
            $contact = new Contact();
            $contact->setNom(trim($this->post('nom')));
            $contact->setEmail(trim($this->post('email')));
            $contact->setMessage(trim($this->post('message')));

            $this->contactRepository->create($contact);

            // Notification mail à Ju
            $mailService = new MailService();
            $mailService->sendNotificationContact(
                $contact->getNom(),
                $contact->getEmail(),
                $contact->getMessage()
            );

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Votre message a bien été envoyé. Ju vous répondra très prochainement !']);
            }

            Session::setFlash('success', 'Votre message a bien été envoyé. Ju vous répondra très prochainement !');
            $this->redirect('/contact');

        } catch (\InvalidArgumentException $e) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            Session::setFlash('error', $e->getMessage());
            $this->redirect('/contact');
        }
    }

    /* Espace admin — liste des messages */

    public function adminIndex(): void
    {
        $messages = $this->contactRepository->findAll();

        $this->render('admin/messages/index', [
            'messages' => $messages,
            'success'  => Session::getFlash('success'),
            'error'    => Session::getFlash('error'),
        ]);
    }

    /* Supprime un message */

    public function delete(): void
    {
        $this->verifyCsrf();

        $id = (int) $this->post('contact_id');
        $this->contactRepository->delete($id);

        Session::setFlash('success', 'Message supprimé.');
        $this->redirect('/admin/messages');
    }
}
