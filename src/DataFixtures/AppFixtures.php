<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $name = "DM3";
        $name2 = "DM1";
        $widgetId = "5bb7c95f45a3b523e8a6c9ce";
        $widgetId2 = "5bb7c7900277290a8910ae9a";
        $adresse = "n°5 Meximieux";
        $adresse2 = "n°5 Meximieux";
        $horaire = new \DateTime("20:30");
        $horaire->format("HH:mm");
        $horaire2 = new \DateTime("21:30");
        $horaire2->format("HH:mm");
        $day = "Mardi";
        $day2 = "Jeudi";
        $equipe = new Equipe();
        $equipe2 = new Equipe();

        $equipe->setName($name)
               ->setAddress($adresse)
               ->setHoraire($horaire)
               ->setDay($day)
               ->setWidgetId($widgetId)
        ;
        $equipe2->setName($name2)
            ->setAddress($adresse2)
            ->setHoraire($horaire2)
            ->setDay($day2)
            ->setWidgetId($widgetId2)
        ;

        $manager->persist($equipe);
        $manager->persist($equipe2);

        $manager->flush();
    }
}
