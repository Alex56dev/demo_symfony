<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author->setName('Лев Толстой');
        $repository = $manager->getRepository('Gedmo\Translatable\Entity\Translation');
        $repository->translate($author, 'name', 'en', 'Lev Tolstoy');

        $manager->persist($author);
        $manager->flush();
    }
}
