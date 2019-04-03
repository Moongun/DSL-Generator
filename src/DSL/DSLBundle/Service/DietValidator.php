<?php
namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Service\MealReplacer;

class DietValidator {
    
    private $rule;
    private $diet;
    private $mealReplacer;
    
    public function __construct(MealReplacer $mealReplacer) 
    {
        $this->mealReplacer = $mealReplacer;
    }
    
    public function setDietRule(DietRules $rule)
    {
        $this->rule = $rule;
        return $this;
    }
    
    public function setDiet(array $diet)
    {
        $this->diet = $diet;
        return $this;
    }
    
//    /**
//     * @required
//     */
//    public function setMealReplacer(MealReplacer $mealReplacer)
//    {
//        $this->mealReplacer = $mealReplacer;
//    }
    
    /**
     * Validation of generated diet upon rule criteria.
     * 
     * @return boolean
     */
    public function validate()
    {
        $rule = $this->rule;
        
        $dailyRequirements = [
            [
                'limit' => $rule->getDailyCaloriesRequirementsKcal(),
                'method' => 'getEnergyKcal',
                'target' => 'Energy' 
            ],
            [
                'limit' => $rule->getDailyCarbohydratesRequirementsG(),
                'method' => 'getCarbohydratesG',
                'target' => 'Carbohydrates'
            ],
            [
                'limit' => $rule->getDailyFatRequirementsG(),
                'method' => 'getFatG',
                'target' => 'Fat'
            ],
            [
                'limit' => $rule->getDailyProteinRequirementsG(),
                'method' => 'getProteinG',
                'target' => 'Protein'
            ]
        ];
        
        foreach ($dailyRequirements as $dailyRequirement) {
            if($dailyRequirement['limit']){
                $isValid = $this->validateDailyRequirement(
                        $dailyRequirement['limit'], 
                        $dailyRequirement['method'],
                        $dailyRequirement['target']
                        );
            }
        }
        
        return $isValid;
    }
    
    /**
     * Checks if daily requirement(calories, protein, carbo, fat [g]) are under
     * the given rule limit.
     *  
     * @param int    $limit  Value of requirement limit.
     * @param string $method Name method to get value from meal entity.
     * @param sting  $target Target of requirement.
     *  
     * @return boolean
     */
    private function validateDailyRequirement(int $limit, string $method, string $target)
    {
        foreach($this->diet as $dayset) {
            $dayValue = 0;
            foreach ($dayset as $meal) {
                $dayValue += $meal->$method();
            }
            
            if ($dayValue > $limit) {
                $replacer = $this->mealReplacer;
                $newDayset = $replacer->replace($target, $limit);    
                dump($dayset, $dayValue, $limit, $method);

//                return false;
            }
        }
        return true;    
    }    
}
