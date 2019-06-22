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
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getRandomMealsForDay();

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

    /**
     * {@inheritDoc}
     */
    public function getDiet()
    {
        return $this->diet;
    }
}
