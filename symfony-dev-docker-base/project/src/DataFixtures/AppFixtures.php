<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $services=['visite','vente','location'];
         // create 20 products with random prices
        for ($i = 0; $i < count($services); $i++) {
            $service = new Service();
            $service->setName($services[$i]);
            $manager->persist($service);
        }

        $manager->flush();
    }
}
