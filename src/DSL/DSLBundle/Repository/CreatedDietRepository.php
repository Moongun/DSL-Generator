<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Entity\CreatedDiet;
use Doctrine\ORM\Query\Expr;
use DSL\DSLBundle\Entity\Meal;
use DSL\DSLBundle\Entity\Product;
use DSL\DSLBundle\Entity\Ingredient;
use DSL\DSLBundle\Service\DietValidator;

class CreatedDietRepository extends EntityRepository {
    
//    private $dietValidator;
//    
//    /**
//     * @required
//     */
//    public function setDietValidator(DietValidator $dietValidator)
//    {
//        dump('adsasd');
//        $this->dietValidator = $dietValidator;
//    }
    
    /**
     * Zwraca tablicę składników dla danego okresu diety.
     * 
     * @param int $id Id reguły.
     * @param \DateTime $startDate Obiekt DateTime z początkową datą.
     * @param \DateTime $endDate Obiekt DateTime z końcową datą.
     * @return type
     */
    public function findIngredientsByRuleIdInGivenTime(int $id, $startDate, $endDate = null) {

        $query = $this->createQueryBuilder('cd')
                ->addSelect('m.name as MealName')
                ->addSelect('i.quantity * count(p.name) as ProductCount')
                ->addSelect('p.name as ProductName')
                ->join('cd.meal', 'm')
                ->join('m.ingredients', 'i')
                ->join('i.product', 'p')
                ->where('cd.dietRules = :id')
                ->andWhere('cd.date > :startDate')
                ->setParameters([
                    'id' => $id,
                    'startDate' => $startDate
                        ]);
        if ($endDate) {
            $query
                ->andWhere('cd.date <= :endDate')
                ->setParameter('endDate', $endDate);
        }
        
        $query->groupBy('cd.meal');

        
        return $query->getQuery()->getResult();
    }
    
    
//    public function pickMeals() {
//        $em = $this->getEntityManager();
//
//        //TODO uwzględnić bazę
//        $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');
//
//        $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
//        $brunches = $query->setParameter('type', 'brunch')->getResult();
//        $lunches = $query->setParameter('type', 'lunch')->getResult();
//        $dinners = $query->setParameter('type', 'obiad')->getResult();
//        $suppers = $query->setParameter('type', 'kolacja')->getResult();
//
//        $all = ['śniadanie' => $breakfasts,
//            'brunch' => $brunches,
//            'lunch' => $lunches,
//            'obiad' => $dinners,
//            'kolacja' => $suppers];
////        $all = ['breakfasts' => $breakfasts,
////            'brunches' => $brunches,
////            'lunches' => $lunches,
////            'dinners' => $dinners,
////            'suppers' => $suppers];
//
//        return $all;
//    }

//    public function shuffleMeals($meals, $rule, $whichRule = 0) {
//        $out = [];
//        //5 -it's number of repetitions of try to pass 'if' condition
//        //if 5th repetition fail, function returns new repetition without validating
//        for ($i = 0; $i <= 5; $i++) {
//            $temp = [];
//            $eValue = 0;
//            $pValue = 0;
//            $cValue = 0;
//            $fValue = 0;
//            $dayCost = 0;
//
//            foreach ($meals as $k => $type) {
//                shuffle($type);
//                $temp[$k] = $type[0];
//                $eValue+=$type[0]->getEnergyValueKcal();
//                $pValue+=$type[0]->getProteinG();
//                $cValue+=$type[0]->getCarbohydratesG();
//                $fValue+=$type[0]->getFatG();
//                $dayCost+=$type[0]->getAverageCost();
//            }
//
//            if ($i == 5) {
//                $out[] = $temp;
//                return $out[0];
//            }
//
//            switch ($whichRule) {
//                case 1:
//                    if ($eValue > ($rule - 100) && $eValue < ($rule + 100)) {
//                        $out[] = $temp;
////                        return $out;
//                    }
//                    break;
//                case 2:
//                    if ($pValue > ($rule - 10) && $pValue < ($rule + 10)) {
//                        $out[] = $temp;
////                        return $out;
//                    }
//                    break;
//                case 3:
//                    if ($cValue > ($rule - 10) && $cValue < ($rule + 10)) {
//                        $out[] = $temp;
////                        return $out;
//                    }
//                    break;
//                case 4:
//                    if ($fValue > ($rule - 10) && $fValue < ($rule + 10)) {
//                        $out[] = $temp;
////                        return $out;
//                    }
//                    break;
//                case 5:
//                    if ($dayCost > ($rule - 3.00) && $dayCost < ($rule + 3.00)) {
//                        $out[] = $temp;
////                        return $out;
//                    }
//                    break;
//            }
//        }
//    }

//    public function valueRequirementsFirst($meals, $rule, $mealsFromDb, $whichRule = 0) {
//        $out = [];
//        for ($i = 0; $i < 30; $i++) {
//            $eValue = 0;
//            $pValue = 0;
//            $cValue = 0;
//            $fValue = 0;
//            $dayCost = 0;
//
//            for ($j = 0; $j < 5; $j++) {
//                $temp = [];
//                $eValue = 0;
//                $pValue = 0;
//                $cValue = 0;
//                $fValue = 0;
//                $dayCost = 0;
//
//                foreach ($meals as $k => $type) {
//                    shuffle($type);
//                    $temp[$k] = $type[0];
//                    $eValue+=$type[0]->getEnergyValueKcal();
//                    $pValue+=$type[0]->getProteinG();
//                    $cValue+=$type[0]->getCarbohydratesG();
//                    $fValue+=$type[0]->getFatG();
//                    $dayCost+=$type[0]->getAverageCost();
//                }
//
//                switch ($whichRule) {
//                    case 1:
//                        if ($eValue > ($rule - 100) && $eValue < ($rule + 100)) {
//                            $out[] = $temp;
//                            break 2;
//                        } else {
//                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 1);
//                            break 2;
//                        }
//                        continue 2;
//                    case 2:
//                        if ($pValue > ($rule - 10) && $pValue < ($rule + 10)) {
//                            $out[] = $temp;
//                            break 2;
//                        } else {
//                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 2);
//                            break 2;
//                        }
//                        continue 2;
//                    case 3:
//                        if ($cValue > ($rule - 10) && $cValue < ($rule + 10)) {
//                            $out[] = $temp;
//                            break 2;
//                        } else {
//                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 3);
//                            break 2;
//                        }
//                        continue 2;
//                    case 4:
//                        if ($fValue > ($rule - 10) && $fValue < ($rule + 10)) {
//                            $out[] = $temp;
//                            break 2;
//                        } else {
//                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 4);
//                            break 2;
//                        }
//                        continue 2;
//                    case 5:
//                        if ($dayCost > ($rule - 3.00) && $dayCost < ($rule + 3.00)) {
//                            $out[] = $temp;
//                            break 2;
//                        } else {
//                            $out[] = $this->shuffleMeals($mealsFromDb, $rule, 5);
//                            break 2;
//                        }
//                        continue 2;
//                }
//            }
//        }
//        return $out;
//    }
//
//    public function changeKeysInArray($day){
//        $out = [];
//        
//        foreach($day as $meal){
//            $out[$meal->getType()] = $meal;
//        };
//        
//        return $out;
//    }
//        
//
//    public function valueRequirementsSecond($diet, $rule, $mealsFromDb, $whichRule = 0) {
//        $out = [];
//        foreach ($diet as $k => $day) {
//            $temp = [];
//            $eValue = 0;
//            $pValue = 0;
//            $cValue = 0;
//            $fValue = 0;
//            $dayCost = 0;
//            foreach ($day as $meal) {
//                $temp[$meal->getType()] = $meal;
//
//                $eValue+=$meal->getEnergyValueKcal();
//                $pValue+=$meal->getProteinG();
//                $cValue+=$meal->getCarbohydratesG();
//                $fValue+=$meal->getFatG();
//                $dayCost+=$meal->getAverageCost();
//            }
//            switch ($whichRule) {
//                case 1:
//                    if ($eValue > ($rule - 100) && $eValue < ($rule + 100)) {
//                        $out[] = $temp;
//                    } else {
//                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 1);
//                    }
//                    break;
//                case 2:
//                    if ($pValue > ($rule - 10) && $pValue < ($rule + 10)) {
//                        $out[] = $temp;
//                    } else {
//                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 2);
//                    }
//                    break;
//                case 3:
//                    if ($cValue > ($rule - 10) && $cValue < ($rule + 10)) {
//                        $out[] = $temp;
//                    } else {
//                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 3);
//                    }
//                    break;
//                case 4:
//                    if ($fValue > ($rule - 10) && $fValue < ($rule + 10)) {
//                        $out[] = $temp;
//                    } else {
//                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 4);
//                    }
//                    break;
//                case 5:
//                    if ($dayCost > ($rule - 3.00) && $dayCost < ($rule + 3.00)) {
//                        $out[] = $temp;
//                    } else {
//                        $out[] = $this->shuffleMeals($mealsFromDb, $rule, 5);
//                    }
//            }
//        }
//        return $out;
//    }

    /**
     * 
     * @param type $meals - meal set without selected meal 
     * @param type $selected - meal which is selected
     * @param type $rep - how many times selected will be repeted
     * @param type $inter - for how many days selected will be repeted
     * @return type
     */
    public function createWithRepetitionsFirst($meals, $selected, $rep, $inter) {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.name=:name');

        $result = $query->setParameter('name', $selected)->getResult();
        $objectMeal = $result[0];
        $mealType = $result[0]->getType();

        $out = [];
        for ($i = 0; $i < 30; $i++) {
            $temp = [];
            foreach ($meals as $type) {
                shuffle($type);
                $temp[] = $type[0];
            }
            $out[$i] = $temp;
        }
        
        $out2 = [];
        foreach ($out as $k => $day) {
            foreach ($day as $kk => $single) {
                if (($k + 1) % $inter == 0 && $k !== 0 && $single->getType() == $mealType) {
                    array_splice($out[$k], $kk, 1, $result);
                }
            }
            $temp = $this->changeKeysInArray($out[$k]);
            $out2[$k] = $temp;
        }
        return $out2;
    }

    /**
     * 
     * @param type $meals - meal set without selected meal 
     * @param type $selected - meal which is selected
     * @param type $rep - how many times selected will be repeted
     * @param type $inter - for how many days selected will be repeted
     * @return type
     */
    public function createWithRepetitionsSecond($meals, $selected, $rep, $inter) {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.name=:name');

        $result = $query->setParameter('name', $selected)->getResult();
        $objectMeal = $result[0];
        $mealType = $result[0]->getType();

        $out = [];
        foreach ($meals as $k => $day) {
            foreach ($day as $kk => $single) {
                if (($k + 1) % $inter == 0 && $k !== 0 && $single->getType() == $mealType) {
//                    array_splice($meals[$k], $kk, 1, $result);

                    switch ($single->getType()) {
                        case 'śniadanie':
                            array_splice($meals[$k], 0, 1, $result);
                            $meals[$k] = $this->replaceKey($meals[$k], 0, 'śniadanie');
                            break;
                        case 'brunch':
                            array_splice($meals[$k], 1, 1, $result);
                            $meals[$k] = $this->replaceKey($meals[$k], 1, 'brunch');
                            break;
                        case 'lunch':
                            array_splice($meals[$k], 2, 1, $result);
                            $meals[$k] = $this->replaceKey($meals[$k], 2, 'lunch');
                            break;
                        case 'obiad':
                            array_splice($meals[$k], 3, 1, $result);
                            $meals[$k] = $this->replaceKey($meals[$k], 3, 'obiad');
                            break;
                        case 'kolacja':
                            array_splice($meals[$k], 4, 1, $result);
                            $meals[$k] = $this->replaceKey($meals[$k], 4, 'kolacja');
                            break;
                    }
                }
                $temp = $this->changeKeysInArray($meals[$k]);
                $out[$k] = $temp;
            }
        }

        return $out;
    }

    public function removeMealFirst($meals, $toRemove) {
        foreach ($meals as $k => $type) {
            foreach ($type as $kk => $meal) {
                if ($meal->getName() === $toRemove) {
                    unset($meals[$k][$kk]);
                    return $meals;
                }
            }
        }
        return $meals;
    }

    public function notTheSameMeal($meals, $toCompare) {
        shuffle($meals);
        $out = [];
        if ($meals[0]->getId() == $toCompare->getId()) {
            return $this->notTheSameMeal($meals, $toCompare);
        } else {
            $out[] = $meals[0];
            return $out;
        }
    }

    public function replaceKey($array, $key1, $key2) {
        $keys = array_keys($array);
        $index = array_search($key1, $keys);

        if ($index !== false) {
            $keys[$index] = $key2;
            $array = array_combine($keys, $array);
        }

        return $array;
    }

    public function removeMealSecond($base, $meals, $toRemove) {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.name=:name');

        $result = $query->setParameter('name', $toRemove)->getResult();
        $objectMeal = $result[0];
        $mealType = $result[0]->getType();
        $mealName = $result[0]->getName();

        $removedBase = $this->removeMealFirst($base, $toRemove);
        foreach ($removedBase as $k => $type) {
            if ($k == $mealType) {
                $typeRemovedBase = $type;
            }
        }

        foreach ($meals as $k => $day) {
            foreach ($day as $kk => $meal) {
                if ($meal->getType() == $mealType && $meal->getName() == $mealName) {
                    shuffle($typeRemovedBase);
                    $otherMeal = $this->notTheSameMeal($typeRemovedBase, $objectMeal);
                    switch ($meal->getType()) {
                        case 'śniadanie':
                            array_splice($meals[$k], 0, 1, $otherMeal);
                            $meals[$k] = $this->replaceKey($meals[$k], 0, 'śniadanie');
                            break;
                        case 'brunch':
                            array_splice($meals[$k], 1, 1, $otherMeal);
                            $meals[$k] = $this->replaceKey($meals[$k], 1, 'brunch');
                            break;
                        case 'lunch':
                            array_splice($meals[$k], 2, 1, $otherMeal);
                            $meals[$k] = $this->replaceKey($meals[$k], 2, 'lunch');
                            break;
                        case 'obiad':
                            array_splice($meals[$k], 3, 1, $otherMeal);
                            $meals[$k] = $this->replaceKey($meals[$k], 3, 'obiad');
                            break;
                        case 'kolacja':
                            array_splice($meals[$k], 4, 1, $otherMeal);
                            $meals[$k] = $this->replaceKey($meals[$k], 4, 'kolacja');
                            break;
                    }
                }
            }
        }
        return $meals;
    }

    public function saveDiet($diet, $user, $rule) {
        $startDate = Date('Y-m-d');
            $i = 1;

        foreach ($diet as $day) {
            $currentDate = date('Y-m-d', strtotime($startDate . ' + ' . $i . ' days')); //zeby utworzyc date dnia danego posilku diety
            foreach ($day as $meal) {
                $item = new CreatedDiet();
                $item->setDate(new \DateTime($currentDate));
                $item->setMeal($meal);
                $item->setDietRules($rule);
                $item->setUserId($user);

                $em = $this->getEntityManager();
                $em->persist($item);
                $em->flush();
            }
            $i++;
        }
    }

    public function validateDiet($meals, $user, $rule) {
        $dietValidator = $this->dietValidator;
        $dietValidator
                ->setDietRule($rule)
                ->setDiet($meals);
        $isValid = $dietValidator->validate(); die;
        
        $this->saveDiet($meals, $user, $rule);
    }

//    public function calcDiet($ruleId, $user) {
//
//        //CHOOSEN RULES
//        $ruleRepo = $this->getEntityManager()->getRepository('DSLBundle:DietRules');
//        $rule = $ruleRepo->findOneById($ruleId);
//
//        $meals = $this->pickMeals();
//        $mealsToCorrect = $meals;
//        $start_date = Date('Y-m-d');
////        $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days')); //zeby utworzyc date dnia danego posilku diety
//
//        $caloriesRule = $rule->getDailyCaloriesRequirementsKcal();
//        if ($caloriesRule != null) {
//            switch (count($meals)) {
//                case 5:
//                    $meals = $this->valueRequirementsFirst($meals, $caloriesRule, $mealsToCorrect, 1);
//                    break;
//                case 30:
//                    $meals = $this->valueRequirementsSecond($meals, $caloriesRule, $mealsToCorrect, 1);
//                    break;
//            }
//        }
//
//        $proteinRule = $rule->getDailyProteinRequirementsG();
//        if ($proteinRule != null) {
//            switch (count($meals)) {
//                case 5:
//                    $meals = $this->valueRequirementsFirst($meals, $proteinRule, $mealsToCorrect, 2);
//                    break;
//                case 30:
//                    $meals = $this->valueRequirementsSecond($meals, $proteinRule, $mealsToCorrect, 2);
//                    break;
//            }
//        }
//
//        $carbohydratesRule = $rule->getDailyCarbohydratesRequirementsG();
//        if ($carbohydratesRule != null) {
//            switch (count($meals)) {
//                case 5:
//                    $meals = $this->valueRequirementsFirst($meals, $carbohydratesRule, $mealsToCorrect, 3);
//                    break;
//                case 30:
//                    $meals = $this->valueRequirementsSecond($meals, $carbohydratesRule, $mealsToCorrect, 3);
//                    break;
//            }
//        }
//
//        $fatsRule = $rule->getDailyFatRequirementsG();
//        if ($fatsRule != null) {
//            switch (count($meals)) {
//                case 5:
//                    $meals = $this->valueRequirementsFirst($meals, $fatsRule, $mealsToCorrect, 4);
//                    break;
//                case 30:
//                    $meals = $this->valueRequirementsSecond($meals, $fatsRule, $mealsToCorrect, 4);
//                    break;
//            }
//        }
//
//        $costRule = $rule->getMonthlyCost();
//        if ($costRule != null) {
//            $costRulePerDay = $costRule / 30;
//            switch (count($meals)) {
//                case 5:
//                    $meals = $this->valueRequirementsFirst($meals, $costRulePerDay, $mealsToCorrect, 5);
//                    break;
//                case 30:
//                    $meals = $this->valueRequirementsSecond($meals, $costRulePerDay, $mealsToCorrect, 5);
//                    break;
//            }
//        }
//
//        $mealConditionARule = $rule->getWhichMeal();
//        $mealConditionBRule = $rule->getRepetition();
//        $mealConditionCRule = $rule->getInInterval();
//        if ($mealConditionARule != null &&
////                $mealConditionBRule != null &&
//                $mealConditionCRule != null) {
//
//            switch (count($meals)) {
//                case 5:
//                    $mealsWithout = $this->removeMealFirst($meals, $mealConditionARule);
//                    $meals = $this->createWithRepetitionsFirst($mealsWithout, $mealConditionARule, $mealConditionBRule, $mealConditionCRule);
//                    break;
//                case 30:
//                    $mealsWithout = $this->removeMealSecond($mealsToCorrect, $meals, $mealConditionARule);
//                    $meals = $this->createWithRepetitionsSecond($mealsWithout, $mealConditionARule, $mealConditionBRule, $mealConditionCRule);
//                    break;
//            }
//        }
//        $this->validateDiet($meals, $user, $rule);
//    }

}
