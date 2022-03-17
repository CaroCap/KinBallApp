<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Categorie;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Mettre Categ dans Array pour Faker
        $categories = $manager->getRepository(Categorie::class)->findAll();
        
        $user = new User();
        
        $user->setNom("Cap");
        $user->setPrenom("Caroline");
        $user->setEmail ("carolinecap.event@gmail.com");
        $user->setPassword($this->passwordHasher->hashPassword($user,'test1234'));
        $user->setRoles(['ROLE_ENTRAINEUR', 'ROLE_ADMIN', 'ROLE_WEBDEV']);
        $user->setCategorie($categories[2]);
        $user->setRue("Rue du Mont Blanc");
        $user->setNumero("18");
        $user->setCodePostal("1060");
        $user->setVille("Bruxelles");
        
        $user->setDateNaissance(new DateTime('1990-01-16'));
        $user->setTelephone("0473300830");
        $user->setPhoto("Caro.png");
        $user->setAccordPhoto(1);
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
            $user->setEmail ("joueur".$i."@kb.be");
            $user->setPassword($this->passwordHasher->hashPassword($user,'mdp'.$i));
            $user->setCategorie($categories[array_rand($categories)]);
            $user->setRue($faker->streetAddress());
            $user->setNumero(rand(1,1204));
            $user->setCodePostal($faker->postcode);
            $user->setVille($faker->city);            
            $user->setDateNaissance(new DateTime($faker->date()));
            $user->setTelephone($faker->phoneNumber());
            $user->setAccordPhoto(rand(0,1));   
            $user->setPersContactNom($faker->lastName() . " " . $faker->firstName());
            $user->setPersContactTel($faker->phoneNumber());
            $user->setPersContactMail($faker->email());
            $manager->persist ($user);
        }

        $manager->flush();
    }

    // Pour préciser qu'il faut d'abord faire les Fixtures de Catégories et Adresse avant User
    // implements DependentFixtureInterface en haut pour la classe et ajouter ici dépendances.
    public function getDependencies()
    {
        return([
            CategorieFixtures::class,
            AdresseFixtures::class
        ]);
    }
    
    //  public function __construct(array $init)
    // {
    //     $this->hydrate($init);
    // }

    // // HYDRATE pour mettre à jour les attributs des entités
    // public function hydrate(array $vals)
    // {
    //     foreach ($vals as $key => $value) {
    //         $method = "set" . ucfirst($key);
    //         if (method_exists($this,$method)){
    //             $this->$method($value);
    //         }
    //     }
    // }
}
