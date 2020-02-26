<?php

namespace ReclamationBundle\DataFixtures;

use ReclamationBundle\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

class ReclamationFixtures extends Fixture implements ORMFixtureInterface{

    public function load(ObjectManager $manager){

            $encours = new Status();
            $validee = new Status();
            $archivee = new Status();

            $encours->setLibelle("En cours");
            $validee->setLibelle("Validée");
            $archivee->setLibelle("Archivée");

            $manager->persist($encours);$manager->persist($validee);$manager->persist($archivee);
            $manager->flush();
    }
}