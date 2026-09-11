<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Core\Session;
use Entity\Programme;
use Repository\ProgrammeRepository;

/* ProgrammeController */

class ProgrammeController extends Controller
{
    private ProgrammeRepository $programmeRepository;

    public function __construct()
    {
        $this->programmeRepository = new ProgrammeRepository();
    }

    /* Liste des programmes — cards */

    public function index(): void
    {
        $programmes = $this->programmeRepository->findAll();

        $this->render('programmes/index', [
            'programmes' => $programmes,
        ]);
    }

    /* Détail d'un programme */

    public function detail(): void
    {
        $id = (int) $this->get('id');

        if ($id <= 0) {
            $this->redirect('/programmes');
        }

        $programme = $this->programmeRepository->findById($id);

        if ($programme === null) {
            $this->redirect('/programmes');
        }

        $this->render('programmes/detail', [
            'programme' => $programme,
        ]);
    }

    //
    // Espace admin — CRUD
    //

    public function adminIndex(): void
    {
        $programmes = $this->programmeRepository->findAll();

        $this->render('admin/programmes/index', [
            'programmes' => $programmes,
        ]);
    }

    public function showCreate(): void
    {
        $this->render('admin/programmes/create', [
            'csrf_token' => Session::generateCsrfToken(),
            'error'      => Session::getFlash('error'),
        ]);
    }

    public function create(): void
    {
        $this->verifyCsrf();

        try {
            $programme = new Programme();
            $programme->setType($this->post('type'));
            $programme->setTitre($this->post('titre'));
            $programme->setDescription($this->post('description'));
            $programme->setObjectifs(trim($this->post('objectifs')) ?: null);
            $programme->setInclut(trim($this->post('inclut')) ?: null);
            $programme->setTarifs(trim($this->post('tarifs')) ?: null);
            $programme->setPrix((float) $this->post('prix'));

            $this->programmeRepository->create($programme);

            Session::setFlash('success', 'Programme créé avec succès !');
            $this->redirect('/admin/programmes');

        } catch (\InvalidArgumentException $e) {
            Session::setFlash('error', $e->getMessage());
            $this->redirect('/admin/programme/nouveau');
        }
    }

    public function showEdit(): void
    {
        $id        = (int) $this->get('id');
        $programme = $this->programmeRepository->findById($id);

        if ($programme === null) {
            $this->redirect('/admin/programmes');
        }

        $this->render('admin/programmes/edit', [
            'csrf_token'  => Session::generateCsrfToken(),
            'programme'   => $programme,
            'error'       => Session::getFlash('error'),
        ]);
    }

    public function update(): void
    {
        $this->verifyCsrf();

        $id        = (int) $this->post('programme_id');
        $programme = $this->programmeRepository->findById($id);

        if ($programme === null) {
            $this->redirect('/admin/programmes');
        }

        try {
            $programme->setType($this->post('type'));
            $programme->setTitre($this->post('titre'));
            $programme->setDescription($this->post('description'));
            $programme->setObjectifs(trim($this->post('objectifs')) ?: null);
            $programme->setInclut(trim($this->post('inclut')) ?: null);
            $programme->setTarifs(trim($this->post('tarifs')) ?: null);
            $programme->setPrix((float) $this->post('prix'));

            $this->programmeRepository->update($programme);

            Session::setFlash('success', 'Programme mis à jour avec succès.');
            $this->redirect('/admin/programmes');

        } catch (\InvalidArgumentException $e) {
            Session::setFlash('error', $e->getMessage());
            $this->redirect('/admin/programme/modifier?id=' . $id);
        }
    }

    public function delete(): void
    {
        $this->verifyCsrf();

        $id = (int) $this->post('programme_id');
        $this->programmeRepository->delete($id);

        Session::setFlash('success', 'Programme supprimé.');
        $this->redirect('/admin/programmes');
    }
}
