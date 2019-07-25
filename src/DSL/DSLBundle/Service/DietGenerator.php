<?php
namespace DSL\DSLBundle\Service;
use DSL\DSLBundle\Repository\CreatedDietRepository;
use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Service\Calculators\CompositionCalculator;
use DSL\DSLBundle\Service\Calculators\FinancialCalculator;
use DSL\DSLBundle\Service\Calculators\PeriodicityCalculator;

class DietGenerator
{
    private $createdDietRepository;
    private $financialCalculator;
    private $compositionCalculator;
    private $periodicityCalculator;

    /**
     * DietGenerator constructor.
     *
     * @param CreatedDietRepository $createdDietRepository
     * @param FinancialCalculator $financialCalculator
     * @param CompositionCalculator $compositionCalculator
     * @param PeriodicityCalculator $periodicityCalculator
     */
    public function __construct(
        CreatedDietRepository $createdDietRepository,
        FinancialCalculator $financialCalculator,
        CompositionCalculator $compositionCalculator,
        PeriodicityCalculator $periodicityCalculator
    )
    {
        $this->createdDietRepository = $createdDietRepository;
        $this->financialCalculator = $financialCalculator;
        $this->compositionCalculator = $compositionCalculator;
        $this->periodicityCalculator = $periodicityCalculator;
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
            $calculator = $this->compositionCalculator;
        } elseif ($rule->hasFinancialRule()) {
            $calculator = $this->financialCalculator;
        } elseif ($rule->hasPeriodicityRule()) {
            $calculator = $this->periodicityCalculator;
        } else {
            throw new \Exception(sprintf('No rule parameter defined for rule_id = %s', $rule->getId()));
        }

        $diet = $calculator
            ->initiate($rule)
            ->calculate()
            ->getDiet();

        return $diet;
    }
}