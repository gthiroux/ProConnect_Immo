<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture {
    public function load(ObjectManager $manager): void
    {

        $data = [
            ['lastname' => 'Doe',    'firstname' => 'celestin',  'email' => 'celestin@gmail.com','password'=>'$2y$13$Sa0liQht5AVAHfy8Jrqh5uAU6whHk/ClPnbyIrB35mxPlBwH4b/Ru'  ],
            ['lastname' => 'Martin',    'firstname' => 'Martin',  'email' => 'martin@gmail.com','password'=>'$2y$13$SFRjNmkCPOENkdTURVYS3ukQJMOeCBqCwWn/XaONWiDIHEO31KOTO'  ],
            
        ];

        foreach ($data as $i => $info) {
            $admin = new Admin();
            $admin->setLastname($info['lastname']);
            $admin->setFirstname($info['firstname']);
            $admin->setEmail($info['email']);
            $admin->setPassword($info['password']);

            $manager->persist($admin);
        }

        $manager->flush();
    }

    }
