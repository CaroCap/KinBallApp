<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // #[Route('/user/create', name: 'afficher_form_user')]
    // public function afficherFormUser(): Response
    // {
    //     // Créa du Form User
    //     $user = new User();
    //     $formulaireUser = $this->createForm(UserType::class, $user, ['method'=>'POST', 'action'=>$this->generateUrl('add_user')]);

    //     // on envoie un objet FormView à la vue pour qu'elle puisse 
    //     // faire le rendu, pas le formulaire en soi
    //     $vars = ['unFormulaireUser' => $formulaireUser->createView()];

    //     return $this->render('user/formUser.html.twig', $vars);
    // }

    // #[Route('/user/create', name: 'add_user')]
    // public function traitementFormUser(): Response
    // {
    //     // // Créa du Form User
    //     // $user = new User();
    //     // $formulaireUser = $this->createForm(UserType::class, $user, ['method'=>'POST', 'action'=>$this->generateUrl('add_user')]);

    //     // // on envoie un objet FormView à la vue pour qu'elle puisse 
    //     // // faire le rendu, pas le formulaire en soi
    //     // $vars = ['unFormulaireUser' => $formulaireUser->createView()];

    //     return $this->render('user/traitementUser.html.twig');
    // }
}
