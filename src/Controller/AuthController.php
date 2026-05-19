<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Service\AuthService;
use Service\MailService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    // Connexion

    public function loginForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/mon-espace');
        }

        $this->render('auth/login', [
            'csrf_token' => Session::generateCsrfToken(),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    public function login(): void
    {
        $this->verifyCsrf();

        $email    = trim($this->post('email'));
        $password = $this->post('password');

        try {
            $user = $this->authService->login($email, $password);

            if ($user === null) {
                Session::setFlash('errors', ['Email ou mot de passe incorrect.']);
                $this->redirect('/connexion');
            }

            $redirect = Session::get('redirect_after_login');
            Session::remove('redirect_after_login');

            if ($redirect) {
                $this->redirect($redirect);
            }

            $this->redirect($user->isAdmin() ? '/admin' : '/');

        } catch (\RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
            $this->redirect('/connexion');
        }
    }

    // Inscription

    public function registerForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/mon-espace');
        }

        $this->render('auth/register', [
            'csrf_token' => Session::generateCsrfToken(),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    public function register(): void
    {
        $this->verifyCsrf();

        try {
            $userId = $this->authService->register($_POST);

            // Mail de bienvenue
            $mailService = new MailService();
            $mailService->sendBienvenue(
                trim($_POST['email']  ?? ''),
                trim($_POST['prenom'] ?? '')
            );

            // Connexion automatique après inscription redirige vers questionnaire 
                $this->authService->login(
                    trim($_POST['email'] ?? ''),
                    $_POST['password'] ?? ''
                );
                $this->redirect('/questionnaire');

        } catch (\InvalidArgumentException | \RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
            $this->redirect('/inscription');
        }
    }

    // Déconnexion

    public function logout(): void
    {
        $this->authService->logout();
        $this->redirect('/connexion');
    }

    // Mot de passe oublié

    public function showForgotForm(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/mon-espace');
        }

        $this->render('auth/forgot', [
            'csrf_token' => Session::generateCsrfToken(),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    public function forgot(): void
    {
        $this->verifyCsrf();

        $email = trim($this->post('email'));

        try {
            $token = $this->authService->forgot($email);

            // On envoie le mail uniquement si l'email existe
            if ($token !== null) {
                $mailService = new MailService();
                $mailService->sendReinitialisationMdp($email, $token);
            }

            // Message générique (ne révèle pas si l'email existe)
            Session::setFlash('success', 'Si un compte correspond à cet email, un lien de réinitialisation a été envoyé.');
            $this->redirect('/mot-de-passe-oublie');

        } catch (\InvalidArgumentException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
            $this->redirect('/mot-de-passe-oublie');
        }
    }

    // Réinitialisation du mot de passe

    public function showResetForm(): void
    {
        $token = $this->get('token');

        if (empty($token)) {
            $this->redirect('/mot-de-passe-oublie');
        }

        $this->render('auth/reset', [
            'csrf_token' => Session::generateCsrfToken(),
            'token'      => htmlspecialchars($token),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    public function reset(): void
    {
        $this->verifyCsrf();

        $token    = $this->post('token');
        $password = $this->post('password');
        $confirm  = $this->post('password_confirm');

        try {
            $this->authService->reset($token, $password, $confirm);
            Session::setFlash('success', 'Mot de passe modifié avec succès. Vous pouvez vous connecter.');
            $this->redirect('/connexion');

        } catch (\InvalidArgumentException | \RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
            $this->redirect('/reinitialiser-mdp?token=' . urlencode($token));
        }
    }

    // Vérification email en temps réel (AJAX — CP4)

    public function checkEmail(): void
    {
        if (!$this->isAjax()) {
            $this->redirect('/');
        }

        $email = trim($this->post('email'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['error' => 'invalid']);
        }

        $userRepository = new \Repository\UserRepository();
        $exists         = $userRepository->emailExists($email);

        $this->json(['available' => !$exists]);
    }
}
