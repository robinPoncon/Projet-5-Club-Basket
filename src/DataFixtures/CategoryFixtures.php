<?php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $name1 = "News";
        $name2 = "Tournois";
        $name3 = "Club";

        $category1 = new Category();
        $category2 = new Category();
        $category3 = new Category();

        $category1->setTitle($name1);
        $category2->setTitle($name2);
        $category3->setTitle($name3);

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);

        $manager->flush();

    }
}