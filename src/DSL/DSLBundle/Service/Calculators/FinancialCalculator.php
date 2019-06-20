<?php
namespace DSL\DSLBundle\Service\Calculators;

use DSL\DSLBundle\Entity\DietRules;

class FinancialCalculator extends AbstractCalculator implements CalculatorInterface
{
    private $dietRule;
    private $diet;

    public function setRule(DietRules $dietRule)
    {
        $this->dietRule = $dietRule;

        return $this;
    }

    public function calculate()
    {
        $rule = $this->dietRule->getMonthlyCost();
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getDayMeals();

            $financialValues = 0;

            foreach($dayMeals as $dayMeal) {
                $financialValues += $dayMeal->getAverageCost();
            }

            $validDayMeals = true;
            if ($rule < $financialValues) {
                $validDayMeals = false;
            }

            if ($validDayMeals) {
                $diet[$day] = $dayMeals;
                $day++;
            }
        } while ($day <= 30);

        $this->diet = $diet;

        return $this;
    }

    public function getDiet()
    {
        return $this->diet;
    }
}
