<?php

declare(strict_types=1);

namespace Repository;

use Entity\Programme;
use PDOException;

class ProgrammeRepository extends AbstractRepository
{
    /**
     * Récupère tous les programmes
     * @return Programme[]
     */
    public function findAll(): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM programme ORDER BY id ASC'
            );
            $stmt->execute();

            return array_map(fn($row) => Programme::fromArray($row), $stmt->fetchAll());

        } catch (PDOException $e) {
            error_log('[ProgrammeRepository::findAll] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la récupération des programmes.');
        }
    }

    /* Récupère un programme par ID */

    public function findById(int $id): ?Programme
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM programme WHERE id = :id LIMIT 1'
            );
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch();

            return $row ? Programme::fromArray($row) : null;

        } catch (PDOException $e) {
            error_log('[ProgrammeRepository::findById] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la récupération du programme.');
        }
    }

    /* Crée un programme */

    public function create(Programme $programme): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO programme (type, titre, description, objectifs, inclut, tarifs, prix)
                 VALUES (:type, :titre, :description, :objectifs, :inclut, :tarifs, :prix)'
            );
            $stmt->execute([
                ':type'        => $programme->getType(),
                ':titre'       => $programme->getTitre(),
                ':description' => $programme->getDescription(),
                ':objectifs'   => $programme->getObjectifs(),
                ':inclut'      => $programme->getInclut(),
                ':tarifs'      => $programme->getTarifs(),
                ':prix'        => $programme->getPrix(),
            ]);

            return (int) $this->pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log('[ProgrammeRepository::create] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la création du programme.');
        }
    }

    /* Met à jour un programme */

    public function update(Programme $programme): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE programme
                 SET type = :type, titre = :titre, description = :description,
                     objectifs = :objectifs, inclut = :inclut, tarifs = :tarifs,
                     prix = :prix
                 WHERE id = :id'
            );

            return $stmt->execute([
                ':type'        => $programme->getType(),
                ':titre'       => $programme->getTitre(),
                ':description' => $programme->getDescription(),
                ':objectifs'   => $programme->getObjectifs(),
                ':inclut'      => $programme->getInclut(),
                ':tarifs'      => $programme->getTarifs(),
                ':prix'        => $programme->getPrix(),
                ':id'          => $programme->getId(),
            ]);

        } catch (PDOException $e) {
            error_log('[ProgrammeRepository::update] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la mise à jour du programme.');
        }
    }

    /* Supprime un programme */

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'DELETE FROM programme WHERE id = :id'
            );

            return $stmt->execute([':id' => $id]);

        } catch (PDOException $e) {
            error_log('[ProgrammeRepository::delete] ' . $e->getMessage());
            throw new \RuntimeException('Erreur lors de la suppression du programme.');
        }
    }
}
