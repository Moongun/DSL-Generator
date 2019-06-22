<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use DSL\DSLBundle\Entity\Ingredient;
use DSL\DSLBundle\Entity\Meal;
use DSL\DSLBundle\Form\MealType;
use DSL\DSLBundle\Service\MealTypes;

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
            MealTypes::BREAKFAST    => $breakfasts,
            MealTypes::BRUNCH       => $brunches,
            MealTypes::LUNCH        => $lunches,
            MealTypes::DINNER       => $dinners,
            MealTypes::SUPPER       => $suppers
        ];
        return $all;
    }

    /**
     * Return array with meals faund by product id.
     *
     * @param int $productId
     *
     * @return mixed
     */
    public function getMealsByProductId(int $productId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT m
            FROM DSLBundle:Ingredient i
            JOIN DSLBundle:Meal m WITH m.id = i.meal
            WHERE i.product = :productId');
        $query->setParameter('productId', $productId);

        $result = $query->getResult();
        return $result;
    }
}
