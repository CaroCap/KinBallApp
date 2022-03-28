<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Categorie;
use App\Form\UserEditType;
use App\Entity\Inscription;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
//SELECT ALL USERS
    #[Route('/all', name: 'liste_users')]
    public function ListeUsers(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Inscription::class);
        $inscriptions = $rep->findAll();
        $vars = ['inscriptions' => $inscriptions];

        return $this->render('user/listeUsers.html.twig', $vars);
    }

    #[Route('/dames', name: 'liste_dames')]
    public function ListeDames(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Categorie::class);
        $cat = $rep->findOneBy(['typeCategorie'=>'Dame']);
        $inscriptions = $cat->getInscriptions();
        // $users = $inscr->getPlayer();
        // dd($inscr[0]);
        $vars = ['inscriptions' => $inscriptions];
        return $this->render('user/listeUsers.html.twig', $vars);
    }

    #[Route('/hommes', name: 'liste_hommes')]
    public function ListeHommes(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Categorie::class);
        $cat = $rep->findOneBy(['typeCategorie'=>'Homme']);
        $inscriptions = $cat->getInscriptions();
        // dd($users);
        $vars = ['inscriptions' => $inscriptions];
        return $this->render('user/listeUsers.html.twig', $vars);
    }
    
    #[Route('/mixtes', name: 'liste_mixtes')]
    public function ListeMixtes(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Categorie::class);
        $cat = $rep->findOneBy(['typeCategorie'=>'Mixte']);
        $inscriptions = $cat->getInscriptions();
        // dd($users);
        $vars = ['inscriptions' => $inscriptions];
        return $this->render('user/listeUsers.html.twig', $vars);
    }

// PROFIL JOUEUR
// SELECT BY ID
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

//EDIT
#[Route('/edit/{id}', name: 'app_user_edit')]
public function edit(Request $objetRequest, ManagerRegistry $doctrine, UserRepository $userRepository): Response
{
    // 1. Création d'une entité user
    $idUser = $objetRequest->get('id');
    $em = $doctrine->getManager();
    $user = $em->getRepository(User::class)->findOneBy(array("id" => $idUser));
    
    // 2. Création du formulaire du type souhaité (pas 'affichage'!)
    // pour héberger les données de l'entité
    $form = $this->createForm(UserEditType::class, $user);
    // , ['action'=> $this->generateUrl ('app_user_edit', ['id' => $idUser]),
    // 'method'=>'POST']);
    
    // dd($objetRequest);
    // 3. Analyse de l'objet Request du navigateur, remplissage de l'entité
    $form->handleRequest($objetRequest);
    
    // 4. Vérification: handleRequest indique qu'on vient d'un submit ou pas? Si on vient d'un submit, handleRequest remplira les données de l'entité avec les données du $_POST (ou $_GET, selon le type de form). Cet état sera enregistré dans l'objet formulaire, et isSubmitted renverra TRUE
    // dd($form->getErrors());
    if ($form->isSubmitted() && $form->isValid()) 
    {
        $userRepository->add($user);
        
        return $this->redirectToRoute('app_joueur', [], Response::HTTP_SEE_OTHER);
    }
    
    return $this->renderForm('user/edit.html.twig', [
        'user' => $user,
        'registrationForm' => $form,
    ]);
}

// DELETE
#[Route('delete/{id}', name: 'app_user_delete', methods: ['POST'])]
public function delete(Request $request, User $user, UserRepository $userRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
        $userRepository->remove($user);
        //
        $session = new Session();
        $session->invalidate();
        }

    return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
}

// // DELETE
//     #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
//     public function delete(Request $request, User $user, UserRepository $userRepository): Response
//     {
//         if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//             $userRepository->remove($user);
//         }

//         return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
//     }
    
}
