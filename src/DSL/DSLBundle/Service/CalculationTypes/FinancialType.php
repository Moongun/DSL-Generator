<?php
namespace DSL\DSLBundle\Service\CalculationTypes;

use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Form\MealType;
use DSL\DSLBundle\Service\CalculationTypes\CalculationTypeInterface;
use DSL\DSLBundle\Service\MealTypes;

class FinancialType implements CalculationTypeInterface
{
    private $meals;
    private $dietRule;
    private $diet;

    public function setMeals(array $meals)
    {
        $this->meals = $meals;

        return $this;
    }

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

    private function shuffleMealsByType(string $type = null)
    {
        $meals = $this->meals;

        if ($type) {
            shuffle($meals[$type]);
        } else {
            foreach($meals as $k => $v) {
                shuffle($meals[$k]);
            }
        }

        return $meals;
    }

    private function getDayMeals()
    {
        $meals = $this->shuffleMealsByType();

        return [
            1 => $meals[MealTypes::BREAKFAST][0],
            2 => $meals[MealTypes::BRUNCH][0],
            3 => $meals[MealTypes::LUNCH][0],
            4 => $meals[MealTypes::DINNER][0],
            5 => $meals[MealTypes::SUPPER][0]
        ];
    }
}