<?php
namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Repository\CreatedDietRepository; 
use DSL\DSLBundle\Repository\MealRepository;
use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Entity\User;

class DietGenerator
{
    private $createdDietRepository;
    private $mealRepository;
    
    public function __construct(
            CreatedDietRepository $createdDietRepository,
            MealRepository $mealRepository
        ) 
    {
        $this->createdDietRepository = $createdDietRepository;
        $this->mealRepository = $mealRepository;
    }
    
    public function calcDiet(DietRules $rule, User $user) {

        $meals = $this->mealRepository->pickMeals();
        $mealsToCorrect = $meals;
//        $start_date = Date('Y-m-d');
//        $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days')); //zeby utworzyc date dnia danego posilku diety

        $caloriesRule = $rule->getDailyCaloriesRequirementsKcal();
        if ($caloriesRule != null) {
            switch (count($meals)) {
                case 5:
                    $meals = $this->valueRequirementsFirst($meals, $caloriesRule, $mealsToCorrect, 1);
                    break;
                case 30:
                    $meals = $this->valueRequirementsSecond($meals, $caloriesRule, $mealsToCorrect, 1);
                    break;
            }
        }

        $proteinRule = $rule->getDailyProteinRequirementsG();
        if ($proteinRule != null) {
            switch (count($meals)) {
                case 5:
                    $meals = $this->valueRequirementsFirst($meals, $proteinRule, $mealsToCorrect, 2);
                    break;
                case 30:
                    $meals = $this->valueRequirementsSecond($meals, $proteinRule, $mealsToCorrect, 2);
                    break;
            }
        }

        $carbohydratesRule = $rule->getDailyCarbohydratesRequirementsG();
        if ($carbohydratesRule != null) {
            switch (count($meals)) {
                case 5:
                    $meals = $this->valueRequirementsFirst($meals, $carbohydratesRule, $mealsToCorrect, 3);
                    break;
                case 30:
                    $meals = $this->valueRequirementsSecond($meals, $carbohydratesRule, $mealsToCorrect, 3);
                    break;
            }
        }

        $fatsRule = $rule->getDailyFatRequirementsG();
        if ($fatsRule != null) {
            switch (count($meals)) {
                case 5:
                    $meals = $this->valueRequirementsFirst($meals, $fatsRule, $mealsToCorrect, 4);
                    break;
                case 30:
                    $meals = $this->valueRequirementsSecond($meals, $fatsRule, $mealsToCorrect, 4);
                    break;
            }
        }

        $costRule = $rule->getMonthlyCost();
        if ($costRule != null) {
            $costRulePerDay = $costRule / 30;
            switch (count($meals)) {
                case 5:
                    $meals = $this->valueRequirementsFirst($meals, $costRulePerDay, $mealsToCorrect, 5);
                    break;
                case 30:
                    $meals = $this->valueRequirementsSecond($meals, $costRulePerDay, $mealsToCorrect, 5);
                    break;
            }
        }

        $mealConditionARule = $rule->getWhichMeal();
        $mealConditionBRule = $rule->getRepetition();
        $mealConditionCRule = $rule->getInInterval();
        if ($mealConditionARule != null &&
//                $mealConditionBRule != null &&
                $mealConditionCRule != null) {

            switch (count($meals)) {
                case 5:
                    $mealsWithout = $this->removeMealFirst($meals, $mealConditionARule);
                    $meals = $this->createWithRepetitionsFirst($mealsWithout, $mealConditionARule, $mealConditionBRule, $mealConditionCRule);
                    break;
                case 30:
                    $mealsWithout = $this->removeMealSecond($mealsToCorrect, $meals, $mealConditionARule);
                    $meals = $this->createWithRepetitionsSecond($mealsWithout, $mealConditionARule, $mealConditionBRule, $mealConditionCRule);
                    break;
            }
        }
//        $this->validateDiet($meals, $user, $rule);
        
        return $meals;
    }
    
    public function valueRequirementsFirst($meals, $rule, $mealsFromDb, $whichRule = 0) {
        $out = [];
        for ($i = 0; $i < 30; $i++) {
            $eValue = 0;
            $pValue = 0;
            $cValue = 0;
            $fValue = 0;
            $dayCost = 0;

            for ($j = 0; $j < 5; $j++) {
                $temp = [];
                $eValue = 0;
                $pValue = 0;
                $cValue = 0;
                $fValue = 0;
                $dayCost = 0;

                foreach ($meals as $k => $type) {
                    shuffle($type);
                    $temp[$k] = $type[0];
                    $eValue+=$type[0]->getEnergyKcal();
                    $pValue+=$type[0]->getProteinG();
                    $cValue+=$type[0]->getCarbohydratesG();
                    $fValue+=$type[0]->getFatG();
                    $dayCost+=$type[0]->getAverageCost();
                }

                switch ($whichRule) {
                    case 1:
                        if ($eValue > ($rule - 100) && $eValue < ($rule + 100)) {
                            $out[] = $temp;
                            break 2;
                        } else {
                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 1);
                            break 2;
                        }
                        continue 2;
                    case 2:
                        if ($pValue > ($rule - 10) && $pValue < ($rule + 10)) {
                            $out[] = $temp;
                            break 2;
                        } else {
                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 2);
                            break 2;
                        }
                        continue 2;
                    case 3:
                        if ($cValue > ($rule - 10) && $cValue < ($rule + 10)) {
                            $out[] = $temp;
                            break 2;
                        } else {
                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 3);
                            break 2;
                        }
                        continue 2;
                    case 4:
                        if ($fValue > ($rule - 10) && $fValue < ($rule + 10)) {
                            $out[] = $temp;
                            break 2;
                        } else {
                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 4);
                            break 2;
                        }
                        continue 2;
                    case 5:
                        if ($dayCost > ($rule - 3.00) && $dayCost < ($rule + 3.00)) {
                            $out[] = $temp;
                            break 2;
                        } else {
                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 5);
                            break 2;
                        }
                        continue 2;
                }
            }
        }
        return $out;
    }

    public function changeKeysInArray($day){
        $out = [];
        
        foreach($day as $meal){
            $out[$meal->getType()] = $meal;
        };
        
        return $out;
    }
        

    public function valueRequirementsSecond($diet, $rule, $mealsFromDb, $whichRule = 0) {
        $out = [];
        foreach ($diet as $k => $day) {
            $temp = [];
            $eValue = 0;
            $pValue = 0;
            $cValue = 0;
            $fValue = 0;
            $dayCost = 0;
            foreach ($day as $meal) {
                $temp[$meal->getType()] = $meal;

                $eValue+=$meal->getEnergyValueKcal();
                $pValue+=$meal->getProteinG();
                $cValue+=$meal->getCarbohydratesG();
                $fValue+=$meal->getFatG();
                $dayCost+=$meal->getAverageCost();
            }
            switch ($whichRule) {
                case 1:
                    if ($eValue > ($rule - 100) && $eValue < ($rule + 100)) {
                        $out[] = $temp;
                    } else {
                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 1);
                    }
                    break;
                case 2:
                    if ($pValue > ($rule - 10) && $pValue < ($rule + 10)) {
                        $out[] = $temp;
                    } else {
                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 2);
                    }
                    break;
                case 3:
                    if ($cValue > ($rule - 10) && $cValue < ($rule + 10)) {
                        $out[] = $temp;
                    } else {
                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 3);
                    }
                    break;
                case 4:
                    if ($fValue > ($rule - 10) && $fValue < ($rule + 10)) {
                        $out[] = $temp;
                    } else {
                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 4);
                    }
                    break;
                case 5:
                    if ($dayCost > ($rule - 3.00) && $dayCost < ($rule + 3.00)) {
                        $out[] = $temp;
                    } else {
                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 5);
                    }
            }
        }
        return $out;
    }
    public function shuffleMeals($meals, $rule, $whichRule = 0) {
        $out = [];
        //5 -it's number of repetitions of try to pass 'if' condition
        //if 5th repetition fail, function returns new repetition without validating
        for ($i = 0; $i <= 5; $i++) {
            $temp = [];
            $eValue = 0;
            $pValue = 0;
            $cValue = 0;
            $fValue = 0;
            $dayCost = 0;

            foreach ($meals as $k => $type) {
                shuffle($type);
                $temp[$k] = $type[0];
                $eValue+=$type[0]->getEnergyKcal();
                $pValue+=$type[0]->getProteinG();
                $cValue+=$type[0]->getCarbohydratesG();
                $fValue+=$type[0]->getFatG();
                $dayCost+=$type[0]->getAverageCost();
            }

            if ($i == 5) {
                $out[] = $temp;
                return $out[0];
            }

            switch ($whichRule) {
                case 1:
                    if ($eValue > ($rule - 100) && $eValue < ($rule + 100)) {
                        $out[] = $temp;
//                        return $out;
                    }
                    break;
                case 2:
                    if ($pValue > ($rule - 10) && $pValue < ($rule + 10)) {
                        $out[] = $temp;
//                        return $out;
                    }
                    break;
                case 3:
                    if ($cValue > ($rule - 10) && $cValue < ($rule + 10)) {
                        $out[] = $temp;
//                        return $out;
                    }
                    break;
                case 4:
                    if ($fValue > ($rule - 10) && $fValue < ($rule + 10)) {
                        $out[] = $temp;
//                        return $out;
                    }
                    break;
                case 5:
                    if ($dayCost > ($rule - 3.00) && $dayCost < ($rule + 3.00)) {
                        $out[] = $temp;
//                        return $out;
                    }
                    break;
            }
        }
    }

}
