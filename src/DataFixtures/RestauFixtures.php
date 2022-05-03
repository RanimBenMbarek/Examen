<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Restau;

class RestauFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i<50;$i++)
        {
            $restau=new Restau();
            $restau->setName('RestauFixtures'.$i);
            $restau->setType('Fastfood'.$i);
            $manager->persist($restau);
        }
        $manager->flush();
    }
}
