<?php
namespace DSL\DSLBundle\Service\Calculators;

use DSL\DSLBundle\Entity\DietRules;

class CompositionCalculator extends AbstractCalculator implements CalculatorInterface
{
    const ENERGY        = 'energy';
    const PROTEIN       = 'protein';
    const CARBOHYDRATES ='carbohydrates';
    const FAT           = 'fat';

    private $dietRule;
    private $diet;

    /**
     * {@inheritDoc}
     */
    public function setRule(DietRules $dietRule)
    {
        $this->dietRule = $dietRule;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    public function getDiet()
    {
        return $this->diet;
    }

    /**
     * Get array with values for required conditions.
     *
     * @return array
     */
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