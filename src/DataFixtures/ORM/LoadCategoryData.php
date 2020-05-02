<?php

namespace App\DataFixtures\ORM;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $c1 = new Category();
        $c1->setName("Sci-Fi");
        $manager->persist($c1);
        
        $c2 = new Category();
        $c2->setName("Fantasy");
        $manager->persist($c2);
        
        $c3 = new Category();
        $c3->setName("Przygodowy");
        $manager->persist($c3);
        
        $c4 = new Category();
        $c4->setName("Familijny");
        $manager->persist($c4);
        
        $c5 = new Category();
        $c5->setName("Animacja");
        $manager->persist($c5);
        
        $c6 = new Category();
        $c6->setName("Komedia");
        $manager->persist($c6);
        
        $manager->flush();
        
        $this->addReference('category-sci-fi', $c1);
        $this->addReference('category-fantasy', $c2);
        $this->addReference('category-przygodowy', $c3);
        $this->addReference('category-familijny', $c4);
        $this->addReference('category-animacja', $c5);
        $this->addReference('category-komedia', $c6);
    }
    
    public function getOrder()
    {
        return 2;
    }
}