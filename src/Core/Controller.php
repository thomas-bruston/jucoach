<?php

declare(strict_types=1);

namespace Core;

abstract class Controller
{
    /* Rendu d'une vue dans le layout */

    protected function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $templatePath = TEMPLATES_PATH . '/' . $template . '.php';
        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template introuvable : {$templatePath}");
        }
        require_once $templatePath;
    }

    /* Redirection */

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /* Réponse JSON pour les requêtes AJAX */

    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* Vérifie le token CSRF */

    protected function verifyCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!Session::verifyCsrfToken($token)) {
            http_response_code(403);
            die('Token CSRF invalide. Veuillez recharger la page et réessayer.');
        }
    }

    protected function post(string $key, mixed $default = ''): mixed
    {
        return $_POST[$key] ?? $default;
    }

    protected function get(string $key, mixed $default = ''): mixed
    {
        return $_GET[$key] ?? $default;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
