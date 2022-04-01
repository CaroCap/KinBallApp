<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\UserRepository;
use App\Repository\SeanceRepository;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry; //LEQUEL EST LE BON ? Celui ci vient de UserController

#[Route('/participation')]
class ParticipationController extends AbstractController
{

    // ! Probe afficher participation User déjà inscrit
    // SELECT ALL BY USER
    #[Route('/joueur', name: 'app_participations_joueur', methods: ['GET'])]
    public function participationsJoueur(UserRepository $userRepository, ParticipationRepository $participationRepository): Response
    {
        // getParticipations est souligné car il ne comprend pas que $this->getUser est un User qui possède cette méthode
        $participations = $this->getUser()->getParticipations();

        $vars = ['participations' => $participations];

        return $this->render('participation/joueur.html.twig', $vars);
    }

    // SELECT ALL BY USER + Edit participation
    // #[Route('/joueur', name: 'app_participations_joueur', methods: ['GET'])]
    // public function participationsJoueur(Request $request, ParticipationRepository $participationRepository): Response
    // {
    //     // getParticipations est souligné car il ne comprend pas que $this->getUser est un User qui possède cette méthode
    //     $participations = $this->getUser()->getParticipations();
    //     $vars = ['participations' => $participations];

    //     $form = $this->createForm(ParticipationType::class, $vars);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         foreach ($participations as $participation) {
    //             $participationRepository->add($participation);
    //         }
    //         return $this->redirectToRoute('app_participations_joueur', [], Response::HTTP_SEE_OTHER);
    //     }
    //     return $this->render('participation/joueur.html.twig', $vars);
    // }

    // CREATE
    #[Route('/new', name: 'app_participation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParticipationRepository $participationRepository): Response
    {
        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participationRepository->add($participation);
            return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation/new.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    // SELECT ALL
    #[Route('/', name: 'app_participation_index', methods: ['GET'])]
    public function index(ParticipationRepository $participationRepository): Response
    {
        return $this->render('participation/index.html.twig', [
            'participations' => $participationRepository->findAll(),
        ]);
    }

    // SELECT BY ID
    #[Route('/{id}', name: 'app_participation_show', methods: ['GET'])]
    public function show(Participation $participation): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }

    // UPDATE
    #[Route('/{id}/edit', name: 'app_participation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participation $participation, ParticipationRepository $participationRepository): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participationRepository->add($participation);
            return $this->redirectToRoute('app_participations_joueur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation/edit.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    // DELETE
    #[Route('/{id}', name: 'app_participation_delete', methods: ['POST'])]
    public function delete(Request $request, Participation $participation, ParticipationRepository $participationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $participationRepository->remove($participation);
        }

        return $this->redirectToRoute('app_participation_index', [], Response::HTTP_SEE_OTHER);
    }
}
