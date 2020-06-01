<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\FonctionClub;
use App\Entity\Role;
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

        $equipe->setName($name)
            ->setType($type)
            ->setAddress($adresse)
            ->setHoraire($horaire)
            ->setDay($day)
            ->setWidgetId($widgetId)
        ;

        $equipe2->setName($name2)
            ->setType($type2)
            ->setAddress($adresse2)
            ->setHoraire($horaire2)
            ->setDay($day2)
            ->setWidgetId($widgetId2)
        ;

        $equipe3->setName($name3)
            ->setType($type3)
            ->setAddress($adresse3)
            ->setHoraire($horaire3)
            ->setDay($day3)
            ->setWidgetId($widgetId3)
        ;


        $manager->persist($equipe);
        $manager->persist($equipe2);
        $manager->persist($equipe3);

        $nameRole = "user";
        $nameRole2 = "admin";

        $nameFonction = "joueur";
        $nameFonction2 = "bureau";

        $role = new Role();
        $role->setName($nameRole);

        $role2 = new Role();
        $role2->setName($nameRole2);

        $fonction = new FonctionClub();
        $fonction->setName($nameFonction);

        $fonction2 = new FonctionClub();
        $fonction2->setName($nameFonction2);

        $manager->persist($role);
        $manager->persist($role2);
        $manager->persist($fonction);
        $manager->persist($fonction2);


        $manager->flush();
    }
}
