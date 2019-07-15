<?php
namespace DSL\DSLBundle\Repository;
use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Entity\CreatedDiet;
use Doctrine\ORM\Query\Expr;
use DSL\DSLBundle\Entity\Meal;
use DSL\DSLBundle\Entity\Product;
use DSL\DSLBundle\Entity\Ingredient;
use DSL\DSLBundle\Service\DietValidator;
class CreatedDietRepository extends EntityRepository {

    /**
     * Zwraca tablicę składników dla danego okresu diety.
     *
     * @param int $id Id reguły.
     * @param int $startDay Dzień diety, od którego mają być szukane składniki.
     * @param int $endDay Dzień diety. do któ©ego mają być szukane skłądniki.
     *
     * @return type
     */
    public function findIngredientsByRuleIdAndGivenDays(int $id, int $startDay, int $endDay = null) {
        $query = $this->createQueryBuilder('cd')
            ->addSelect('m.name as MealName')
            ->addSelect('i.quantity * count(p.name) as ProductCount')
            ->addSelect('p.name as ProductName')
            ->join('cd.meal', 'm')
            ->join('m.ingredients', 'i')
            ->join('i.product', 'p')
            ->where('cd.dietRules = :id')
            ->andWhere('cd.day >= :startDate')
            ->setParameters([
                'id' => $id,
                'startDate' => $startDay
            ]);

        if ($endDay) {
            $query->andWhere('cd.day <= :endDay')
                ->setParameter('endDay', $endDay);
        }

        $query->groupBy('cd.meal');

        return $query->getQuery()->getResult();
    }
}