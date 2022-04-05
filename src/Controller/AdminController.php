<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\SaisonRepository;
use App\Repository\InscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(Request $objetRequest, SaisonRepository $saisonRepository, UserRepository $userRepository): Response
    {
        // Création d'une entité Saison pour les filtres
        // les 5 dernières Saison triées par ordre décroissant
        $saisons = $saisonRepository->findBy(array(), array('titre' => 'DESC'), 5);
        
        $users = $userRepository->findBy(array(), array('nom' => 'ASC'));
        $vars = ['saisons' => $saisons, 'users' => $users];
        return $this->render('admin/admin.html.twig', $vars);
    }

    #[Route('/{id}', name: 'liste_inscriptions_saison')]
    public function listeInscriptionsSaison(Request $objetRequest, SaisonRepository $saisonRepository): Response
    {
        // Création d'une entité Saison
        $idSaison = $objetRequest->get('id');
        // les 5 dernières Saison triées par ordre décroissant
        $saisons = $saisonRepository->findBy(array(), array('titre' => 'DESC'), 5);
        
        if ($idSaison === null) {
            return $this->render('admin/admin.html.twig');
        }
        
        // $users = $userRepository->findBy(['id'=>$idSaison], array('nom' => 'ASC'));
        // $inscriptions = $saisonRepository->findOneBy(['id'=>$idSaison])->getInscriptions();

        // Vérifier qu'il y ait des inscriptions dans la Saison pour pouvoir les afficher
        if ($saisonRepository->find($idSaison)->getInscriptions()) {
            $inscriptions = $saisonRepository->find($idSaison)->getInscriptions();
            $vars = ['saisons' => $saisons, 'inscriptions' => $inscriptions];
        }
        else{
            $vars = ['saisons' => $saisons];
        }
        return $this->render('admin/inscritsSaison.html.twig', $vars);
        
    }

    // ! Listing de tous les Users Editables ! WEBDEV -> Gestion Roles
    
    //  Création Saison -> app_saison_new dans SaisonController
    // #[Route('/saison', name: 'new_saison')]
    // public function saison(): Response
    // {
    //     return $this->render('saison/newSaison.html.twig');
    // }
    
    // //  ! Création Séances
    // #[Route('/seance', name: 'app_seance')]
    // public function seance(): Response
    // {
    //     return $this->render('admin/seance.html.twig', [
    //         'controller_name' => 'AdminController',
    //     ]);
    // }
}
