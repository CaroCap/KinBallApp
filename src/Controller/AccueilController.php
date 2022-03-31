<?php

namespace App\Controller;

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
    public function joueur(): Response
    {
        // Afficher la page Joueur uniquement si connecté !!! -> getUser = true >< sinon redirect vers login
        if ($this->getUser()) {
            return $this->render('accueil/joueur.html.twig');
        }
        
        return $this->redirectToRoute('app_login');
    }
}
