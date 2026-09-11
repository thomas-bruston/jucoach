<?php


/** Point d'entrée */

declare(strict_types=1);

// Définir les chemins racine du projet
define('ROOT_PATH',      dirname(__DIR__));
define('PUBLIC_PATH',    __DIR__);
define('SRC_PATH',       ROOT_PATH . '/src');
define('TEMPLATES_PATH', ROOT_PATH . '/templates');

// Charge l'autoloader Composer
require_once ROOT_PATH . '/vendor/autoload.php';

// Charge les variables d'environnement
require_once SRC_PATH . '/Core/Env.php';
\Core\Env::load(ROOT_PATH . '/.env');

// Affichage des erreurs : uniquement en développement (jamais aux visiteurs en prod)
error_reporting(E_ALL);
if (\Core\Env::get('APP_ENV', 'development') === 'production') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    ini_set('display_errors', '1');
}

// Nonce CSP unique par requête, utilisé pour les <script> inline
define('CSP_NONCE', base64_encode(random_bytes(16)));
header(
    "Content-Security-Policy: default-src 'self'; " .
    "script-src 'self' 'nonce-" . CSP_NONCE . "'; " .
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
    "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
    "img-src 'self' data:; " .
    "connect-src 'self'; " .
    "frame-ancestors 'self'; " .
    "base-uri 'self'; " .
    "form-action 'self';"
);

// Démarre la session de manière sécurisée
require_once SRC_PATH . '/Core/Session.php';
\Core\Session::start();

// Lance le routeur
require_once SRC_PATH . '/Core/Router.php';
$router = new \Core\Router();
$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);
