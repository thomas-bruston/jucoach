<?php

declare(strict_types=1);

namespace Repository;

use Entity\Contact;
use PDOException;

class ContactRepository extends AbstractRepository
{
    /**
     * Récupère tous les messages de contact
     * @return Contact[]
     */
    public function findAll(): array
    {
        try {
            $stmt = $this->pdo->query(
                'SELECT * FROM contact ORDER BY date_envoi DESC'
            );
            $rows = $stmt->fetchAll();

            return array_map(fn($row) => Contact::fromArray($row), $rows);

        } catch (PDOException $e) {
            error_log('[ContactRepository::findAll] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la récupération des messages.');
        }
    }

    /* Crée un message de contact */

    public function create(Contact $contact): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO contact (nom, email, message)
                 VALUES (:nom, :email, :message)'
            );
            $stmt->execute([
                ':nom'     => $contact->getNom(),
                ':email'   => $contact->getEmail(),
                ':message' => $contact->getMessage(),
            ]);

            return (int) $this->pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log('[ContactRepository::create] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la sauvegarde du message.');
        }
    }

    /* Marque un message comme lu */

    public function marquerLu(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE contact SET lu = 1 WHERE id = :id'
            );

            return $stmt->execute([':id' => $id]);

        } catch (PDOException $e) {
            error_log('[ContactRepository::marquerLu] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la mise à jour du message.');
        }
    }

    /* Supprime un message */

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'DELETE FROM contact WHERE id = :id'
            );

            return $stmt->execute([':id' => $id]);

        } catch (PDOException $e) {
            error_log('[ContactRepository::delete] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la suppression du message.');
        }
    }
}
