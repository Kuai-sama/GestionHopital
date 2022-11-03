<?php

namespace App\DataFixtures;

use App\Entity\Lit;
use App\Entity\Salle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $salle = new Salle();
        $salle->setNomSalle('Salle 235')
            ->setEmplacementSalle('3NG55')
            ->setTypeSalle('Bloc Opératoire');

        $salle2 = new Salle();
        $salle2->setNomSalle('Salle 45')
            ->setEmplacementSalle('-1OD12')
            ->setTypeSalle('Salle de cardiologie');

        $lt1 = new Lit();
        $lt1->setSalle($salle)
            ->setLitOccupe(false);

        $lt2 = new Lit();
        $lt2->setSalle($salle2)
            ->setLitOccupe(true);


        $manager->persist($salle);
        $manager->persist($salle2);
        $manager->persist($lt1);
        $manager->persist($lt2);
        $manager->flush();
    }
}