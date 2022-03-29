<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Seance;
use App\Entity\Participation;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\SeanceFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ParticipationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $typePresence = ['Présent', 'Absent', 'Indécis'];
        $users = $manager->getRepository(User::class)->findAll();
        $seances = $manager->getRepository(Seance::class)->findAll();

        for ($i = 1; $i <= 10 ; $i++){
            $participation = new Participation();
            $participation->setTypePresence($typePresence[array_rand($typePresence)]);
            $participation->setUser($users[array_rand($users)]);
            $participation->setSeance($seances[array_rand($seances)]);
            $manager->persist($participation);
        }
        $manager->flush();
    }

    // Pour préciser qu'il faut d'abord faire d'autres Fixtures avant
    // implements DependentFixtureInterface en haut pour la classe et ajouter ici dépendances.
    public function getDependencies()
    {
        return([
            UserFixtures::class,
            SeanceFixtures::class,
        ]);
    }
}
