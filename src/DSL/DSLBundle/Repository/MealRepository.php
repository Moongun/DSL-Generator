<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\Meal;

class MealRepository extends EntityRepository
{
    public function findMealIds()
    {
        $query = $this->getEntityManager()
                ->getRepository(Meal::class)
                ->createQueryBuilder('m')
                ->select('m.id')
                ->getQuery();
        $result = $query->getResult();
        $ids = array_column($result, 'id');
        return $ids;
    }
}
