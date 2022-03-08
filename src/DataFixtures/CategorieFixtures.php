<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Length;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorieList = ['Hors Championnat', 'Mixte', 'Dame', 'Homme'];
        for ($i = 0; $i < Count($categorieList); $i++) {
            $categorie = new Categorie([
                'typeCategorie' => $categorieList[$i]
            ]);
            $manager->persist($categorie);
        }
        $manager->flush();
    }
}
