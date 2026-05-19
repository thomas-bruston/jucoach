<?php

declare(strict_types=1);

namespace Repository;

use Entity\GaleriePhoto;
use Entity\GalerieVideo;

class GalerieRepository extends AbstractRepository
{
    // -------------------------
    // PHOTOS
    // -------------------------

    /** @return GaleriePhoto[] */
    public function findAllPhotos(): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM galerie_photo ORDER BY ordre ASC, date_ajout DESC'
            );
            $stmt->execute();
            return array_map(fn($row) => GaleriePhoto::fromArray($row), $stmt->fetchAll());

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la récupération des photos : ' . $e->getMessage());
        }
    }

    public function findPhotoById(int $id): ?GaleriePhoto
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM galerie_photo WHERE id = :id LIMIT 1');
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch();
            return $row ? GaleriePhoto::fromArray($row) : null;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la récupération de la photo : ' . $e->getMessage());
        }
    }

    public function createPhoto(GaleriePhoto $photo): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO galerie_photo (fichier, legende, ordre)
                 VALUES (:fichier, :legende, :ordre)'
            );
            $stmt->execute([
                ':fichier'  => $photo->getFichier(),
                ':legende'  => $photo->getLegende(),
                ':ordre'    => $photo->getOrdre(),
            ]);
            return (int) $this->pdo->lastInsertId();

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de l\'ajout de la photo : ' . $e->getMessage());
        }
    }

    public function deletePhoto(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM galerie_photo WHERE id = :id');
            return $stmt->execute([':id' => $id]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la suppression de la photo : ' . $e->getMessage());
        }
    }

    // -------------------------
    // VIDÉOS
    // -------------------------

    /** @return GalerieVideo[] */
    public function findAllVideos(): array
    {
        try {
            $stmt = $this->pdo->prepare(
                'SELECT * FROM galerie_video ORDER BY ordre ASC, date_ajout DESC'
            );
            $stmt->execute();
            return array_map(fn($row) => GalerieVideo::fromArray($row), $stmt->fetchAll());

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la récupération des vidéos : ' . $e->getMessage());
        }
    }

    public function findVideoById(int $id): ?GalerieVideo
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM galerie_video WHERE id = :id LIMIT 1');
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch();
            return $row ? GalerieVideo::fromArray($row) : null;

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la récupération de la vidéo : ' . $e->getMessage());
        }
    }

    public function createVideo(GalerieVideo $video): int
    {
        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO galerie_video (url_youtube, titre, description, ordre)
                 VALUES (:url_youtube, :titre, :description, :ordre)'
            );
            $stmt->execute([
                ':url_youtube' => $video->getUrlYoutube(),
                ':titre'       => $video->getTitre(),
                ':description' => $video->getDescription(),
                ':ordre'       => $video->getOrdre(),
            ]);
            return (int) $this->pdo->lastInsertId();

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de l\'ajout de la vidéo : ' . $e->getMessage());
        }
    }

    public function deleteVideo(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM galerie_video WHERE id = :id');
            return $stmt->execute([':id' => $id]);

        } catch (\PDOException $e) {
            throw new \RuntimeException('Erreur lors de la suppression de la vidéo : ' . $e->getMessage());
        }
    }
}
