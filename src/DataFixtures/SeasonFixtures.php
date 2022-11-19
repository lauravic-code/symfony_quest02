<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Episode;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

//     public $allSeasons;
    
    
// public function getAllSeason(): Collection
//     {   $this->allSeasons= [];
//         return $this->allSeasons;
//     }

//     public function setAllSeason($value): Collection
//     {
//         $table=$this->getAllSeason();
//         $table=array_push($table,$value);
//         return $table;
//     }
    
    public function load(ObjectManager $manager){
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();
        $programFixtures = new ProgramFixtures();
        /**
        * L'objet $faker que tu récupère est l'outil qui va te permettre 
        * de te générer toutes les données que tu souhaites
        */
        foreach($programFixtures::PROGRAMS as $serie) {
            $serieName=$serie['title'];
            
                for($i = 0; $i < 5; $i++) {
                    $season = new Season();
                    //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                    $season->setNumber($faker->numberBetween(1, 10));
                    $season->setYear($faker->year());
                    $season->setDescription($faker->paragraphs(3, true));
                    $this->addReference('season_' . $i.'_'.$serieName, $season);
                    $season->setProgram($this->getReference('program_'.$serie['title']));
                   
                    $manager->persist($season);

                        for($j = 0; $j<10; $j++){
                            $episode = new Episode();
                            //Ce Faker va nous permettre d'alimenter l'instance de episode que l'on souhaite ajouter en base
                            $episode->setNumber($faker->numberBetween(1, 10));
                            $episode->setTitle($faker->sentence($faker->numberBetween(1, 5)));
                            $episode->setSynopsis($faker->paragraphs(3, true));
                            $episode->setSeason($this->getReference('season_' . $i.'_'.$serieName));
            
                            $manager->persist($episode);
                        }
                }
             $manager->flush();
        }
        
    }

    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class,
        ];
    }
}