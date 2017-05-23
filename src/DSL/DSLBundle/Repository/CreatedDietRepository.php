<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\Diet_rules;
use DSL\DSLBundle\Entity\CreatedDiet;

class CreatedDietRepository extends EntityRepository {

    public function calcDiet($ruleId) {

        //CHOOSEN RULES
        $ruleRepo = $this->getEntityManager()->getRepository('DSLBundle:Diet_rules');
        $rule = $ruleRepo->findOneById($ruleId);

        //ALL MEALS
        $mealRepo = $this->getEntityManager()->getRepository('DSLBundle:Meal');
        $meals = $mealRepo->findAll();

        //GET TO THE CREATED DIET DATABASE 
        $dietRepo = $this->getEntityManager()->getRepository('DSLBundle:CreatedDiet');


//      REQUIREMENTS ABOUT ENERGY VALUE  
        $caloriesRule = $rule->getDailyCaloriesRequirementsKcal();
        if ($caloriesRule != null) {
            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');

            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();

            $start_date = Date('Y-m-d');

            for ($i = 0; $i < 30; $i++) {
                $allEnergyValue = 0;
                $counter = 0;
                while ($allEnergyValue < ($caloriesRule - 200) || $allEnergyValue > $caloriesRule || $counter < 5) {
                    $allEnergyValue = 0;

                    shuffle($breakfasts);
                    shuffle($brunches);
                    shuffle($lunches);
                    shuffle($dinners);
                    shuffle($suppers);

                    $allEnergyValue+=$breakfasts[0]->getEnergyValueKcal();
                    $allEnergyValue+=$brunches[0]->getEnergyValueKcal();
                    $allEnergyValue+=$lunches[0]->getEnergyValueKcal();
                    $allEnergyValue+=$dinners[0]->getEnergyValueKcal();
                    $allEnergyValue+=$suppers[0]->getEnergyValueKcal();

                    $counter++;
                    
                    //test synchonizacji z gitem
                }

                $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

                //CREATING OBIECTS OF SINGLE TYPE OF  GENERATED MEALS
                $createdBreakfasts = new CreatedDiet();
                $createdBreakfasts->setDate(new \DateTime($current_date));
                $createdBreakfasts->setMeal($breakfasts[0]);
                $createdBreakfasts->setDietRules($rule);

                $createdBrunches = new CreatedDiet();
                $createdBrunches->setDate(new \DateTime($current_date));
                $createdBrunches->setMeal($brunches[0]);
                $createdBrunches->setDietRules($rule);

                $createdLunches = new CreatedDiet();
                $createdLunches->setDate(new \DateTime($current_date));
                $createdLunches->setMeal($lunches[0]);
                $createdLunches->setDietRules($rule);

                $createdDinners = new CreatedDiet();
                $createdDinners->setDate(new \DateTime($current_date));
                $createdDinners->setMeal($dinners[0]);
                $createdDinners->setDietRules($rule);

                $createdSuppers = new CreatedDiet();
                $createdSuppers->setDate(new \DateTime($current_date));
                $createdSuppers->setMeal($suppers[0]);
                $createdSuppers->setDietRules($rule);

                // SAVING OBIECTS IN DATABASE
                $em = $this->getEntityManager();
                $em->persist($createdBreakfasts);
                $em->persist($createdBrunches);
                $em->persist($createdLunches);
                $em->persist($createdDinners);
                $em->persist($createdSuppers);

                $em->flush();
            }
        }

//      REQUIREMENTS ABOUT PROTEIN VALUE
        $proteinRule = $rule->getDailyProteinRequirementsG();
        if ($proteinRule != null) {

            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');

            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();

            $start_date = Date('Y-m-d');

            for ($i = 0; $i < 30; $i++) {
                $allProteinValue = 0;
                $counter = 0;
                while ($allProteinValue < ($proteinRule - 10) || $allProteinValue > $proteinRule || $counter < 5) {
                    $allProteinValue = 0;

                    shuffle($breakfasts);
                    shuffle($brunches);
                    shuffle($lunches);
                    shuffle($dinners);
                    shuffle($suppers);

                    $allProteinValue+=$breakfasts[0]->getProteinG();
                    $allProteinValue+=$brunches[0]->getProteinG();
                    $allProteinValue+=$lunches[0]->getProteinG();
                    $allProteinValue+=$dinners[0]->getProteinG();
                    $allProteinValue+=$suppers[0]->getProteinG();

                    $counter++;
                }
                $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

                //CREATING OBIECTS OF SINGLE TYPE OF  GENERATED MEALS
                $createdBreakfasts = new CreatedDiet();
                $createdBreakfasts->setDate(new \DateTime($current_date));
                $createdBreakfasts->setMeal($breakfasts[0]);
                $createdBreakfasts->setDietRules($rule);

                $createdBrunches = new CreatedDiet();
                $createdBrunches->setDate(new \DateTime($current_date));
                $createdBrunches->setMeal($brunches[0]);
                $createdBrunches->setDietRules($rule);

                $createdLunches = new CreatedDiet();
                $createdLunches->setDate(new \DateTime($current_date));
                $createdLunches->setMeal($lunches[0]);
                $createdLunches->setDietRules($rule);

                $createdDinners = new CreatedDiet();
                $createdDinners->setDate(new \DateTime($current_date));
                $createdDinners->setMeal($dinners[0]);
                $createdDinners->setDietRules($rule);

                $createdSuppers = new CreatedDiet();
                $createdSuppers->setDate(new \DateTime($current_date));
                $createdSuppers->setMeal($suppers[0]);
                $createdSuppers->setDietRules($rule);

                // SAVING OBIECTS IN DATABASE
                $em = $this->getEntityManager();
                $em->persist($createdBreakfasts);
                $em->persist($createdBrunches);
                $em->persist($createdLunches);
                $em->persist($createdDinners);
                $em->persist($createdSuppers);

                $em->flush();
            }
        }


        //      REQUIREMENTS ABOUT CARBOHYDRATES VALUE
        $carbohydratesRule = $rule->getDailyCarbohydratesRequirementsG();
        if ($carbohydratesRule != null) {

            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');

            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();

            $start_date = Date('Y-m-d');

            for ($i = 0; $i < 30; $i++) {
                $allCarbohydratesValue = 0;
                $counter = 0;
                while ($allCarbohydratesValue < ($carbohydratesRule - 10) || $allCarbohydratesValue > $carbohydratesRule || $counter < 5) {
                    $allCarbohydratesValue = 0;

                    shuffle($breakfasts);
                    shuffle($brunches);
                    shuffle($lunches);
                    shuffle($dinners);
                    shuffle($suppers);

                    $allCarbohydratesValue+=$breakfasts[0]->getCarbohydratesG();
                    $allCarbohydratesValue+=$brunches[0]->getCarbohydratesG();
                    $allCarbohydratesValue+=$lunches[0]->getCarbohydratesG();
                    $allCarbohydratesValue+=$dinners[0]->getCarbohydratesG();
                    $allCarbohydratesValue+=$suppers[0]->getCarbohydratesG();

                    $counter++;
                }
                $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

                //CREATING OBIECTS OF SINGLE TYPE OF  GENERATED MEALS
                $createdBreakfasts = new CreatedDiet();
                $createdBreakfasts->setDate(new \DateTime($current_date));
                $createdBreakfasts->setMeal($breakfasts[0]);
                $createdBreakfasts->setDietRules($rule);

                $createdBrunches = new CreatedDiet();
                $createdBrunches->setDate(new \DateTime($current_date));
                $createdBrunches->setMeal($brunches[0]);
                $createdBrunches->setDietRules($rule);

                $createdLunches = new CreatedDiet();
                $createdLunches->setDate(new \DateTime($current_date));
                $createdLunches->setMeal($lunches[0]);
                $createdLunches->setDietRules($rule);

                $createdDinners = new CreatedDiet();
                $createdDinners->setDate(new \DateTime($current_date));
                $createdDinners->setMeal($dinners[0]);
                $createdDinners->setDietRules($rule);

                $createdSuppers = new CreatedDiet();
                $createdSuppers->setDate(new \DateTime($current_date));
                $createdSuppers->setMeal($suppers[0]);
                $createdSuppers->setDietRules($rule);

                // SAVING OBIECTS IN DATABASE
                $em = $this->getEntityManager();
                $em->persist($createdBreakfasts);
                $em->persist($createdBrunches);
                $em->persist($createdLunches);
                $em->persist($createdDinners);
                $em->persist($createdSuppers);

                $em->flush();
            }
        }


        //      REQUIREMENTS ABOUT FAT VALUE
        $fatsRule = $rule->getDailyFatRequirementsG();
        if ($fatsRule != null) {

            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');

            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();

            $start_date = Date('Y-m-d');

            for ($i = 0; $i < 30; $i++) {
                $allFatValue = 0;
                $counter = 0;
                while ($allFatValue < ($fatsRule - 10) || $allFatValue > $fatsRule || $counter < 5) {
                    $allFatValue = 0;

                    shuffle($breakfasts);
                    shuffle($brunches);
                    shuffle($lunches);
                    shuffle($dinners);
                    shuffle($suppers);

                    $allFatValue+=$breakfasts[0]->getFatG();
                    $allFatValue+=$brunches[0]->getFatG();
                    $allFatValue+=$lunches[0]->getFatG();
                    $allFatValue+=$dinners[0]->getFatG();
                    $allFatValue+=$suppers[0]->getFatG();

                    $counter++;
                }
                $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

                //CREATING OBIECTS OF SINGLE TYPE OF  GENERATED MEALS
                $createdBreakfasts = new CreatedDiet();
                $createdBreakfasts->setDate(new \DateTime($current_date));
                $createdBreakfasts->setMeal($breakfasts[0]);
                $createdBreakfasts->setDietRules($rule);

                $createdBrunches = new CreatedDiet();
                $createdBrunches->setDate(new \DateTime($current_date));
                $createdBrunches->setMeal($brunches[0]);
                $createdBrunches->setDietRules($rule);

                $createdLunches = new CreatedDiet();
                $createdLunches->setDate(new \DateTime($current_date));
                $createdLunches->setMeal($lunches[0]);
                $createdLunches->setDietRules($rule);

                $createdDinners = new CreatedDiet();
                $createdDinners->setDate(new \DateTime($current_date));
                $createdDinners->setMeal($dinners[0]);
                $createdDinners->setDietRules($rule);

                $createdSuppers = new CreatedDiet();
                $createdSuppers->setDate(new \DateTime($current_date));
                $createdSuppers->setMeal($suppers[0]);
                $createdSuppers->setDietRules($rule);

                // SAVING OBIECTS IN DATABASE
                $em = $this->getEntityManager();
                $em->persist($createdBreakfasts);
                $em->persist($createdBrunches);
                $em->persist($createdLunches);
                $em->persist($createdDinners);
                $em->persist($createdSuppers);

                $em->flush();
            }
        }



        //      REQUIREMENTS ABOUT MONTHLY COSTS VALUE
        $costRule = $rule->getMonthlyCost();
        if ($costRule != null) {

            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');

            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();

            $start_date = Date('Y-m-d');

            $costRulePerDay = $costRule / 30;

            for ($i = 0; $i < 30; $i++) {
                $allCostValue = 0;
                $counter = 0;
                while ($allCostValue < ($costRulePerDay - 1.70) || $allCostValue > $costRulePerDay || $counter < 5) {
                    $allCostValue = 0;

                    shuffle($breakfasts);
                    shuffle($brunches);
                    shuffle($lunches);
                    shuffle($dinners);
                    shuffle($suppers);

                    $allCostValue+=$breakfasts[0]->getAverageCost();
                    $allCostValue+=$brunches[0]->getAverageCost();
                    $allCostValue+=$lunches[0]->getAverageCost();
                    $allCostValue+=$dinners[0]->getAverageCost();
                    $allCostValue+=$suppers[0]->getAverageCost();

                    $counter++;
                }
                $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

                //CREATING OBIECTS OF SINGLE TYPE OF  GENERATED MEALS
                $createdBreakfasts = new CreatedDiet();
                $createdBreakfasts->setDate(new \DateTime($current_date));
                $createdBreakfasts->setMeal($breakfasts[0]);
                $createdBreakfasts->setDietRules($rule);

                $createdBrunches = new CreatedDiet();
                $createdBrunches->setDate(new \DateTime($current_date));
                $createdBrunches->setMeal($brunches[0]);
                $createdBrunches->setDietRules($rule);

                $createdLunches = new CreatedDiet();
                $createdLunches->setDate(new \DateTime($current_date));
                $createdLunches->setMeal($lunches[0]);
                $createdLunches->setDietRules($rule);

                $createdDinners = new CreatedDiet();
                $createdDinners->setDate(new \DateTime($current_date));
                $createdDinners->setMeal($dinners[0]);
                $createdDinners->setDietRules($rule);

                $createdSuppers = new CreatedDiet();
                $createdSuppers->setDate(new \DateTime($current_date));
                $createdSuppers->setMeal($suppers[0]);
                $createdSuppers->setDietRules($rule);

                // SAVING OBIECTS IN DATABASE
                $em = $this->getEntityManager();
                $em->persist($createdBreakfasts);
                $em->persist($createdBrunches);
                $em->persist($createdLunches);
                $em->persist($createdDinners);
                $em->persist($createdSuppers);

                $em->flush();
            }
        }

        //      REQUIREMENTS ABOUT MEAL CONDITIONS
        $mealConditionARule = $rule->getWhichMeal();
        $mealConditionBRule = $rule->getRepetition();
        $mealConditionCRule = $rule->getInInterval();
        if ($mealConditionARule != null &&
                $mealConditionBRule != null &&
                $mealConditionCRule != null) {

            $em = $this->getEntityManager();
            
            //SELECT ALL RECORDS WITHOUT CHOOSEN MEAL
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type AND meal.name<>:name');

            $query->setParameter('name', $mealConditionARule);

            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();


            //SELECT CHOOSEN MEAL FROM DATABASE
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.name=:name');
            $choosenMeal = $query->setParameter('name', $mealConditionARule)->getResult();
            $choosenMealType = $choosenMeal[0]->getType();

            $start_date = Date('Y-m-d');

            $shuffledBreakfasts = [];
            $shuffledBrunches = [];
            $shuffledLunches = [];
            $shuffledDinners = [];
            $shuffledSuppers = [];

            for ($i = 0; $i < 30; $i++) {
                shuffle($breakfasts);
                shuffle($brunches);
                shuffle($lunches);
                shuffle($dinners);
                shuffle($suppers);

                $shuffledBreakfasts[] = $breakfasts[0];
                $shuffledBrunches[] = $brunches[0];
                $shuffledLunches[] = $lunches[0];
                $shuffledDinners[] = $dinners[0];
                $shuffledSuppers[] = $suppers[0];
            }
            //DIVIDE CREATED ARRAYS IN GIVEN INTERVALS
            $breakfastsInIntervals = array_chunk($shuffledBreakfasts, $mealConditionCRule);
            $brunchesInIntervals = array_chunk($shuffledBrunches, $mealConditionCRule);
            $lunchesInIntervals = array_chunk($shuffledLunches, $mealConditionCRule);
            $dinnersInIntervals = array_chunk($shuffledDinners, $mealConditionCRule);
            $suppersInIntervals = array_chunk($shuffledSuppers, $mealConditionCRule);

            //COMPARING TYPES OF MEALS TO IDENTIFY PROPER GROUP WHICH HAVE TO BE CHANGED
            if ($choosenMealType == $shuffledBreakfasts[0]->getType()) {
                $mergedArray = [];
                foreach ($breakfastsInIntervals as $singleInterval) {
                    if (count($singleInterval) == $mealConditionCRule) {
                        $clearedArray = array_splice($singleInterval, $mealConditionBRule);
                        $fullfilledBreakfastsArray = array_pad($clearedArray, $mealConditionCRule, $choosenMeal[0]);
                        shuffle($fullfilledBreakfastsArray);
                        $mergedArray = array_merge($mergedArray, $fullfilledBreakfastsArray);
                    }
                }

                while (count($mergedArray) != 30) {
                    shuffle($shuffledBreakfasts);
                    $mergedArray[] = $shuffledBreakfasts[0];
                }
                $shuffledBreakfasts = $mergedArray;
            }

            if ($choosenMealType == $shuffledBrunches[0]->getType()) {
                $mergedArray = [];
                foreach ($brunchesInIntervals as $singleInterval) {
                    if (count($singleInterval) == $mealConditionCRule) {
                        $clearedArray = array_splice($singleInterval, $mealConditionBRule);
                        $fullfilledBrunchesArray = array_pad($clearedArray, $mealConditionCRule, $choosenMeal[0]);
                        shuffle($fullfilledBrunchesArray);
                        $mergedArray = array_merge($mergedArray, $fullfilledBrunchesArray);
                    }
                }
                while (count($mergedArray) != 30) {
                    shuffle($shuffledBrunches);
                    $mergedArray[] = $shuffledBrunches[0];
                }
                $shuffledBrunches = $mergedArray;
            }


            if ($choosenMealType == $shuffledLunches[0]->getType()) {
                $mergedArray = [];
                foreach ($lunchesInIntervals as $singleInterval) {
                    if (count($singleInterval) == $mealConditionCRule) {
                        $clearedArray = array_splice($singleInterval, $mealConditionBRule);
                        $fullfilledLunchesArray = array_pad($clearedArray, $mealConditionCRule, $choosenMeal[0]);
                        shuffle($fullfilledLunchesArray);
                        $mergedArray = array_merge($mergedArray, $fullfilledLunchesArray);
                    }
                }
                while (count($mergedArray) != 30) {
                    shuffle($shuffledLunches);
                    $mergedArray[] = $shuffledLunches[0];
                }
                $shuffledLunches = $mergedArray;
            }


            if ($choosenMealType == $shuffledDinners[0]->getType()) {
                $mergedArray = [];
                foreach ($dinnersInIntervals as $singleInterval) {
                    if (count($singleInterval) == $mealConditionCRule) {
                        $clearedArray = array_splice($singleInterval, $mealConditionBRule);
                        $fullfilledDinnersArray = array_pad($clearedArray, $mealConditionCRule, $choosenMeal[0]);
                        shuffle($fullfilledDinnersArray);
                        $mergedArray = array_merge($mergedArray, $fullfilledDinnersArray);
                    }
                }
                while (count($mergedArray) != 30) {
                    shuffle($shuffledDinners);
                    $mergedArray[] = $shuffledDinners[0];
                }
                $shuffledDinners = $mergedArray;
            }


            if ($choosenMealType == $shuffledSuppers[0]->getType()) {
                $mergedArray = [];
                foreach ($suppersInIntervals as $singleInterval) {
                    if (count($singleInterval) == $mealConditionCRule) {
                        $clearedArray = array_splice($singleInterval, $mealConditionBRule);
                        $fullfilledSuppersArray = array_pad($clearedArray, $mealConditionCRule, $choosenMeal[0]);
                        shuffle($fullfilledSuppersArray);
                        $mergedArray = array_merge($mergedArray, $fullfilledSuppersArray);
                    }
                }
                while (count($mergedArray) != 30) {
                    shuffle($shuffledSuppers);
                    $mergedArray[] = $shuffledSuppers[0];
                }
                $shuffledSuppers = $mergedArray;
            }

            $current_date = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

            
//                //CREATING AND SAVING OBIECTS OF SINGLE TYPE OF GENERATED MEALS
            foreach ($shuffledBreakfasts as $breakfast) {
                $createdBreakfasts = new CreatedDiet();
                $createdBreakfasts->setDate(new \DateTime($current_date));
                $createdBreakfasts->setMeal($breakfast);
                $createdBreakfasts->setDietRules($rule);

                $em->persist($createdBreakfasts);
                $em->flush();
            }

            foreach ($shuffledBrunches as $brunch) {
                $createdBrunches = new CreatedDiet();
                $createdBrunches->setDate(new \DateTime($current_date));
                $createdBrunches->setMeal($brunch);
                $createdBrunches->setDietRules($rule);

                $em->persist($createdBrunches);
                $em->flush();
            }
            
            foreach ($shuffledLunches as $lunch) {
                $createdLunches = new CreatedDiet();
                $createdLunches->setDate(new \DateTime($current_date));
                $createdLunches->setMeal($lunch);
                $createdLunches->setDietRules($rule);

                $em->persist($createdLunches);
                $em->flush();
            }
            
            foreach ($shuffledDinners as $dinner) {
                $createdDinners = new CreatedDiet();
                $createdDinners->setDate(new \DateTime($current_date));
                $createdDinners->setMeal($dinner);
                $createdDinners->setDietRules($rule);

                $em->persist($createdDinners);
                $em->flush();
            }
            
            foreach ($shuffledSuppers as $supper) {
                $createdSuppers = new CreatedDiet();
                $createdSuppers->setDate(new \DateTime($current_date));
                $createdSuppers->setMeal($supper);
                $createdSuppers->setDietRules($rule);

                $em->persist($createdSuppers);
                $em->flush();
            }

        }
    }

}
