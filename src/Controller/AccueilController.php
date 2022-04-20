<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use App\Repository\SaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        // dd($this->getUser()->getInscriptions()[0]);
        return $this->render('accueil/accueil.html.twig');
    }


    // Profil Joueur
    #[Route('/joueur', name: 'app_joueur')]
    public function joueur(SaisonRepository $saisonRepository, InscriptionRepository $inscriptionRepository): Response
    {
        $lastSaison = $saisonRepository->findLast();
        $user = $this->getUser();

        // Afficher la page Joueur uniquement si connecté !!! -> getUser = true >< sinon redirect vers login
        if ($user) {
            // getInscription est ok juste il ne sait pas que c'est un user
            $inscriptions = $inscriptionRepository->findAllByUserOrder($user);
            $vars = ['lastSaison' => $lastSaison, 'inscriptions' => $inscriptions];
            return $this->render('accueil/joueur.html.twig', $vars);
        }
        
        return $this->redirectToRoute('app_login');
    }

     // ! TROUVER ID Profil Joueur
    //  #[Route('/joueur/{id?}', name: 'app_joueur', methods: ['GET'])]
    //  public function joueur(User $user): Response
    //  {
    //      // Afficher la page Joueur uniquement si connecté !!! -> getUser = true >< sinon redirect vers login
    //      if ($this->getUser()) {
    //          return $this->render('accueil/joueur.html.twig', [
    //              'user' => $user,
    //          ]);
    //      }

    //      return $this->redirectToRoute('app_login');
    //  }
}
