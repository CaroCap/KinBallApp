<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Adresse;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $types = ['Salle Entrainement', 'Salle Championnat', 'Autre'];

        $adresse = new Adresse([
            '$nomLieu' => 'VUB - Vrije Universiteit Brussels - Salle L4',
            'rue' => 'Boulevard de la Plaine',
            'numero' => '2',
            'codePostal' => '1050',
            'ville' => 'Ixelles',
            'pays' => 'Belgique',
            'typeAdresse' => $types[0]
        ]);
        $manager->persist($adresse);

        $adresse = new Adresse([
            '$nomLieu' => 'ULB - Hall des Sports de l\'Université libre de Bruxelles - Bâtiment E1',
            'rue' => 'Avenue Buyl',
            'numero' => '87A',
            'codePostal' => '1050',
            'ville' => 'Ixelles',
            'pays' => 'Belgique',
            'typeAdresse' => $types[0]
        ]);
        $manager->persist($adresse);

        // créer quelques objets Adresse, stocker dans la BD
        for ($i = 0; $i < 5; $i++) {
            $adresse = new Adresse([
                'rue' => $faker->streetAddress,
                'numero' => $faker->buildingNumber,
                'codePostal' => $faker->postcode,
                'ville' => $faker->city,
                'pays' => $faker->country,
                'typeAdresse' => $types[array_rand($types)]
            ]);
            $manager->persist($adresse);
        }
        $manager->flush();
    }

    

}
