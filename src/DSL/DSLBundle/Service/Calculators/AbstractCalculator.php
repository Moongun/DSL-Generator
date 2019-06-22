<?php

namespace DSL\DSLBundle\Service\Calculators;

use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Repository\MealRepository;
use DSL\DSLBundle\Service\MealTypes;

abstract class AbstractCalculator
{
    protected $mealRepository;
    protected $dietRule;
    private $meals;

    /**
     * AbstractCalculator constructor.
     *
     * @param MealRepository $mealRepository
     * @param DietRules $dietRule
     */
    public function __construct(MealRepository $mealRepository, DietRules $dietRule)
    {
        $this->mealRepository = $mealRepository;
        $this->dietRule = $dietRule;
    }

    /**
     * Runs code which has to be initialized.
     *
     * @return $this
     */
    public function initiate()
    {
        $this->meals = $this->mealRepository->pickMeals();

        return $this;
    }

    /**
     * Return random meals for a single day.
     *
     * @return array
     */
    protected function getRandomMealsForDay()
    {
        $meals = $this->meals;

        return [
            1 => $meals[MealTypes::BREAKFAST][array_rand($meals[MealTypes::BREAKFAST],1)],
            2 => $meals[MealTypes::BRUNCH][array_rand($meals[MealTypes::BRUNCH],1)],
            3 => $meals[MealTypes::LUNCH][array_rand($meals[MealTypes::LUNCH],1)],
            4 => $meals[MealTypes::DINNER][array_rand($meals[MealTypes::DINNER],1)],
            5 => $meals[MealTypes::SUPPER][array_rand($meals[MealTypes::SUPPER],1)]
        ];
    }

}