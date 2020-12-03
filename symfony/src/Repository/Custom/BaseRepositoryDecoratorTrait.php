<?php

namespace App\Repository\Custom;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;

/**
 * Трейт-декоратор для основных методов репозиториев, чтобы можно 
 */
trait BaseRepositoryDecoratorTrait {
    
    public function findAll()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        return $this->getResult($queryBuilder);
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

        return $this->getResult($queryBuilder);
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->findBy($criteria, $orderBy, 1);
    }

    private function getResult(QueryBuilder $queryBuilder, $hydrateMode = AbstractQuery::HYDRATE_OBJECT)
    {
        return $queryBuilder->getQuery()->getResult($hydrateMode);
    }    
}