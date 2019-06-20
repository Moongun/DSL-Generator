<?php

namespace DSL\DSLBundle\Service\Calculators;

use DSL\DSLBundle\Service\MealTypes;

abstract class AbstractCalculator
{
    private $meals;

    /**
     * Set Meals.
     *
     * @param array $meals groupped by type.
     *
     * @return $this
     */
    public function setMeals(array $meals)
    {
        $this->meals = $meals;

        return $this;
    }

    /**
     * Shuffle Meals.
     *
     * @param string|null $type
     *
     * @return mixed
     */
    protected function shuffleMealsByType(string $type = null)
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

    /**
     * Get meals for a day.
     *
     * @return array
     */
    protected function getDayMeals()
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