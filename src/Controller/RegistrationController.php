<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Form\RegistrationFormType;
use App\Security\FormLoginAuthenticator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Polyfill\Intl\Icu\DateFormat\YearTransformer;

class RegistrationController extends AbstractController
{
// CREATION D'UN COMPTE
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
            $fichier->move ("upload/photoPlayer", $nomFichierServeur);
            // affecter le nom du fichier de l'entité. Ça sera le nom qu'on
            // aura dans la BD (un string, pas un objet UploadedFile cette fois)
            $user->setPhoto($nomFichierServeur);
            }

            // DATE UPDATE
            $user->setDateUpdate(new DateTime());

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

// INSCRIPTION À UNE SAISON
    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, EntityManagerInterface $entityManager): Response
    {
        // créer une nouvelle entité vide
        $inscription = new Inscription();
        // créer un formulaire associé à cette entité
        $form = $this->createForm(InscriptionType::class, $inscription);
        // gérer la requête (et hydrater l'entité)
        $form->handleRequest($request);

        // vérifier que le formulaire a été envoyé (isSubmitted) et que les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            
            // ENREGISTRER LES UPLOAD
            // FICHE MEDICALE
            if($inscription->getFicheMedicale()!= null){
            // obtenir le fichier (pas un "string" mais un objet de la class UploadedFile)
            $fichier = $inscription->getFicheMedicale();
            // obtenir un nom de fichier unique pour éviter les doublons dans le dossier
            $nomFichierServeur = md5(uniqid()) . "." . $fichier->guessExtension();
            // stocker le fichier dans le serveur (on peut indiquer un dossier)
            $fichier->move ("upload/ficheMedicale", $nomFichierServeur);
            // affecter le nom du fichier de l'entité. Ça sera le nom qu'on
            // aura dans la BD (un string, pas un objet UploadedFile cette fois)
            $inscription->setFicheMedicale($nomFichierServeur);
            }

            // CERTIFICAT
            if($inscription->getCertifMedical()!= null){
                // obtenir le fichier (pas un "string" mais un objet de la class UploadedFile)
                $fichier = $inscription->getCertifMedical();
                // obtenir un nom de fichier unique pour éviter les doublons dans le dossier
                $nomFichierServeur = md5(uniqid()) . "." . $fichier->guessExtension();
                // stocker le fichier dans le serveur (on peut indiquer un dossier)
                $fichier->move ("upload/ficheMedicale", $nomFichierServeur);
                // affecter le nom du fichier de l'entité. Ça sera le nom qu'on
                // aura dans la BD (un string, pas un objet UploadedFile cette fois)
                $inscription->getCertifMedical($nomFichierServeur);
                }

            // DATE INSCRIPTION
            $inscription->setDateInscription(new DateTime());
            
            // DATE SAISON
            // $ajd = new DateTime();
            // $anneeSaison = $ajd->format("y") ;
            // if
            $inscription->setSaison("21-22");

            // PAIEMENT
            $inscription->setPaiement(0);

            $entityManager->persist($inscription);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_entrainement_index');
        }

        return $this->render('registration/inscription.html.twig', [
            'inscription' => $form->createView(),
        ]);
    }
}
