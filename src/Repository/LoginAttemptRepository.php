<?php

declare(strict_types=1);

namespace Repository;

class LoginAttemptRepository extends AbstractRepository
{
    /* Nombre de tentatives échouées pour un email depuis N minutes */

    public function countRecent(string $email, int $minutes): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT COUNT(*) FROM login_attempt
                 WHERE email = :email
                   AND created_at >= (NOW() - INTERVAL :minutes MINUTE)'
            );
            $stmt->execute([':email' => $email, ':minutes' => $minutes]);

            return (int) $stmt->fetchColumn();

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors du comptage des tentatives de connexion : ' . $e->getMessage());
        }
    }

    /* Enregistre une tentative échouée */

    public function record(string $email): void
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO login_attempt (email) VALUES (:email)'
            );
            $stmt->execute([':email' => $email]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de l\'enregistrement de la tentative de connexion : ' . $e->getMessage());
        }
    }

    /* Efface les tentatives d'un email (connexion réussie) */

    public function clear(string $email): void
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM login_attempt WHERE email = :email');
            $stmt->execute([':email' => $email]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors du nettoyage des tentatives de connexion : ' . $e->getMessage());
        }
    }
}
