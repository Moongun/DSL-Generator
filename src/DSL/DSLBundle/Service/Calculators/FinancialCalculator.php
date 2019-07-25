<?php
namespace DSL\DSLBundle\Service\Calculators;

class FinancialCalculator extends AbstractCalculator implements CalculatorInterface
{
    private $diet;

    /**
     * {@inheritDoc}
     */
    public function calculate()
    {
        $rule = $this->dietRule->getMonthlyCost();
        $days = $this->dietDays;
        $dayCost = $rule / $days;
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getRandomMealsForDay();

            $financialValues = 0;

            foreach($dayMeals as $dayMeal) {
                $financialValues += $dayMeal->getAverageCost();
            }

            $validDayMeals = true;
            if ($dayCost < $financialValues) {
                $validDayMeals = false;
            }

            if ($validDayMeals) {
                $diet[$day] = $dayMeals;
                $day++;
            }
        } while ($day <= $days);

        $this->diet = $diet;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDiet()
    {
        return $this->diet;
    }
}
