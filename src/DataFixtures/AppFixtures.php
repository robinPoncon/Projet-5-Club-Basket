<?php

namespace App\DataFixtures;

use App\Entity\Convocation;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $name = "DM3";
        $name2 = "DM1";
        $name3 = "DF2";
        $type = "garçons";
        $type2 = "garçons";
        $type3 = "filles";
        $widgetId = "5bb7c95f45a3b523e8a6c9ce";
        $widgetId2 = "5bb7c7900277290a8910ae9a";
        $widgetId3 = "5bb7ca5633cefc1d14663173";

        $adresse = "n°5 Meximieux";
        $adresse2 = "n°5 Meximieux";
        $adresse3 = "N°5 Meximieux";
        $horaire = new \DateTime("20:30");
        $horaire->format("HH:mm");
        $horaire2 = new \DateTime("21:30");
        $horaire2->format("HH:mm");
        $horaire3 = new \DateTime("19:30");
        $horaire3->format("HH:mm");
        $day = "Mardi";
        $day2 = "Jeudi";
        $day3 = "Lundi";

        $equipe = new Equipe();
        $equipe2 = new Equipe();
        $equipe3 = new Equipe();

        $convocation1 = new Convocation();
        $convocation2 = new Convocation();
        $convocation3 = new Convocation();

        $equipe->setName($name)
            ->setType($type)
            ->setWidgetId($widgetId)
        ;

        $equipe2->setName($name2)
            ->setType($type2)
            ->setWidgetId($widgetId2)
        ;

        $equipe3->setName($name3)
            ->setType($type3)
            ->setWidgetId($widgetId3)
        ;

        $convocation1->setDay($day)
            ->setHoraire($horaire)
            ->setAddress($adresse)
            ->setEquipes($equipe)
        ;

        $convocation2->setDay($day2)
            ->setHoraire($horaire2)
            ->setAddress($adresse2)
            ->setEquipes($equipe2)
        ;

        $convocation3->setDay($day3)
            ->setHoraire($horaire3)
            ->setAddress($adresse3)
            ->setEquipes($equipe3)
        ;


        $manager->persist($equipe);
        $manager->persist($equipe2);
        $manager->persist($equipe3);
        $manager->persist($convocation1);
        $manager->persist($convocation2);
        $manager->persist($convocation3);

        $manager->flush();
    }
}
