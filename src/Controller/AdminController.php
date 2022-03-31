<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\SaisonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/{id?}', name: 'app_admin')]
    public function index(Request $objetRequest, SaisonRepository $saisonRepository, UserRepository $userRepository): Response
    {
        // Création d'une entité Saison
        $idSaison = $objetRequest->get('id');
        // les 5 dernières Saison triées par ordre décroissant
        $saisons = $saisonRepository->findBy(array(), array('fin' => 'ASC'), 5);
        
        if ($idSaison === null) {
            $users = $userRepository->findBy(array(), array('nom' => 'ASC'));
            $vars = ['saisons' => $saisons, 'users' => $users];
            return $this->render('admin/admin.html.twig', $vars);
        }
        
        $users = $userRepository->findBy(['id'=>$idSaison], array('nom' => 'ASC'));
        $vars = ['saisons' => $saisons, 'users' => $users];
        return $this->render('admin/admin.html.twig', $vars);
    }

    // ! Listing de tous les Users Editables ! WEBDEV -> Gestion Roles
    
    //  ! Création Saison
    #[Route('/saison', name: 'app_saison')]
    public function saison(): Response
    {
        return $this->render('admin/newSaison.html.twig');
    }
    
    // //  ! Création Séances
    // #[Route('/seance', name: 'app_seance')]
    // public function seance(): Response
    // {
    //     return $this->render('admin/seance.html.twig', [
    //         'controller_name' => 'AdminController',
    //     ]);
    // }
}
