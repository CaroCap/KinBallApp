<?php

namespace App\Controller;

use DateTime;
use App\Entity\Seance;
use App\Form\SeanceType;
use App\Entity\Participation;
use App\Repository\SeanceRepository;
use App\Repository\InscriptionRepository;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/seance')]
class SeanceController extends AbstractController
{
    #[Route('/', name: 'app_seance_index', methods: ['GET'])]
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }

    #[Route('/new/{salle?}', name: 'app_seance_new', methods: ['GET', 'POST'])]
    public function new(ParticipationRepository $participationRepository, Request $request, SeanceRepository $seanceRepository, InscriptionRepository $inscriptionRepository): Response
    {
        // Créer une nouvelle séance avec des infos de bases
        $now = date("Y-m-d");
        $seance = new Seance([
            'start' => new DateTime($now.' 18:00:00'),
            'end' => new DateTime($now.' 20:00:00'),
        ]);

        if ($request->get('salle') === 'VUB') {
            $seance = new Seance([
                'title' => "Entrainement VUB",
                'description' => "Entrainement hebdomadaire toutes catégories",
                'start' => new DateTime($now.' 18:00:00'),
                'end' => new DateTime($now.' 20:00:00'),
                'numero' => '2',
                'rue' => 'Boulevard de la Plaine',
                'codePostal' => '1050',
                'ville' => 'Ixelles',
            ]);
        }
        elseif ($request->get('salle')==="ULB") {
            $seance = new Seance([
                'title' => "Entrainement ULB",
                'description' => "Entrainement hebdomadaire toutes catégories",
                'start' => new DateTime($now.' 18:00:00'),
                'end' => new DateTime($now.' 20:30:00'),
                'numero' => '87A',
                'rue' => 'Avenue Buyl',
                'codePostal' => '1050',
                'ville' => 'Ixelles',
            ]);
        }
        
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seanceRepository->add($seance);

            // Créer une participation pour chaque joueur déjà inscrit à la saison
            $inscriptionsSaison = $inscriptionRepository->findBy(['saison'=>$seance->getSaison()]);
            foreach ($inscriptionsSaison as $inscription) {
                $participation = new Participation([
                    'typePresence'=>'Indécis',
                    'seance'=> $seance,
                    'user' => $inscription->getPlayer()
                ]);
                $participationRepository->add($participation);
            }

            return $this->redirectToRoute('app_seance_new', ['salle'=>$request->get('salle'), 'seance' => $seance], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

    
    #[Route('/{id}', name: 'app_seance_show', methods: ['GET'])]
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seance_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_seance_delete', methods: ['POST'])]
    public function delete(Request $request, Seance $seance, SeanceRepository $seanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $seanceRepository->remove($seance);
        }

        return $this->redirectToRoute('app_seance_index', [], Response::HTTP_SEE_OTHER);
    }
}
