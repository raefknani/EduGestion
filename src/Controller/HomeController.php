<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use App\Repository\AbsenceRepository;
use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        NoteRepository $noteRepository,
        AbsenceRepository $absenceRepository,
        SalleRepository $salleRepository
    ): Response {

        $totalNotes = $noteRepository->count([]);
        $totalAbsences = $absenceRepository->count([]);
        $totalSalles = $salleRepository->count([]);

        $sallesDisponibles = $salleRepository->count([
            'disponible' => true
        ]);

        return $this->render('home/index.html.twig', [
            'totalNotes' => $totalNotes,
            'totalAbsences' => $totalAbsences,
            'totalSalles' => $totalSalles,
            'sallesDisponibles' => $sallesDisponibles,
        ]);
    }
}