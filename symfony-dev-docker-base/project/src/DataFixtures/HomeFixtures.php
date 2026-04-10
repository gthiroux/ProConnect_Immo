<?php

namespace App\DataFixtures;

use App\Entity\Home;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HomeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $homes = [
            [
                'title'       => 'Belle maison familiale avec jardin',
                'adress'      => '12 rue des Lilas, 75020 Paris',
                'surface'     => 120,
                'price'       => 450000.00,
                'description' => 'Magnifique maison familiale de 120m²...',
                'image'       => 'maison1.jpg',
            ],
            [
                'title'       => 'Maison de ville rénovée',
                'adress'      => '8 avenue Victor Hugo, 69003 Lyon',
                'surface'     => 85,
                'price'       => 320000.00,
                'description' => 'Maison de ville entièrement rénovée en 2022.',
                'image'       => 'maison2.jpg',
            ],
            [
                'title'       => 'Maison contemporaine avec piscine',
                'adress'      => '34 chemin des Oliviers, 13100 Aix-en-Provence',
                'surface'     => 200,
                'price'       => 850000.00,
                'description' => 'Somptueuse maison contemporaine de 200m²...',
                'image'       => 'maison1.jpg',
            ],
            [
                'title'       => 'Charmante maison de campagne',
                'adress'      => '2 route des Vignes, 33330 Saint-Émilion',
                'surface'     => 150,
                'price'       => 380000.00,
                'description' => 'Authentique maison de campagne en pierre...',
                'image'       => 'maison2.jpg',
            ],
            [
                'title'       => 'Maison neuve BBC basse consommation',
                'adress'      => '17 impasse des Tournesols, 31400 Toulouse',
                'surface'     => 110,
                'price'       => 295000.00,
                'description' => 'Maison neuve labellisée BBC, 3 chambres...',
                'image'       => 'maison2.jpg',
            ],
        ];

        foreach ($homes as $i => $data) {
            $home = new Home();
            $home->setTitle($data['title']);
            $home->setAdress($data['adress']);
            $home->setSurface($data['surface']);
            $home->setPrice($data['price']);
            $home->setDescription($data['description']);
            $home->setImage('house/'.$data['image']);

            $manager->persist($home);

            $this->addReference('home_' . $i, $home);
        }

        $manager->flush();
    }
}