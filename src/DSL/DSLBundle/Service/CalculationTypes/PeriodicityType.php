<?php
namespace DSL\DSLBundle\Service\CalculationTypes;

use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Service\MealTypes;

class PeriodicityType implements CalculationTypeInterface 
{
    private $meals;
    private $dietRule;
    private $diet;
    
    public function getDiet() 
    {
        return $this->diet;
    }
    
    public function setRule(DietRules $dietRule) 
    {
        $this->dietRule = $dietRule;
        return $this;
    }
    
    public function setMeals(array $meals) 
    {
        $this->meals = $meals;
        return $this;
    }
    
    public function calculate() 
    {
        $periodicities = $this->dietRule->getPeriodicities();
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getDayMeals();
            $diet[$day] = $dayMeals;
            $day++;
        } while ($day <= 30);

//        TODO dorobić dla prodktu
        foreach ($periodicities as $periodicity) {
            $daysToModify = $this->getDaysToModify($periodicity->getStartDay(), $periodicity->getCycle());
            foreach ($daysToModify as $dayToModify) {
                array_walk($diet[$dayToModify], function(&$meal) use($periodicity){
                    if($meal->getType() === $periodicity->getMeal()->getType()) {
                        $meal = $periodicity->getMeal();
                    }
                });
            }
        }

        $this->diet = $diet;

        return $this;
    }

    private function getDaysToModify($start, $cycle)
    {
        $day = $start;
        $result = [];

        while ($day <= 30) {
            $result[]= $day;
            $day = $day + $cycle;
        }

        return $result;
    }

//    TODO zrobić porządek z tymi metodami, bo są takie same w innych miejscach
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
