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
        return $this->render('accueil/accueil.html.twig');
    }

    #[Route('/joueur', name: 'app_joueur')]
    public function joueur(): Response
    {
        return $this->render('accueil/joueur.html.twig');
    }
}
