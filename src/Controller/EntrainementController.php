<?php

namespace App\Controller;

use App\Entity\SeanceEntrainement;
use App\Form\SeanceEntrainementType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeanceEntrainementRepository;
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
    public function index(SeanceEntrainementRepository $seanceEntrainementRepository, SerializerInterface $serializer): Response
    {
        $evenements = $seanceEntrainementRepository->findAll();

        $evenementsJSON = $serializer->serialize($evenements, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['adresse', 'participationEntrainements']]);
        $vars = ['evenementsJSON' => $evenementsJSON];

        // return $this->render('entrainement/index.html.twig', [
        //     'seance_entrainements' => $seanceEntrainementRepository->findAll(),
        // ]);
        return $this->render('entrainement/calendrier.html.twig', $vars);
    }

// SELECT BY ID
    #[Route('/{id}', name: 'app_entrainement_show', methods: ['GET'])]
    public function show(SeanceEntrainement $seanceEntrainement): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'seance_entrainement' => $seanceEntrainement,
        ]);
    }

// CREATE
    #[Route('/new', name: 'app_entrainement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SeanceEntrainementRepository $seanceEntrainementRepository): Response
    {
        $seanceEntrainement = new SeanceEntrainement();
        $form = $this->createForm(SeanceEntrainementType::class, $seanceEntrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceEntrainementRepository->add($seanceEntrainement);
            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrainement/new.html.twig', [
            'seance_entrainement' => $seanceEntrainement,
            'form' => $form,
        ]);
    }

//EDIT
    #[Route('/{id}/edit', name: 'app_entrainement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SeanceEntrainement $seanceEntrainement, SeanceEntrainementRepository $seanceEntrainementRepository): Response
    {
        $form = $this->createForm(SeanceEntrainementType::class, $seanceEntrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceEntrainementRepository->add($seanceEntrainement);
            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrainement/edit.html.twig', [
            'seance_entrainement' => $seanceEntrainement,
            'form' => $form,
        ]);
    }

// DELETE
    #[Route('/{id}', name: 'app_entrainement_delete', methods: ['POST'])]
    public function delete(Request $request, SeanceEntrainement $seanceEntrainement, SeanceEntrainementRepository $seanceEntrainementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seanceEntrainement->getId(), $request->request->get('_token'))) {
            $seanceEntrainementRepository->remove($seanceEntrainement);
        }

        return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
    }
}
