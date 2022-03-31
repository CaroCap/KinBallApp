<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntraineurController extends AbstractController
{
    #[Route('/entraineur', name: 'app_entraineur')]
    public function index(): Response
    {
        return $this->render('entraineur/index.html.twig', [
            'controller_name' => 'EntraineurController',
        ]);
    }
}
