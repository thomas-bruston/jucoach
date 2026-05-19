<?php

declare(strict_types=1);

namespace Repository;

use Entity\Commande;
use PDOException;

class CommandeRepository extends AbstractRepository
{
    /**
     * Récupère toutes les commandes d'un utilisateur
     * @return Commande[]
     */
    public function findByUtilisateurId(int $utilisateurId): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT c.*, p.titre AS programme_titre, p.type AS programme_type
                 FROM commande c
                 INNER JOIN programme p ON c.programme_id = p.id
                 WHERE c.utilisateur_id = :id
                 ORDER BY c.date DESC'
            );
            $stmt->execute([':id' => $utilisateurId]);

            return array_map(fn($row) => Commande::fromArray($row), $stmt->fetchAll());

        } catch (PDOException $e) {
            error_log('[CommandeRepository::findByUtilisateurId] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la récupération des commandes.');
        }
    }

    /* Récupère une commande par ID */

    public function findById(int $id): ?Commande
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT c.*, p.titre AS programme_titre, p.type AS programme_type,
                        u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom,
                        u.email AS utilisateur_email
                 FROM commande c
                 INNER JOIN programme p ON c.programme_id = p.id
                 INNER JOIN utilisateur u ON c.utilisateur_id = u.id
                 WHERE c.id = :id
                 LIMIT 1'
            );
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch();

            return $data ? Commande::fromArray($data) : null;

        } catch (PDOException $e) {
            error_log('[CommandeRepository::findById] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la récupération de la commande.');
        }
    }

    /**
     * Récupère toutes les commandes (espace admin)
     * @return Commande[]
     */
    public function findAll(): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT c.*, p.titre AS programme_titre, p.type AS programme_type,
                        u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom,
                        u.email AS utilisateur_email
                 FROM commande c
                 INNER JOIN programme p ON c.programme_id = p.id
                 INNER JOIN utilisateur u ON c.utilisateur_id = u.id
                 ORDER BY c.date DESC'
            );
            $stmt->execute();

            return array_map(fn($row) => Commande::fromArray($row), $stmt->fetchAll());

        } catch (PDOException $e) {
            error_log('[CommandeRepository::findAll] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la récupération des commandes.');
        }
    }

    /* Crée une commande */

    public function create(Commande $commande): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO commande (utilisateur_id, programme_id, montant)
                 VALUES (:utilisateur_id, :programme_id, :montant)'
            );
            $stmt->execute([
                ':utilisateur_id' => $commande->getUtilisateurId(),
                ':programme_id'   => $commande->getProgrammeId(),
                ':montant'        => $commande->getMontant(),
            ]);

            return (int) $this->pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log('[CommandeRepository::create] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la création de la commande.');
        }
    }

    /* Vérifie si un utilisateur a déjà choisi ce programme */

    public function existsForUtilisateur(int $utilisateurId, int $programmeId): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT COUNT(*) FROM commande
                 WHERE utilisateur_id = :utilisateur_id
                 AND programme_id = :programme_id'
            );
            $stmt->execute([
                ':utilisateur_id' => $utilisateurId,
                ':programme_id'   => $programmeId,
            ]);

            return (int) $stmt->fetchColumn() > 0;

        } catch (PDOException $e) {
            error_log('[CommandeRepository::existsForUtilisateur] ' . $e->getMessage());
            return false;
        }
    }
}
