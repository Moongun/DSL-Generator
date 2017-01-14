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

//                    var_dump($breakfasts[0]->getName());
//                    var_dump($brunches[0]->getName());
//                    var_dump($lunches[0]->getName());
//                    var_dump($dinners[0]->getName());
//                    var_dump($suppers[0]->getName());

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
                    
//                    var_dump($breakfasts[0]->getName());
//                    var_dump($brunches[0]->getName());
//                    var_dump($lunches[0]->getName());
//                    var_dump($dinners[0]->getName());
//                    var_dump($suppers[0]->getName());

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
                    
//                    var_dump($breakfasts[0]->getName());
//                    var_dump($brunches[0]->getName());
//                    var_dump($lunches[0]->getName());
//                    var_dump($dinners[0]->getName());
//                    var_dump($suppers[0]->getName());

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
                    
//                    var_dump($breakfasts[0]->getName());
//                    var_dump($brunches[0]->getName());
//                    var_dump($lunches[0]->getName());
//                    var_dump($dinners[0]->getName());
//                    var_dump($suppers[0]->getName());

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
            
            $costRulePerDay = $costRule/30;

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
//                    
//                    var_dump($breakfasts[0]->getName());
//                    var_dump($brunches[0]->getName());
//                    var_dump($lunches[0]->getName());
//                    var_dump($dinners[0]->getName());
//                    var_dump($suppers[0]->getName());

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
    }
}
        