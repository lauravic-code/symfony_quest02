<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const TOTAL_FIXTURES=10;
    public const PROGRAM_PER_ACTOR=3;
    public const PREFIX ="actor_";
    
    public function load(ObjectManager $manager){
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();
        /**
        * L'objet $faker que tu récupère est l'outil qui va te permettre 
        * de te générer toutes les données que tu souhaites
        */
        for($i=0; $i<self::TOTAL_FIXTURES; $i++) {
            $actor = new Actor();
            //Ce Faker va nous permettre d'alimenter l'instance de actor que l'on souhaite ajouter en base
            $actor->setName($faker->name());
            for($j = 0; $j < self::PROGRAM_PER_ACTOR; $j++) {
                    $program=$this->getReference(ProgramFixtures::PREFIX.($j+1));
                    $actor->addProgram($program);
                }
            $manager->persist($actor);
            $this->addReference(self::PREFIX. $i, $actor);
                
             $manager->flush();
        }
        
    }

    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class, 
           CategoryFixtures::class,
        ];
    }
}