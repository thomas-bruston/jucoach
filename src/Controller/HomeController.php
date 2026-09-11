<?php

declare(strict_types=1);

namespace Controller;

use Core\Controller;
use Repository\ProgrammeRepository;

/* HomeController */

class HomeController extends Controller
{
    private ProgrammeRepository $programmeRepository;

    public function __construct()
    {
        $this->programmeRepository = new ProgrammeRepository();
    }

    public function index(): void
    {
        $programmeMisEnAvant = $this->programmeRepository->findById(1);

        $this->render('home/index', [
            'programme' => $programmeMisEnAvant,
        ]);
    }
}
