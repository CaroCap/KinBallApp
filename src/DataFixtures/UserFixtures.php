<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        
        // ADMIN
        $user = new User();
        $user->setNom("Admin");
        $user->setPrenom("Administrator");
        $user->setEmail ("admin@gmail.com");
        $user->setPassword($this->passwordHasher->hashPassword($user,'admin'));
        $user->setRoles(['ROLE_ENTRAINEUR', 'ROLE_ADMIN']);
        $user->setDateNaissance(new DateTime('1990-01-16'));
        $user->setTelephone("0473300830");
        $user->setPhoto("kinball.png");
        $user->setAccordPhoto(1);
        $user->setDateUpdate(new DateTime());   
        $manager->persist ($user);

        // WEB DEV
        $user = new User();
        $user->setNom("Cap");
        $user->setPrenom("Caroline");
        $user->setGenre(1);
        $user->setEmail ("carolinecap.event@gmail.com");
        $user->setPassword($this->passwordHasher->hashPassword($user,'test1234'));
        $user->setRoles(['ROLE_ENTRAINEUR', 'ROLE_ADMIN', 'ROLE_WEBDEV']);
        $user->setRue("Rue du Mont Blanc");
        $user->setNumero("18");
        $user->setCodePostal("1060");
        $user->setVille("Bruxelles");
        $user->setDateNaissance(new DateTime('1990-01-16'));
        $user->setTelephone("0473300830");
        $user->setPhoto("Caro.png");
        $user->setAccordPhoto(1);
        $user->setDateUpdate(new DateTime());   
        $user->setPersContactNom("Christine Deletaille");
        $user->setPersContactTel("0478926613");
        $user->setPersContactMail("christinedeletaille@hotmail.com");
        $manager->persist ($user);

         // Pour créer des faux joueurs
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 7 ; $i++){
            $user = new User();
            $user->setNom($faker->lastName()); // avec ou sans () c'est la même
            $user->setPrenom($faker->firstName());
            $user->setGenre(rand(0,1));
            $user->setEmail ("joueur".$i."@kb.be");
            $user->setPassword($this->passwordHasher->hashPassword($user,'mdp'.$i));
            // ! $user->setRoles(['ROLE_ENTRAINEUR', 'ROLE_ADMIN', 'ROLE_WEBDEV']);
            $user->setRue($faker->streetAddress());
            $user->setNumero(rand(1,1204));
            $user->setCodePostal($faker->postcode);
            $user->setVille($faker->city);            
            $user->setDateNaissance(new DateTime($faker->date()));
            $user->setTelephone($faker->phoneNumber());
            if (($user->getGenre()) === true ) {
                $user->setPhoto('joueuse.png');
            }
            if ($user->getGenre() === false){
                $user->setPhoto('joueur.png');
            }
            if ($user->getGenre() === null) {
                $user->setPhoto("kinball.png");
            }

            $user->setAccordPhoto(rand(0,1));   
            $user->setDateUpdate(new DateTime($faker->date()));   
            $user->setPersContactNom($faker->lastName() . " " . $faker->firstName());
            $user->setPersContactTel($faker->phoneNumber());
            $user->setPersContactMail($faker->email());
            $manager->persist ($user);
        }

        $manager->flush();
    }
}
