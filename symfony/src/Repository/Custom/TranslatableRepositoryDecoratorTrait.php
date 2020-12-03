<?php

namespace App\Repository\Custom;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

trait TranslatableRepositoryDecoratorTrait {
    use BaseRepositoryDecoratorTrait;

    private function getResult(QueryBuilder $queryBuilder, $hydrateMode = AbstractQuery::HYDRATE_OBJECT)
    {
        $query = $queryBuilder->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult($hydrateMode);
    }
}