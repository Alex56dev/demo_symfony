<?php

namespace App\Repository;

use Doctrine\DBAL\Query\QueryBuilder as QueryQueryBuilder;
use Doctrine\ORM\QueryBuilder;

// Трейт переопределяет базовые методы репозитория, чтобы подключать TranslationWalker,
// и джойнить переводы значений в один запрос
trait TranslatableRepositoryTrait {
    
    public function findAll()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        return $this->processResult($queryBuilder);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->createQueryBuilder('a');
        $where = '';
        foreach (array_keys($criteria) as $key) {
            if (empty($where)) {
                $where = sprintf('a.%s = :%s', $key, $key);
            } else {
                $where = sprintf('%s AND a.%s = :%s', $where, $key, $key);
            }
        }
        if (!empty($where)) {
            $queryBuilder->where($where);
            $queryBuilder->setParameters($criteria);
        }

        if (isset($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $queryBuilder->addOrderBy(sprintf('a.%s', $key), $value ?? 'asc');
            }
        }
        
        if (isset($limit)) {
            $queryBuilder->setMaxResults((int) $limit);
        }

        if (isset($offset)) {
            $queryBuilder->setFirstResult((int) $offset);
        }

        return $this->processResult($queryBuilder);
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->findBy($criteria, $orderBy, 1);
    }

    private function processResult(QueryBuilder $queryBuilder)
    {
        $query = $queryBuilder->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        return $query->getResult();
    }
}