<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use App\Entity\Seance;
use App\DataFixtures\SeanceFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\InscriptionFixtures;
use App\Entity\ParticipationEntrainement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ParticipationEntrainementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $typePresence = ['Présent', 'Absent', 'Indécis'];
        $inscriptions = $manager->getRepository(Inscription::class)->findAll();
        $seances = $manager->getRepository(Seance::class)->findAll();

        for ($i = 1; $i <= 10 ; $i++){
            $participation = new ParticipationEntrainement();
            $participation->setTypePresence($typePresence[array_rand($typePresence)]);
            $participation->setInscription($inscriptions[array_rand($inscriptions)]);
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
            InscriptionFixtures::class,
            SeanceFixtures::class
        ]);
    }
}
