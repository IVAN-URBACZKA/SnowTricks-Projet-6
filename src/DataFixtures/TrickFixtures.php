<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=10 ; $i++)
        {
            $trick = new Trick();
            $trick->setTitle("Trick $i")
                  ->setDescription("<p>Description $i</p>")
                  ->setImage("http://placehold.it/350x150")
                  ->setVideo("<embed src='https://www.youtube.com/embed/F9Bo89m2f6g' allowfullscreen='true' width='425' height='344'>")
                  ->setCreatedAt(new \DateTime());

            $manager->persist($trick);
        }

        $manager->flush();
    }
}
