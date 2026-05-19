<?php

declare(strict_types=1);

namespace Repository;

use Entity\User;

class UserRepository extends AbstractRepository
{

    public function findByEmail(string $email): ?User
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT u.*, r.libelle AS role
                 FROM utilisateur u
                 JOIN role r ON u.role_id = r.id
                 WHERE u.email = :email
                 LIMIT 1'
            );
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch();

            return $row ? $this->hydrate($row) : null;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la recherche par email : ' . $e->getMessage());
        }
    }

    public function findById(int $id): ?User
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT u.*, r.libelle AS role
                 FROM utilisateur u
                 JOIN role r ON u.role_id = r.id
                 WHERE u.id = :id
                 LIMIT 1'
            );
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch();

            return $row ? $this->hydrate($row) : null;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la recherche par ID : ' . $e->getMessage());
        }
    }

    public function create(User $user): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO utilisateur (email, password, prenom, nom, telephone, adresse, statut, role_id)
                 VALUES (:email, :password, :prenom, :nom, :telephone, :adresse, :statut, :role_id)'
            );
            $stmt->execute([
                ':email'     => $user->getEmail(),
                ':password'  => $user->getPassword(),
                ':prenom'    => $user->getPrenom(),
                ':nom'       => $user->getNom(),
                ':telephone' => $user->getTelephone(),
                ':adresse'   => $user->getAdresse(),
                ':statut'    => $user->getStatut(),
                ':role_id'   => $user->getRoleId(),
            ]);

            return (int) $this->pdo->lastInsertId();

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la création de l\'utilisateur : ' . $e->getMessage());
        }
    }

    public function update(User $user): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE utilisateur
                 SET email     = :email,
                     prenom    = :prenom,
                     nom       = :nom,
                     telephone = :telephone,
                     adresse   = :adresse
                 WHERE id = :id'
            );

            return $stmt->execute([
                ':email'     => $user->getEmail(),
                ':prenom'    => $user->getPrenom(),
                ':nom'       => $user->getNom(),
                ':telephone' => $user->getTelephone(),
                ':adresse'   => $user->getAdresse(),
                ':id'        => $user->getId(),
            ]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la mise à jour de l\'utilisateur : ' . $e->getMessage());
        }
    }

    public function updatePassword(int $userId, string $hashedPassword): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE utilisateur SET password = :password WHERE id = :id'
            );

            return $stmt->execute([
                ':password' => $hashedPassword,
                ':id'       => $userId,
            ]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la mise à jour du mot de passe : ' . $e->getMessage());
        }
    }

    public function delete(int $userId): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'DELETE FROM utilisateur WHERE id = :id'
            );

            return $stmt->execute([':id' => $userId]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage());
        }
    }

    public function emailExists(string $email, ?int $excludeUserId = null): bool
    {
        try {
            if ($excludeUserId !== null) {
                $stmt = $this->pdo->prepare(
                    'SELECT COUNT(*) FROM utilisateur WHERE email = :email AND id != :id'
                );
                $stmt->execute([':email' => $email, ':id' => $excludeUserId]);
            } else {
                $stmt = $this->pdo->prepare(
                    'SELECT COUNT(*) FROM utilisateur WHERE email = :email'
                );
                $stmt->execute([':email' => $email]);
            }

            return (int) $stmt->fetchColumn() > 0;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la vérification de l\'email : ' . $e->getMessage());
        }
    }

    public function savePasswordResetToken(int $userId, string $token, string $expireAt): bool
    {
        try {
            // Supprime les anciens tokens de cet utilisateur
            $stmt = $this->pdo->prepare(
                'DELETE FROM password_reset WHERE utilisateur_id = :id'
            );
            $stmt->execute([':id' => $userId]);

            $stmt = $this->pdo->prepare(
                'INSERT INTO password_reset (utilisateur_id, token, expire_at)
                 VALUES (:id, :token, :expire_at)'
            );

            return $stmt->execute([
                ':id'        => $userId,
                ':token'     => $token,
                ':expire_at' => $expireAt,
            ]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la sauvegarde du token : ' . $e->getMessage());
        }
    }

    public function findByResetToken(string $token): ?array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT pr.*, u.email
                 FROM password_reset pr
                 JOIN utilisateur u ON pr.utilisateur_id = u.id
                 WHERE pr.token = :token
                   AND pr.utilise = 0
                   AND pr.expire_at > NOW()
                 LIMIT 1'
            );
            $stmt->execute([':token' => $token]);

            return $stmt->fetch() ?: null;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la recherche du token : ' . $e->getMessage());
        }
    }

    public function markResetTokenAsUsed(string $token): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                'UPDATE password_reset SET utilise = 1 WHERE token = :token'
            );

            return $stmt->execute([':token' => $token]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la mise à jour du token : ' . $e->getMessage());
        }
    }

    /**
     * Récupère tous les clients (role utilisateur)
     * @return User[]
     */
    public function findAllClients(): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT u.*, r.libelle AS role
                 FROM utilisateur u
                 JOIN role r ON u.role_id = r.id
                 WHERE r.libelle = :role
                 ORDER BY u.created_at DESC'
            );
            $stmt->execute([':role' => 'utilisateur']);
            $rows = $stmt->fetchAll();

            return array_map(fn($row) => $this->hydrate($row), $rows);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la récupération des clients : ' . $e->getMessage());
        }
    }

    // Hydratation

    private function hydrate(array $row): User
    {
        return new User(
            email:     $row['email'],
            password:  $row['password'],
            prenom:    $row['prenom'],
            nom:       $row['nom'],
            telephone: $row['telephone'] ?? null,
            adresse:   $row['adresse']   ?? null,
            statut:    $row['statut'],
            role:      $row['role'],
            roleId:    (int) $row['role_id'],
            id:        (int) $row['id'],
            createdAt: $row['created_at'] ?? null,
        );
    }
}
