<?php

namespace App\DataFixtures\ORM;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMovieData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $m1 = new Movie();
        $m1
            ->setName("Interstellar")
            ->setCover('interstellar.jpg')
            ->setDescription("Byt ludzkości na Ziemi dobiega końca wskutek zmian klimatycznych. Grupa naukowców odkrywa tunel czasoprzestrzenny, który umożliwia poszukiwanie nowego domu.")
            ->setActores("Matthew McConaughey	jako:	Cooper<br/>Anne Hathaway	jako:	Brand")
            ->setPrice(15.99)
            ->addCategory($this->getReference('category-sci-fi'));
        $manager->persist($m1);
        
        $m2 = new Movie();
        $m2
            ->setName("Jak wytresować smoka")
            ->setCover('smok.jpg')
            ->setDescription("Chuderlawy Wiking przewróci porządek w wiosce, kiedy zamiast zabić w ramach inicjacji jakiegoś smoka, zaprzyjaźni się z najgroźniejszym z nich.")
            ->setActores("Dubbing: <br/>Mateusz Damięcki	jako:	Czkawka<br/>Julia Kamińska	jako:	Astrid")
            ->setPrice(19.00)
            ->addCategory($this->getReference('category-animacja'))
            ->addCategory($this->getReference('category-przygodowy'))
            ->addCategory($this->getReference('category-fantasy'));
        $manager->persist($m2);
        
        $m3 = new Movie();
        $m3
            ->setName("Jak wytresować smoka 2")
            ->setCover('smok2.jpg')
            ->setDescription("Pięć lat po zjednoczeniu rasy smoków oraz ludzi Czkawka i Szczerbatek stają do obrony wyspy Berk przed niebezpiecznymi dzikimi bestiami, a także tajemniczym Smoczym Jeźdźcem.")
            ->setActores("Dubbing: <br/>Mateusz Damięcki	jako:	Czkawka<br/>Julia Kamińska	jako:	Astrid")
            ->setPrice(19.00)
            ->addCategory($this->getReference('category-animacja'))
            ->addCategory($this->getReference('category-przygodowy'))
            ->addCategory($this->getReference('category-fantasy'));
        $manager->persist($m3);
        
        $m4 = new Movie();
        $m4
            ->setName("Avengers: Wojna bez granic")
            ->setCover('avengers.jpg')
            ->setDescription("Potężny Thanos zbiera Kamienie Nieskończoności w celu narzucenia swojej woli wszystkim istnieniom we wszechświecie. Tylko drużyna superbohaterów znanych jako Avengers może go powstrzymać.")
            ->setActores("Robert Downey Jr.	jako:	Tony Stark / Iron Man<br />	Chris Hemsworth jako Thor<br/>Mark Ruffalo jako Bruce Banner / Hulk<br/>Chris Evans		Steve Rogers / Kapitan Ameryka ")
            ->setPrice(19.00)
            ->addCategory($this->getReference('category-przygodowy'))
            ->addCategory($this->getReference('category-fantasy'));
        
        $manager->persist($m4);
        
        $manager->flush();
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 3;
    }
}