<?php

namespace App\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class TranslationRepositoryFactory {
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function createRepository(): TranslationRepository
    {
        return $this->manager->getRepository('Gedmo\Translatable\Entity\Translation');
    }
}