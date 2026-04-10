<?php

namespace App\DataFixtures;

use App\Entity\Document;
use App\Entity\Home;
use App\Entity\Request;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DocFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Documents par maison, avec optionnellement une request liée
        $documentsData = [
            'home_0' => [
                ['file' => 'contrat_maison1.pdf',      'request' => 'request_0'],
                ['file' => 'rapport.pdf',  'request' => null],
            ],
            'home_1' => [
                ['file' => 'contrat_maison2.pdf',       'request' => 'request_1'],
                ['file' => 'facture.pdf',          'request' => null],
            ],
            'home_2' => [
                ['file' => 'contrat_maison1.pdf',        'request' => 'request_2'],
                ['file' => 'facture.pdf',       'request' => null],
            ],
            'home_3' => [
                ['file' => 'contrat_maison1.pdf', 'request' => 'request_3'],
                ['file' => 'rapport.pdf',    'request' => null],
            ],
            'home_4' => [
                ['file' => 'contrat_maison2.pdf',   'request' => 'request_4'],
                ['file' => 'rapport.pdf',     'request' => null],
            ],
        ];

        foreach ($documentsData as $homeRef => $docs) {
            $home = $this->getReference($homeRef, Home::class);

            foreach ($docs as $docData) {
                $document = new Document();
                $document->setDoc('documents/' . $docData['file']);
                $document->setHome($home);

                // Lier à une request si définie
                if ($docData['request'] !== null) {
                    $request = $this->getReference($docData['request'], Request::class);
                    $document->setRequest($request);
                }

                $manager->persist($document);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            HomeFixtures::class,
            RequestFixatures::class,
        ];
    }
}