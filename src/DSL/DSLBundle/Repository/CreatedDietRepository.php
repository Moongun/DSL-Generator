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
     * @param \DateTime $startDate Obiekt DateTime z początkową datą.
     * @param \DateTime $endDate Obiekt DateTime z końcową datą.
     * @return type
     */
    public function findIngredientsByRuleIdInGivenTime(int $id, $startDate, $endDate = null) {
        $query = $this->createQueryBuilder('cd')
            ->addSelect('m.name as MealName')
            ->addSelect('i.quantity * count(p.name) as ProductCount')
            ->addSelect('p.name as ProductName')
            ->join('cd.meal', 'm')
            ->join('m.ingredients', 'i')
            ->join('i.product', 'p')
            ->where('cd.dietRules = :id')
            ->andWhere('cd.date > :startDate')
            ->setParameters([
                'id' => $id,
                'startDate' => $startDate
            ]);
        if ($endDate) {
            $query
                ->andWhere('cd.date <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        $query->groupBy('cd.meal');

        return $query->getQuery()->getResult();
    }
}