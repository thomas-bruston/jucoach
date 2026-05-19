<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Service\QuestionnaireService;

/* QuestionnaireController */

class QuestionnaireController extends Controller
{
    private QuestionnaireService $questionnaireService;

    public function __construct()
    {
        $this->questionnaireService = new QuestionnaireService();
    }

    /* Affiche le formulaire du questionnaire */

    public function show(): void
    {
        $userId = Session::getUserId();

        // Déjà rempli — redirection espace client
        if ($this->questionnaireService->dejaRempli($userId)) {
            Session::setFlash('error', 'Vous avez déjà rempli votre questionnaire.');
            $this->redirect('/mon-espace');
        }

        $this->render('questionnaire/show', [
            'csrf_token' => Session::generateCsrfToken(),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    /* Enregistre le questionnaire */

    public function store(): void
    {
        $this->verifyCsrf();

        $userId = Session::getUserId();

        try {
            $this->questionnaireService->store($userId, $_POST);

            Session::setFlash('success', 'Votre questionnaire a bien été enregistré. Julien prendra contact avec vous très prochainement !');
            $this->redirect('/mon-espace');

        } catch (\InvalidArgumentException | \RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
            $this->redirect('/questionnaire');
        }
    }
}
