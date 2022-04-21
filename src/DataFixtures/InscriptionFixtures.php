<?php

namespace App\DataFixtures;

use Faker;
use DateTime;
use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Inscription;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategorieFixtures;
use App\Entity\Saison;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jourSeance = ['Mercredi', 'Dimanche', 'Mercredi & Dimanche'];
        
        // Pour créer des faux
        $faker = Faker\Factory::create('fr_FR');
        
        $players = $manager->getRepository(User::class)->findAll();
        $categories = $manager->getRepository(Categorie::class)->findAll();
        $saisons = $manager->getRepository(Saison::class)->findAll();
        
        // Inscrire l'admin pour chaque saison
        foreach ($saisons as $saison) {
            $inscription = new Inscription();
            $inscription->setJourEntrainement($jourSeance[array_rand($jourSeance)]);
            $inscription->setDateInscription(new DateTime($faker->date()));
            $inscription->setPaiement(rand(0));
            
            $inscription->setCategorie($categories[0]);
            $inscription->setPlayer($players[0]);
            $inscription->setSaison($saison);

            $manager->persist($inscription);   
        }
        
        for ($i = 1; $i <= 10 ; $i++){
            $inscription = new Inscription();
            $inscription->setJourEntrainement($jourSeance[array_rand($jourSeance)]);
            $inscription->setDateInscription(new DateTime($faker->date()));
            $inscription->setPaiement(rand(0,1));
            $inscription->setFicheMedicale("fiche".$i.".png");
            $inscription->setCertifMedical("certif".$i.".png");
            
            $inscription->setCategorie($categories[array_rand($categories)]);
            $inscription->setPlayer($players[array_rand($players)]);
            $inscription->setSaison($saisons[array_rand($saisons)]);

            // dd($inscription);

            $manager->persist($inscription);
        }
        $manager->flush();
    }

    // Pour préciser qu'il faut d'abord faire les Fixtures de Catégories et User avant Inscription
    // implements DependentFixtureInterface en haut pour la classe et ajouter ici dépendances.
    public function getDependencies()
    {
        return([
            CategorieFixtures::class,
            UserFixtures::class,
            SaisonFixtures::class
        ]);
    }
}
