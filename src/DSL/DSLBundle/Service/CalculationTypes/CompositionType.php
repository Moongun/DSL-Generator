<?php
namespace DSL\DSLBundle\Service\CalculationTypes;

use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Form\MealType;
use DSL\DSLBundle\Service\CalculationTypes\CalculationTypeInterface;
use DSL\DSLBundle\Service\MealTypes;

class CompositionType implements CalculationTypeInterface
{
    const ENERGY        = 'energy';
    const PROTEIN       = 'protein';
    const CARBOHYDRATES ='carbohydrates';
    const FAT           = 'fat';

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
        $rules = $this->getFilledRules();
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getDayMeals();

            $dayValues = [
                self::ENERGY        => 0,
                self::PROTEIN       => 0,
                self::CARBOHYDRATES => 0,
                self::FAT           => 0
            ];

            foreach($dayMeals as $dayMeal) {
                $dayValues[self::ENERGY]        += $dayMeal->getEnergyKcal();
                $dayValues[self::PROTEIN]       += $dayMeal->getProteinG();
                $dayValues[self::CARBOHYDRATES] += $dayMeal->getCarbohydratesG();
                $dayValues[self::FAT]           += $dayMeal->getFatG();
            }

            $validDayMeals = true;
            foreach ($rules as $rule => $value) {
                if ($value < $dayValues[$rule]) {
                    $validDayMeals = false;
                }
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

    private function getFilledRules()
    {
        $rules = [];
        if ($this->dietRule->getDailyCaloriesRequirementsKcal()) {
            $rules[self::ENERGY] = $this->dietRule->getDailyCaloriesRequirementsKcal();
        }
        if ($this->dietRule->getDailyProteinRequirementsG()) {
            $rules[self::PROTEIN] = $this->dietRule->getDailyProteinRequirementsG();
        }
        if ($this->dietRule->getDailyCarbohydratesRequirementsG()) {
            $rules[self::CARBOHYDRATES] = $this->dietRule->getDailyCarbohydratesRequirementsG();
        }
        if ($this->dietRule->getDailyFatRequirementsG()) {
            $rules[self::FAT] = $this->dietRule->getDailyFatRequirementsG();
        }
        return $rules;
    }
}