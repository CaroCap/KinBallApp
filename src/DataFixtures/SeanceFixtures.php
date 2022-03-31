<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Saison;
use App\Entity\Seance;
use App\Entity\Categorie;
use App\DataFixtures\SaisonFixtures;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $categories = $manager->getRepository(Categorie::class)->findAll();
        $saisons = $manager->getRepository(Saison::class)->findAll();

        // créer quelques objets Séance, stocker dans la BD
        $dateMercredi = ['2022-03-23', '2022-03-30', '2022-04-20', '2022-04-27', '2022-05-04'];
        $dateDimanche = ['2022-03-27', '2022-04-03', '2022-04-24', '2022-05-01', '2022-05-08'];
        // Fixtures pour entrainement mercredi
        for ($i = 0; $i < 5; $i++) {
            $seance = new Seance([
                'title' => "Entrainement VUB",
                'description' => "Entrainement hebdomadaire toutes catégories",
                'start' => new DateTime($dateMercredi[$i] . ' 18:00:00'),
                'end' => new DateTime($dateMercredi[$i] . ' 20:00:00'),
                'numero' => '2',
                'rue' => 'Boulevard de la Plaine',
                'codePostal' => '1050',
                'ville' => 'Ixelles',
            ]);
            foreach ($categories as $categ) {
                $seance->addCategory($categ);
            }
            // $seance->addCategory($categories[array_rand($categories)]);
            $seance->setSaison($saisons[array_rand($saisons)]);

            $manager->persist($seance);
        }

        // Fixtures pour entrainement dimanche
        for ($i = 0; $i < 5; $i++) {
            $seance = new Seance ([
                'title' => "Entrainement ULB",
                'description' => "Entrainement hebdomadaire toutes catégories",
                'start' => new DateTime($dateDimanche[$i] . ' 18:00:00'),
                'end' => new DateTime($dateDimanche[$i] . ' 20:30:00'),
                'numero' => '87A',
                'rue' => 'Avenue Buyl',
                'codePostal' => '1050',
                'ville' => 'Ixelles',
            ]);
            $seance->addCategory($categories[array_rand($categories)]);
            $seance->setSaison($saisons[array_rand($saisons)]);

            $manager->persist($seance);

        }
        $manager->flush();
    }

    // Pour préciser qu'il faut d'abord faire d'autres Fixtures avant
    // implements DependentFixtureInterface en haut pour la classe et ajouter ici dépendances.
    public function getDependencies()
    {
        return([
            CategorieFixtures::class,
            SaisonFixtures::class,
        ]);
    }
}
