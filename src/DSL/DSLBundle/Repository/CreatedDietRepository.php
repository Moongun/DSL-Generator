<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\Diet_rules;


/**
 * CreatedDietRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CreatedDietRepository extends EntityRepository
{
    public function calcDiet($ruleId){
        
        //CHOOSEN RULES
        $ruleRepo = $this->getEntityManager()->getRepository('DSLBundle:Diet_rules');
        $rule = $ruleRepo->findOneById($ruleId);
//        var_dump($rule);
        
        //ALL MEALS
        $mealRepo = $this->getEntityManager()->getRepository('DSLBundle:Meal');
        $meals = $mealRepo->findAll();
        
        
//        shuffle($meals);
//        var_dump($meals);
//      
        
//      REQUIREMENTS ABOUT ENERGY VALUE  
        $caloriesRule = $rule->getDailyCaloriesRequirementsKcal();  
        if($caloriesRule!= null){
            
            $em = $this->getEntityManager();
            $query = $em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type=:type');
                                
            $breakfasts = $query->setParameter('type', 'śniadanie')->getResult();
            $brunches = $query->setParameter('type', 'brunch')->getResult();
            $lunches = $query->setParameter('type', 'lunch')->getResult();
            $dinners = $query->setParameter('type', 'obiad')->getResult();
            $suppers = $query->setParameter('type', 'kolacja')->getResult();
            
            $allEnergyValue=0;
            $counter=0;
            
            for($i=0; $i<30; $i++){
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

                if($allEnergyValue>$caloriesRule){
                    $allEnergyValue-=$breakfasts[0]->getEnergyValueKcal();
                    $allEnergyValue-=$brunches[0]->getEnergyValueKcal();
                    $allEnergyValue-=$lunches[0]->getEnergyValueKcal();
                    $allEnergyValue-=$dinners[0]->getEnergyValueKcal();
                    $allEnergyValue-=$suppers[0]->getEnergyValueKcal();
                    
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
                
                }
            }

            }
            
//            foreach($meals as $meal){
//                $mealEnergyValue = $meal->getEnergyValueKcal();
//                $AllEnergyValue+=$mealEnergyValue;
//                $counter++;
//                if($AllEnergyValue<=$caloriesRule && $counter<=30){
//                    return $meals;
//                }
            
            
            var_dump($mealName);
            }
//        var_dump($meals);
//        }
//        
//        
//    }
}
