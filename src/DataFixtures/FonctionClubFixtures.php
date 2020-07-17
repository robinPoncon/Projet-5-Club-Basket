<?php
namespace App\DataFixtures;

use App\Entity\FonctionClub;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FonctionClubFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $name1 = "Joueur";
        $name2 = "Membre du bureau";
        $name3 = "Officiel";
        $name4 = "OTM";
        $name5 = "Arbitre";
        $name6 = "Entraîneur";

        $fonction1 = new FonctionClub();
        $fonction2 = new FonctionClub();
        $fonction3 = new FonctionClub();
        $fonction4 = new FonctionClub();
        $fonction5 = new FonctionClub();
        $fonction6 = new FonctionClub();

        $fonction1->setName($name1);
        $fonction2->setName($name2);
        $fonction3->setName($name3);
        $fonction4->setName($name4);
        $fonction5->setName($name5);
        $fonction6->setName($name6);

        $manager->persist($fonction1);
        $manager->persist($fonction2);
        $manager->persist($fonction3);
        $manager->persist($fonction4);
        $manager->persist($fonction5);
        $manager->persist($fonction6);

        $manager->flush();


    }
}