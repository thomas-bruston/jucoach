<?php

declare(strict_types=1);

namespace Core;

/* Classe Router */

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        // Pages visiteur

        $this->add('GET',  '/',                         'HomeController',              'index',              null);
        $this->add('GET',  '/programmes',               'ProgrammeController',         'index',              null);
        $this->add('GET',  '/programmes/detail',        'ProgrammeController',         'detail',             null);
        $this->add('POST', '/programme/choisir',        'CommandeController',          'choisir',            'utilisateur');
        $this->add('GET',  '/galerie',                  'GalerieController',           'index',              null);
        $this->add('GET',  '/contact',                  'ContactController',           'index',              null);
        $this->add('POST', '/contact',                  'ContactController',           'store',              null);
        $this->add('GET',  '/cgv',                      'PageController',              'cgv',                null);
        $this->add('GET',  '/mentions-legales',         'PageController',              'mentions',           null);
        $this->add('GET',  '/partenaire',               'PageController',              'partenaire',         null);

        // Auth

        $this->add('GET',  '/inscription',              'AuthController',              'registerForm',       null);
        $this->add('POST', '/inscription',              'AuthController',              'register',           null);
        $this->add('GET',  '/connexion',                'AuthController',              'loginForm',          null);
        $this->add('POST', '/connexion',                'AuthController',              'login',              null);
        $this->add('GET',  '/deconnexion',              'AuthController',              'logout',             null);
        $this->add('GET',  '/mot-de-passe-oublie',      'AuthController',              'showForgotForm',     null);
        $this->add('POST', '/mot-de-passe-oublie',      'AuthController',              'forgot',             null);
        $this->add('GET',  '/reinitialiser-mdp',        'AuthController',              'showResetForm',      null);
        $this->add('POST', '/reinitialiser-mdp',        'AuthController',              'reset',              null);
        $this->add('POST', '/auth/check-email',         'AuthController',              'checkEmail',         null); // AJAX

        // Utilisateur

        $this->add('GET',  '/mon-espace',               'ProfilController',            'showProfil',         'utilisateur');
        $this->add('GET',  '/mon-programme',            'ProfilController',            'monProgramme',       'utilisateur');
        $this->add('GET',  '/mon-plan-nutritionnel',    'ProfilController',            'monPlanNutritionnel','utilisateur');
        $this->add('GET',  '/mon-profil',               'ProfilController',            'showProfil',         'utilisateur');
        $this->add('POST', '/mon-profil',               'ProfilController',            'updateProfil',       'utilisateur');
        $this->add('GET',  '/questionnaire',            'QuestionnaireController',     'show',               'utilisateur');
        $this->add('POST', '/questionnaire',            'QuestionnaireController',     'store',              'utilisateur');

        // Paiement Stripe

        $this->add('GET',  '/paiement',                 'PaiementController',          'showCheckout',       'utilisateur');
        $this->add('POST', '/paiement/initier',         'PaiementController',          'initier',            'utilisateur');
        $this->add('GET',  '/paiement/succes',          'PaiementController',          'succes',             'utilisateur');
        $this->add('GET',  '/paiement/annule',          'PaiementController',          'annule',             'utilisateur');
        $this->add('POST', '/webhook/stripe',           'PaiementController',          'webhook',            null); // Stripe webhook (pas d'auth session)

        // Admin

        $this->add('GET',  '/admin',                            'AdminController',     'dashboard',          'administrateur');
        $this->add('GET',  '/admin/clients',                    'AdminController',     'clients',            'administrateur');
        $this->add('GET',  '/admin/client/questionnaire',       'AdminController',     'voirQuestionnaire',  'administrateur');
        $this->add('POST', '/admin/client/supprimer',           'AdminController',     'supprimerClient',    'administrateur');
        $this->add('GET',  '/admin/programmes',                 'ProgrammeController', 'adminIndex',         'administrateur');
        $this->add('GET',  '/admin/programme/nouveau',          'ProgrammeController', 'showCreate',         'administrateur');
        $this->add('POST', '/admin/programme/nouveau',          'ProgrammeController', 'create',             'administrateur');
        $this->add('GET',  '/admin/programme/modifier',         'ProgrammeController', 'showEdit',           'administrateur');
        $this->add('POST', '/admin/programme/modifier',         'ProgrammeController', 'update',             'administrateur');
        $this->add('POST', '/admin/programme/supprimer',        'ProgrammeController', 'delete',             'administrateur');
        $this->add('GET',  '/admin/galerie',                    'GalerieController',   'adminIndex',         'administrateur');
        $this->add('POST', '/admin/galerie/photo/ajouter',      'GalerieController',   'addPhoto',           'administrateur');
        $this->add('POST', '/admin/galerie/photo/supprimer',    'GalerieController',   'deletePhoto',        'administrateur');
        $this->add('POST', '/admin/galerie/video/ajouter',      'GalerieController',   'addVideo',           'administrateur');
        $this->add('POST', '/admin/galerie/video/supprimer',    'GalerieController',   'deleteVideo',        'administrateur');
        $this->add('GET',  '/admin/plans-nutritionnels',        'PlanNutritionnelController', 'adminIndex',  'administrateur');
        $this->add('GET',  '/admin/plan/nouveau',               'PlanNutritionnelController', 'showCreate',  'administrateur');
        $this->add('POST', '/admin/plan/nouveau',               'PlanNutritionnelController', 'create',      'administrateur');
        $this->add('POST', '/admin/plan/assigner',              'PlanNutritionnelController', 'assigner',    'administrateur');
        $this->add('POST', '/admin/plan/marquer-envoye',        'PlanNutritionnelController', 'marquerEnvoye','administrateur');
        $this->add('POST', '/admin/plan/supprimer',             'PlanNutritionnelController', 'delete',      'administrateur');
        $this->add('GET',  '/admin/messages',                   'ContactController',   'adminIndex',         'administrateur');

        $this->add('POST', '/admin/message/supprimer',          'ContactController',   'delete',             'administrateur');
        $this->add('GET',  '/admin/statistiques',               'AdminController',     'statistiques',       'administrateur');
    }

    /* Ajoute route */

    private function add(
        string  $method,
        string  $path,
        string  $controller,
        string  $action,
        ?string $role
    ): void {
        $this->routes[] = compact('method', 'path', 'controller', 'action', 'role');
    }

    /* Dispatch contrôleur */

    public function dispatch(string $method, string $requestUri): void
    {
        $uri = parse_url($requestUri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {

                // Vérif role

                $this->checkAccess($route['role']);

                // Instance

                $controllerClass = 'Controller\\' . $route['controller'];
                $action          = $route['action'];

                if (!class_exists($controllerClass)) {
                    $this->abort(500, "Contrôleur introuvable : {$controllerClass}");
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    $this->abort(500, "Action introuvable : {$action}");
                    return;
                }

                $controller->$action();
                return;
            }
        }

        // Erreur 404

        $this->abort(404);
    }

    /* Vérif accès avec role */

    private function checkAccess(?string $requiredRole): void
    {
        if ($requiredRole === null) {
            return;
        }

        if (!Session::isLoggedIn()) {
            Session::setFlash('error', 'Vous devez être connecté pour accéder à cette page.');
            Session::set('redirect_after_login', $_SERVER['REQUEST_URI']);
            header('Location: /connexion');
            exit;
        }

        $userRole = Session::getUserRole();

        // Hiérarchie

        $hierarchy = ['utilisateur' => 1, 'administrateur' => 2];

        $userLevel     = $hierarchy[$userRole]     ?? 0;
        $requiredLevel = $hierarchy[$requiredRole] ?? 0;

        if ($userLevel < $requiredLevel) {
            $this->abort(403);
        }
    }

    /* Gestion erreurs */

    private function abort(int $code, string $message = ''): void
    {
        http_response_code($code);

        $messages = [
            403 => 'Accès refusé — vous n\'avez pas les droits nécessaires.',
            404 => 'Page introuvable.',
            500 => 'Erreur interne du serveur.',
        ];

        $display = $message ?: ($messages[$code] ?? 'Erreur inconnue.');

        // Erreur générique

        include TEMPLATES_PATH . '/errors/' . $code . '.php'
            ?: require_once TEMPLATES_PATH . '/errors/generic.php';
        exit;
    }
}
