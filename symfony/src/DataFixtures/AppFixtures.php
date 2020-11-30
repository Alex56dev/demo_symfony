<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Author;
use App\Entity\Book;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class AppFixtures extends Fixture
{
    private TranslationRepository  $translateRepository;

    public function __construct(TranslationRepository  $translateRepository)
    {
        $this->translateRepository = $translateRepository;
    }
    
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i<=100; $i++) {
            $author = new Author();
            $author->setName('Лев Толстой ' . $i);
            $this->translateRepository->translate($author, 'name', 'en', 'Lev Tolstoy ' . $i);

            $book = new Book();
            $book->setName('Война и мир ' . $i);
            $book->setAuthor($author);
            $this->translateRepository->translate($book, 'name', 'en', 'War and Peace ' . $i);


            $manager->persist($author);
            $manager->persist($book);
        }
        
        $manager->flush();
    }
}
