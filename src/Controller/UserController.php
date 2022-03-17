<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'liste_users')]
    public function ListeUsers(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(User::class);
        $users = $rep->findAll();
        $vars = ['users' => $users];

        return $this->render('user/listeUsers.html.twig', $vars);
    }

    #[Route('/user/dames', name: 'liste_dames')]
    public function ListeDames(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Categorie::class);
        $cat = $rep->findOneBy(['typeCategorie'=>'Dame']);
        $users = $cat->getUsers();
        // dd($users);
        $vars = ['users' => $users];
        return $this->render('user/listeUsers.html.twig', $vars);
    }

    #[Route('/user/hommes', name: 'liste_hommes')]
    public function ListeHommes(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Categorie::class);
        $cat = $rep->findOneBy(['typeCategorie'=>'Homme']);
        $users = $cat->getUsers();
        // dd($users);
        $vars = ['users' => $users];
        return $this->render('user/listeUsers.html.twig', $vars);
    }
    
    #[Route('/user/mixtes', name: 'liste_mixtes')]
    public function ListeMixtes(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Categorie::class);
        $cat = $rep->findOneBy(['typeCategorie'=>'Mixte']);
        $users = $cat->getUsers();
        // dd($users);
        $vars = ['users' => $users];
        return $this->render('user/listeUsers.html.twig', $vars);
    }
}
