<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\Meal;

class MealRepository extends EntityRepository
{
    /**
     * Return meal ids.
     * 
     * @return type
     */
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
    
    /**
     * Return Array of meals grouped by type.
     * 
     * @return type
     */
    public function pickMeals() {
        $em = $this->getEntityManager();

        //TODO uwzględnić bazę
        $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');

        $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
        $brunches = $query->setParameter('type', 'brunch')->getResult();
        $lunches = $query->setParameter('type', 'lunch')->getResult();
        $dinners = $query->setParameter('type', 'obiad')->getResult();
        $suppers = $query->setParameter('type', 'kolacja')->getResult();

        $all = [
            'śniadanie' => $breakfasts,
            'brunch' => $brunches,
            'lunch' => $lunches,
            'obiad' => $dinners,
            'kolacja' => $suppers
                ];

        return $all;
    }
}
