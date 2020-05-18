<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\GrandPrix;
use App\Entity\Image;
use App\Entity\Pilote;
use App\Entity\Stats;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

/* création d'un role admin + administrateur */
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
/* création d'un role user */
$userRole = new Role();
$userRole->setTitle('ROLE_USER');
$manager->persist($userRole);


        $adminUser = new User();
        $adminUser->setUsername('hezounay')
                  ->setEmail('admin@f1.be')
                  ->setHash($this->encoder->encodePassword($adminUser,'password'))
                  ->addUserRole($adminRole);

        $manager->persist($adminUser);        
        
         // gestion des utilisateurs 

 
         for($i=1; $i<=10; $i++){
             $user = new User();
 
             $hash = $this->encoder->encodePassword($user, 'password');
 
             $user->setUsername($faker->userName())
                  ->setEmail($faker->email())
                  ->setHash($hash)
                  ->addUserRole($userRole);
                
             $manager->persist($user);    
       
         }
        


        // gestion des Grands-Prix

        for($i=1 ; $i <= 18; $i++){
            $gp = new GrandPrix();

            $title = $faker->country();
            $date = new \DateTime();
            $map = $faker->imageUrl(350,350);
            $description ="<p>".join("</p><p>",$faker->paragraphs(3))."</p>";

            $gp->setTitle($title."Grand-Prix")
               ->setDate($date)
               ->setMap($map)
               ->setDescription($description);

               
                  //gestion des images des Grands-Prix

         for($j=1; $j <= mt_rand(2,5) ; $j++){

            $cover = new Image();

            $cover->setUrl($faker->imageUrl())
                ->setCaption($faker->sentence())
                ->setGrandprix($gp);

            $manager->persist($cover);
        } 
                $manager->persist($gp); 
        }   
      

         // gestion des Pilotes

         for($i=1 ; $i <= 20; $i++){
            $pilote = new Pilote();

            $prenom = $faker->firstName();
            $nom = $faker->lastName();
            $datenaissance = new \DateTime();
            $nationalite = $faker->country();
            $actif = $faker->boolean($chanceOfGettingTrue = 50);   
            

            $pilote->setprenom($prenom)
               ->setNom($nom)
               ->setDatenaissance($datenaissance)
               ->setNationalite($nationalite)
               ->setActif($actif);
               
               
               $manager->persist($pilote); 

        } 

        // gestion des Stats

        for($i=1 ; $i <= 50; $i++){ 

            $stats = new Stats();

            $team = $faker->company();
            
            $annee = $faker->numberBetween(2014,2019);
           
            

            $stats->setTeam($team)
                
               ->SetAnnee($annee);
               
               
               
               $manager->persist($stats); 

        }
        
        $manager->flush();
    }
}
