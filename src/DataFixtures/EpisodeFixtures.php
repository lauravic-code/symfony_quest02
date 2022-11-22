<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\DataFixtures\ProgramFixtures;
use App\DataFixtures\SeasonFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODES_PER_SEASON= 10;
    public const PREFIX ="episode_";
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=0; $i < ProgramFixtures::TOTAL_FIXTURES ; $i++) {
       
            for ($j=0; $j < SeasonFixtures::SEASON_PER_PROGRAM; $j++) {

                $season =$this->getReference(ProgramFixtures::PREFIX .$i.'_'.SeasonFixtures::PREFIX.$j);

                for ($k=0; $k < self::EPISODES_PER_SEASON; $k++) {                
                    $episode= new Episode;

                    $episode->setTitle($faker->sentence($faker->numberBetween(3, 7)));
                    $episode->setNumber($k+1);
                    $episode->setSynopsis($faker->sentence($faker->numberBetween(9, 15)));
                    $episode->setSeason($season);
                    $this->addReference(ProgramFixtures::PREFIX .$i.'_'.SeasonFixtures::PREFIX.$j.'_' . self::PREFIX .$k, $episode);
                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           SeasonFixtures::class,
           ProgramFixtures::class,
           CategoryFixtures::class,
        ];
    }
}