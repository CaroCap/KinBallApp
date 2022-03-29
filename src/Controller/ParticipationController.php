<?php

namespace App\Controller;

use App\Entity\ParticipationEntrainement;
use App\Form\ParticipationEntrainementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeanceRepository;
use App\Repository\ParticipationEntrainementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/participation')]
class ParticipationController extends AbstractController
{
    // SELECT ALL
    #[Route('/', name: 'app_participation_index', methods: ['GET'])]
    public function index(ParticipationEntrainementRepository $participationEntrainementRepository): Response
    {
        return $this->render('participation/index.html.twig', [
            'participation_entrainements' => $participationEntrainementRepository->findAll(),
        ]);
    }

    // SELECT ALL BY INSCRIPTION
    #[Route('/joueur', name: 'app_participations_joueur', methods: ['GET'])]
    public function participationsJoueur(ParticipationEntrainementRepository $participationEntrainementRepository): Response
    {
        return $this->render('participation/index.html.twig', [
            'participation_entrainements' => $participationEntrainementRepository->findAll(),
        ]);
    }

    // CREATE
    #[Route('/new', name: 'app_participation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParticipationEntrainementRepository $participationEntrainementRepository): Response
    {
        $participationEntrainement = new ParticipationEntrainement();
        $form = $this->createForm(ParticipationEntrainementType::class, $participationEntrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participationEntrainementRepository->add($participationEntrainement);
            return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation/new.html.twig', [
            'participation_entrainement' => $participationEntrainement,
            'form' => $form,
        ]);
    }

    // SELECT BY ID
    #[Route('/{id}', name: 'app_participation_show', methods: ['GET'])]
    public function show(ParticipationEntrainement $participationEntrainement): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation_entrainement' => $participationEntrainement,
        ]);
    }

    // UPDATE
    #[Route('/{id}/edit', name: 'app_participation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ParticipationEntrainement $participationEntrainement, ParticipationEntrainementRepository $participationEntrainementRepository): Response
    {
        $form = $this->createForm(ParticipationEntrainementType::class, $participationEntrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participationEntrainementRepository->add($participationEntrainement);
            return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation/edit.html.twig', [
            'participation_entrainement' => $participationEntrainement,
            'form' => $form,
        ]);
    }

    // DELETE
    #[Route('/{id}', name: 'app_participation_delete', methods: ['POST'])]
    public function delete(Request $request, ParticipationEntrainement $participationEntrainement, ParticipationEntrainementRepository $participationEntrainementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participationEntrainement->getId(), $request->request->get('_token'))) {
            $participationEntrainementRepository->remove($participationEntrainement);
        }

        return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
    }
}
