<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $faker=Factory::create();
         for ($i=0;$i<13;$i++){
             $personne = new \App\Entity\Personne();
             $personne->setFirstname($faker->firstName);
             $personne->setName($faker->name);
             $personne->setAge($faker->randomDigit);
             $manager->persist($personne);

         }

        $manager->flush();
    }
}
