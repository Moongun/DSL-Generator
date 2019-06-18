<?php
namespace DSL\DSLBundle\Service;
use DSL\DSLBundle\Repository\CreatedDietRepository;
use DSL\DSLBundle\Repository\MealRepository;
use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Service\CalculationTypes\CompositionType;
use DSL\DSLBundle\Service\CalculationTypes\FinancialType;
use DSL\DSLBundle\Service\CalculationTypes\PeriodicityType;

class DietGenerator
{
    private $createdDietRepository;
    private $mealRepository;

    public function __construct(
        CreatedDietRepository $createdDietRepository,
        MealRepository $mealRepository
    )
    {
        $this->createdDietRepository = $createdDietRepository;
        $this->mealRepository = $mealRepository;
    }

    /**
     * Diet calculation.
     *
     * @param DietRules $rule DieRule Entity.
     *
     * @return array|\DSL\DSLBundle\Repository\type
     */
    public function generate(DietRules $rule) {
        $activeRules = array_filter($rule->getActiveRules(), function($rule){
            return $rule;
        });

//        TODO Do rozbudowy w przyszłości o połączenie regół.
        if(1 < count($activeRules)) {
            throw new \Exception(sprintf('Zdefiniowano więcej niż jeden typ kalkulacji dla reguły (id = %s)', $rule->getId()));
        }

        if ($rule->hasCompositionRule()) {
            $calculationType = new CompositionType();
        } elseif ($rule->hasFinancialRule()) {
            $calculationType = new FinancialType();
        } elseif ($rule->hasPeriodicityRule()) {
            $calculationType = new PeriodicityType();
        } else {
            throw new \Exception(sprintf('No rule parameter defined for rule_id = %s', $rule->getId()));
        }

        $meals = $this->mealRepository->pickMeals();
        $diet = $calculationType
            ->setMeals($meals)
            ->setRule($rule)
            ->calculate()
            ->getDiet();

        return $diet;
    }
}