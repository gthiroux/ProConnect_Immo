<?php

namespace App\DataFixtures;

use App\Entity\Request;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RequestFixatures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $statuses = ['pas traité', 'en cours', 'terminer'];

        $data = [
            ['lastname' => 'Doe',    'firstname' => 'John',  'email' => 'john@gmail.com',  'tel' => '0123456789'],
            ['lastname' => 'Martin', 'firstname' => 'Alice', 'email' => 'alice@gmail.com', 'tel' => '0612345678'],
            ['lastname' => 'Durand', 'firstname' => 'Bob',   'email' => 'bob@gmail.com',   'tel' => '0698765432'],
            ['lastname' => 'Leroy',  'firstname' => 'Clara', 'email' => 'clara@gmail.com', 'tel' => '0645123456'],
            ['lastname' => 'Petit',  'firstname' => 'Marc',  'email' => 'marc@gmail.com',  'tel' => '0678901234'],
        ];

        foreach ($data as $i => $info) {
            $request = new Request();
            $request->setLastname($info['lastname']);
            $request->setFirstname($info['firstname']);
            $request->setEmail($info['email']);
            $request->setTel($info['tel']);
            $request->setService($this->getReference('service_' . ($i % 3), Service::class));
            $request->setDate(new \DateTime());
            $request->setStatus($statuses[0]);
        

            $manager->persist($request);
            $this->addReference('request_' . $i, $request);
        }

        $manager->flush();
    }
     public function getDependencies(): array
    {
        return [
            ServiceFixtures::class,
        ];
    }
    }
