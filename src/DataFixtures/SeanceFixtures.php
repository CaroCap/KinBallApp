<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Adresse;
use App\Entity\SeanceEntrainement;
use App\DataFixtures\AdresseFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $adresses = $manager->getRepository(Adresse::class)->findBy(['typeAdresse'=>'Entrainement']);

        // créer quelques objets Séance, stocker dans la BD
        $dateMercredi = ['2022-03-23 20:00:00', '2022-03-30', '2022-04-20', '2022-04-27', '2022-05-04'];
        $dateDimanche = ['2022-03-27', '2022-04-03', '2022-04-24', '2022-05-01', '2022-05-08'];

        // Fixtures pour entrainement mercredi
        for ($i = 0; $i < 5; $i++) {
            $seance = new SeanceEntrainement([
                'start' => new DateTime($dateMercredi[$i]),
                'end' => new DateTime($dateMercredi[$i]),
                'title' => "Entrainement hebdomadaire toutes catégories",
                'adresse' => $adresses[0],
            ]);
            $manager->persist($seance);
        }

        // Fixtures pour entrainement dimanche
        for ($i = 0; $i < 5; $i++) {
            $seance = new SeanceEntrainement([
                'start' => new DateTime($dateDimanche[$i]),
                'title' => "Entrainement hebdomadaire toutes catégories",
                'adresse' => $adresses[1],
            ]);
            $manager->persist($seance);

        }
        $manager->flush();
    }

    // Pour préciser qu'il faut d'abord faire les Fixtures de Catégories et Adresse avant User
    // implements DependentFixtureInterface en haut pour la classe et ajouter ici dépendances.
    public function getDependencies()
    {
        return([
            AdresseFixtures::class
        ]);
    }
}
