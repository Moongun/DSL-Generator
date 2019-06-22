<?php
namespace DSL\DSLBundle\Service;
use DSL\DSLBundle\Repository\CreatedDietRepository;
use DSL\DSLBundle\Repository\MealRepository;
use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Service\Calculators\CompositionCalculator;
use DSL\DSLBundle\Service\Calculators\FinancialCalculator;
use DSL\DSLBundle\Service\Calculators\PeriodicityCalculator;

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
            throw new \Exception(sprintf('There is more than one type of calculation for this rule (id = %s)', $rule->getId()));
        }

        if ($rule->hasCompositionRule()) {
            $calculator = new CompositionCalculator($this->mealRepository, $rule);
        } elseif ($rule->hasFinancialRule()) {
            $calculator = new FinancialCalculator($this->mealRepository, $rule);
        } elseif ($rule->hasPeriodicityRule()) {
            $calculator = new PeriodicityCalculator($this->mealRepository, $rule);
        } else {
            throw new \Exception(sprintf('No rule parameter defined for rule_id = %s', $rule->getId()));
        }

        $diet = $calculator
            ->initiate()
            ->calculate()
            ->getDiet();

        return $diet;
    }
}