<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/absence')]
final class AbsenceController extends AbstractController
{
    

#[Route('/', name: 'app_absence_index', methods: ['GET'])]
public function index(
    Request $request,
    AbsenceRepository $absenceRepository
): Response {
    $search = trim($request->query->get('search', ''));
    $justifiee = $request->query->get('justifiee', '');
    $date = $request->query->get('date', '');

    $qb = $absenceRepository->createQueryBuilder('a');

    // Search by student name
    if ($search !== '') {
        $qb->andWhere('LOWER(a.nomEtudiant) LIKE LOWER(:search)')
           ->setParameter('search', '%' . $search . '%');
    }

    // Filter by justification
    if ($justifiee === '1' || $justifiee === '0') {
        $qb->andWhere('a.justifiee = :justifiee')
           ->setParameter('justifiee', $justifiee === '1');
    }

    // Filter by absence date
    if ($date !== '') {
        $dateObject = \DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $date
        );

        if ($dateObject && $dateObject->format('Y-m-d') === $date) {
            $qb->andWhere('a.dateAbsence = :date')
               ->setParameter('date', $dateObject, \Doctrine\DBAL\Types\Types::DATE_IMMUTABLE);
        }
    }

    $absences = $qb->getQuery()->getResult();

    return $this->render('absence/index.html.twig', [
        'absences' => $absences,
        'search' => $search,
        'justifiee' => $justifiee,
        'date' => $date,
    ]);
}


    #[Route('/new', name: 'app_absence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $absence = new Absence();
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($absence);
            $entityManager->flush();
            $this->addFlash(
    'success',
    "L'absence a été ajoutée avec succès !"
);

            return $this->redirectToRoute('app_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absence/new.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_show', methods: ['GET'])]
    public function show(Absence $absence): Response
    {
        return $this->render('absence/show.html.twig', [
            'absence' => $absence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_absence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Absence $absence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbsenceType::class, $absence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
    'success',
    "L'absence a été modifiée avec succès !"
);

            return $this->redirectToRoute('app_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('absence/edit.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_absence_delete', methods: ['POST'])]
    public function delete(Request $request, Absence $absence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($absence);
            $entityManager->flush();
            $this->addFlash(
    'success',
    "L'absence a été supprimée avec succès !"
);
        }

        return $this->redirectToRoute('app_absence_index', [], Response::HTTP_SEE_OTHER);
    }
}