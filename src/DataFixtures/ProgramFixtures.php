<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS =[

        [
         'title'=>'Friends',
         'synopsis'=>'Les péripéties de 6 jeunes New-Yorkais ',
         'poster'=>'blablabla.jpeg',
         'category'=>'Action',
         'year'=>'2002',
         'country'=>'USA'
        ],

        ['title'=>'Breaking Bad',
         'synopsis'=>'La vie de Walter White, professeur de chimie dans un lycée.',
         'poster'=>'blablabla.jpeg',
         'category'=>'Aventure',
         'year'=>'1992',
         'country'=>'France'
        ],

        ['title'=>'X-Files',
         'synopsis'=>'Les agents spéciaux du FBI Fox Mulder et Dana Scully sont les enquêteurs de dossiers classés X ',
         'poster'=>'blablabla.jpeg',
         'category'=>'Fantastique',
         'year'=>'2002',
         'country'=>'Chine'
        ],

        [ 'title'=>'Game of Thrones',
         'synopsis'=>'Il y a très longtemps, à une époque oubliée, une force a détruit l\'équilibre des saisons.',
         'poster'=>'blablabla.jpeg',
         'category'=>'Animation',
         'year'=>'1992',
         'country'=>'USA'
        ],

        ['title'=>'Seinfeld',
         'synopsis'=>'Dans son propre rôle de comique, le bavard Jerry Seinfeld mène une vie qui ne le gâte pas tout le temps, notamment à cause des femmes.',
         'poster'=>'blablabla.jpeg',
         'category'=>'Horreur',
         'year'=>'1995',
         'country'=>'USA'
        ],
        ['title'=>'Les Soprano',
         'synopsis'=>'Chef de la mafia et père de famille, Tony Soprano confie ses angoisses au Dr Jennifer Melfi, son psychiatre.',
         'poster'=>'blablabla.jpeg',
         'category'=>'Animation',
         'year'=>'2002',
         'country'=>'Angleterre'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::PROGRAMS as $keys=>$serie){
            $program = new Program();            
            $program->setTitle($serie['title']);
            $program->setSynopsis($serie['synopsis']);
            $program->setPoster($serie['poster']);
            $program->setCountry($serie['country']);
            $program->setYear($serie['year']);
            $this->addReference('program_' . $serie['title'], $program);
            $program->setCategory($this->getReference('category_'.$serie['category']));
            $manager->persist($program);
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


