<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Categorie;
use App\Entity\Inscription;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    #[Route('/{id}', name: 'app_entrainement_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('entrainement/show.html.twig', [
            'seance_entrainement' => $user,
        ]);
    }

//EDIT
    #[Route('/{id}/edit', name: 'app_entrainement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entrainement/edit.html.twig', [
            'seance_entrainement' => $user,
            'form' => $form,
        ]);
    }

// DELETE
    #[Route('/{id}', name: 'app_entrainement_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_entrainement_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
