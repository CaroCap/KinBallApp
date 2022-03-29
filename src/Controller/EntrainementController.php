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
#[Route('/entrainement')]
class EntrainementController extends AbstractController
{
//Calendrier de tous les entrainements
    #[Route('/', name: 'app_entrainement_index', methods: ['GET'])]
    public function index(SeanceRepository $seanceRepository, SerializerInterface $serializer): Response
    {
        $evenements = $seanceRepository->findAll();

        $evenementsJSON = $serializer->serialize($evenements, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['adresse', 'participationEntrainements']]);
        $vars = ['evenementsJSON' => $evenementsJSON];

        // return $this->render('entrainement/index.html.twig', [
        //     'seance_entrainements' => $seanceRepository->findAll(),
        // ]);
        return $this->render('entrainement/calendrier.html.twig', $vars);
    }

// SELECT BY ID
    #[Route('/{id}', name: 'app_entrainement_show', methods: ['GET'])]
    public function show(Seance $seance): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'seance_entrainement' => $seance,
        ]);
    }

// CREATE
    #[Route('/new', name: 'app_entrainement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SeanceRepository $seanceRepository): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceRepository->add($seance);
            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrainement/new.html.twig', [
            'seance_entrainement' => $seance,
            'form' => $form,
        ]);
    }

//EDIT
    #[Route('/{id}/edit', name: 'app_entrainement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Seance $seance, SeanceRepository $seanceRepository): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceRepository->add($seance);
            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrainement/edit.html.twig', [
            'seance_entrainement' => $seance,
            'form' => $form,
        ]);
    }

// DELETE
    #[Route('/{id}', name: 'app_entrainement_delete', methods: ['POST'])]
    public function delete(Request $request, Seance $seance, SeanceRepository $seanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $seanceRepository->remove($seance);
        }

        return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
    }
}
