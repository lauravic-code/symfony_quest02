<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager){
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        // $faker = Factory::create();
        // $programFixtures = new ProgramFixtures();

        // for($i = 1; $i<11; $i++){
        //     $actor = new Actor();
        //     //Ce Faker va nous permettre d'alimenter l'instance de Actor que l'on souhaite ajouter en base
        //     $actor->setName($faker->name(2));   
        //     $actor->addProgram($this->getReference('program_' . $serie['title']));
                
        //     $manager->persist($actor);
        // }
        // $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class,
        ];
    }
}