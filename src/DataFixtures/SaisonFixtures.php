<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Saison;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SaisonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dateDebut = ['2021-08-29', '2020-08-23', '2019-08-25'];
        $dateFin = ['2022-07-03', '2021-06-27', '2020-06-28'];
        $annee1 = 2019;
        $annee2 = 2020;

        for ($i = 0; $i < 3; $i++) {
            $saison = new Saison([
                'titre' => 'Saison '. $annee1 . ' - ' . $annee2,
                'debut' => new DateTime($dateDebut[$i]),
                'fin' => new DateTime($dateFin[$i]),
            ]);
            $annee1 ++;
            $annee2 ++;

            $manager->persist($saison);
        }

        $manager->flush();
    }
}
