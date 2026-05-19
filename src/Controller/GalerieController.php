<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Entity\GaleriePhoto;
use Entity\GalerieVideo;
use Repository\GalerieRepository;

/* GalerieController */

class GalerieController extends Controller
{
    private GalerieRepository $galerieRepository;

    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_SIZE           = 5 * 1024 * 1024; // 5 Mo
    private const UPLOAD_DIR         = __DIR__ . '/../../public/images/galerie/';

    public function __construct()
    {
        $this->galerieRepository = new GalerieRepository();
    }

    /* Vue visiteur */

    public function index(): void
    {
        $this->render('galerie/index', [
            'photos' => $this->galerieRepository->findAllPhotos(),
            'videos' => $this->galerieRepository->findAllVideos(),
        ]);
    }

    /* Vue admin */

    public function adminIndex(): void
    {
        $this->render('admin/galerie/index', [
            'photos'     => $this->galerieRepository->findAllPhotos(),
            'videos'     => $this->galerieRepository->findAllVideos(),
            'csrf_token' => Session::generateCsrfToken(),
            'success'    => Session::getFlash('success'),
            'errors'     => Session::getFlash('errors') ?? [],
        ]);
    }

    /* Ajoute une photo */

    public function addPhoto(): void
    {
        $this->verifyCsrf();

        $legende = trim($this->post('legende')) ?: null;
        $ordre   = (int) $this->post('ordre', 0);

        $fichier = $this->processUpload();

        if (is_array($fichier)) {
            Session::setFlash('errors', $fichier);
            $this->redirect('/admin/galerie');
        }

        try {
            $photo = new GaleriePhoto($fichier, $legende, $ordre);
            $this->galerieRepository->createPhoto($photo);
            Session::setFlash('success', 'Photo ajoutée.');
        } catch (\RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
        }

        $this->redirect('/admin/galerie');
    }

    /* Supprime une photo */

    public function deletePhoto(): void
    {
        $this->verifyCsrf();

        $id    = (int) $this->post('photo_id');
        $photo = $this->galerieRepository->findPhotoById($id);

        try {
            $this->galerieRepository->deletePhoto($id);
            if ($photo) {
                $this->deleteFile($photo->getFichier());
            }
            Session::setFlash('success', 'Photo supprimée.');
        } catch (\RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
        }

        $this->redirect('/admin/galerie');
    }

    /* Ajoute une vidéo YouTube */

    public function addVideo(): void
    {
        $this->verifyCsrf();

        $url         = trim($this->post('url_youtube'));
        $titre       = trim($this->post('titre'));
        $description = trim($this->post('description')) ?: null;
        $ordre       = (int) $this->post('ordre', 0);

        try {
            $video = new GalerieVideo();
            $video->setUrlYoutube($url);
            $video->setTitre($titre);
            $video->setDescription($description);
            $video->setOrdre($ordre);

            $this->galerieRepository->createVideo($video);
            Session::setFlash('success', 'Vidéo ajoutée.');
        } catch (\InvalidArgumentException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
        }

        $this->redirect('/admin/galerie');
    }

    /* Supprime une vidéo */

    public function deleteVideo(): void
    {
        $this->verifyCsrf();

        $id = (int) $this->post('video_id');

        try {
            $this->galerieRepository->deleteVideo($id);
            Session::setFlash('success', 'Vidéo supprimée.');
        } catch (\RuntimeException $e) {
            Session::setFlash('errors', [$e->getMessage()]);
        }

        $this->redirect('/admin/galerie');
    }

    /* Traitement de l'upload photo */

    private function processUpload(): string|array
    {
        if (empty($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['Aucune photo sélectionnée.'];
        }

        if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            return ['Erreur lors de l\'upload de la photo.'];
        }

        if ($_FILES['photo']['size'] > self::MAX_SIZE) {
            return ['La photo ne doit pas dépasser 5 Mo.'];
        }

        $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            return ['Format non autorisé. Utilisez JPEG, PNG ou WebP.'];
        }

        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0755, true);
        }

        $filename    = uniqid('galerie_', true) . '.' . $extension;
        $destination = self::UPLOAD_DIR . $filename;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            return ['Impossible de sauvegarder la photo.'];
        }

        return $filename;
    }

    private function deleteFile(string $filename): void
    {
        $path = self::UPLOAD_DIR . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
