<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PREFIX = "program_";
    public const TOTAL_FIXTURES = 10;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i=0; $i<self::TOTAL_FIXTURES;$i++){
            $category=$this->getReference(CategoryFixtures::PREFIX . CategoryFixtures::CATEGORIES[$faker->numberBetween(0,4)]);
            $program = new Program();            
            $program->setTitle($faker->sentence($faker->numberBetween(3, 7)));
            $program->setSynopsis($faker->sentence($faker->numberBetween(9, 15)));
            $program->setPoster($faker->imageURL());
            $program->setCountry($faker->country());
            $program->setYear($faker->numberBetween(1900,2022));
            $program->setCategory($category);
            $manager->persist($program);
            $this->addReference(self::PREFIX . $i, $program);
        }
        $manager->flush();
     }  
    public function getDependencies()
        {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
            return [
              CategoryFixtures::class,
            ];
         }
}


