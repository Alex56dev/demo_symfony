<?php 

namespace App\Repository\Custom;

use Doctrine\ORM\AbstractQuery;
use Jhg\DoctrinePagination\Collection\PaginatedArrayCollection;
use Jhg\DoctrinePagination\ORM\PaginatedRepository;

abstract class TranslatablePaginatedRepository extends PaginatedRepository {
    use TranslatableRepositoryDecoratorTrait;

    /**
     * @param int        $page
     * @param int        $rpp
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int        $hydrateMode
     *
     * @return PaginatedArrayCollection
     */
    public function findPageBy(int $page, int $rpp, array $criteria = [], array $orderBy = null, $hydrateMode = AbstractQuery::HYDRATE_OBJECT): PaginatedArrayCollection
    {
        $qb = $this->createPaginatedQueryBuilder($criteria, null, $orderBy);
        $qb->addSelect($this->getEntityAlias());
        $this->processOrderBy($qb, $orderBy);

        // find all
        if ($rpp > 0) {
            $qb->addPagination($page, $rpp);
        }

        $results = $this->getResult($qb, $hydrateMode);

        // count elements if needed
        if ($rpp > 0) {
            $total = count($results) < $rpp && $page == 1 ? count($results) : $this->countBy($criteria);
        } else {
            $total = -1;
        }

        return new PaginatedArrayCollection($results, $page, $rpp, $total);
    }

}