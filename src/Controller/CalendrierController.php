<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeanceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// SELECT ALL
class CalendrierController extends AbstractController
{
//Calendrier de toutes les seances (entrainements+matchs)
    #[Route('/calendrier', name: 'app_seance_index', methods: ['GET'])]
    public function index(SeanceRepository $seanceRepository, SerializerInterface $serializer): Response
    {
        $evenements = $seanceRepository->findAll();

        $evenementsJSON = $serializer->serialize($evenements, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['categories', 'participations', 'saison']]);
        $vars = ['evenementsJSON' => $evenementsJSON];

        // return $this->render('seance/index.html.twig', [
        //     'seances' => $seanceRepository->findAll(),
        // ]);
        return $this->render('seance/calendrier.html.twig', $vars);
    }

// SELECT BY ID
    #[Route('/seance/{id}', name: 'app_seance_show', methods: ['GET'])]
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

// CREATE
// ! Prob avec create Seance
// ! Probe avec Edit User
    #[Route('/seance/new2', name: 'app_seance_new2')]
    public function newSeance(Request $request, SeanceRepository $seanceRepository): Response
    {
        dd('coucou seance');

        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceRepository->add($seance);
            return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/newSeance.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

//EDIT
    #[Route('/seance/{id}/edit', name: 'app_seance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Seance $seance, SeanceRepository $seanceRepository): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceRepository->add($seance);
            return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

// DELETE
    #[Route('/seance/{id}', name: 'app_seance_delete', methods: ['POST'])]
    public function delete(Request $request, Seance $seance, SeanceRepository $seanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $seanceRepository->remove($seance);
        }

        return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
    }
}
