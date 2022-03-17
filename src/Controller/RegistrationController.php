<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\FormLoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, FormLoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // créer une nouvelle entité vide
        $user = new User();
        // créer un formulaire associé à cette entité
        $form = $this->createForm(RegistrationFormType::class, $user);
        // gérer la requête (et hydrater l'entité)
        $form->handleRequest($request);

        // vérifier que le formulaire a été envoyé (isSubmitted) et que les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si Accord Photo est null => False
            if($user->getAccordPhoto()===null){
                $user->setAccordPhoto(0);
            }
            
            // ENREGISTRER LA PHOTO
            if($user->getPhoto()!= null){
                // obtenir le fichier (pas un "string" mais un objet de la class UploadedFile)
            $fichier = $user->getPhoto();
            // obtenir un nom de fichier unique pour éviter les doublons dans le dossier
            $nomFichierServeur = md5(uniqid()).".".$fichier->guessExtension();
            // stocker le fichier dans le serveur (on peut indiquer un dossier)
            $fichier->move ("images/photoPlayer", $nomFichierServeur);
            // affecter le nom du fichier de l'entité. Ça sera le nom qu'on
            // aura dans la BD (un string, pas un objet UploadedFile cette fois)
            $user->setPhoto($nomFichierServeur);
            }

            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
