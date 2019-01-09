<?php
namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Entity\DietRules;

class DietValidator {
    
    private $rule;
    private $diet;
    
    public function __construct(DietRules $rule, array $diet) 
    {
        $this->rule = $rule;
        $this->diet = $diet;
    }

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
                'method' => 'getEnergyValueKcal'
            ],
            [
                'limit' => $rule->getDailyCarbohydratesRequirementsG(),
                'method' => 'getCarbohydratesG'
            ],
            [
                'limit' => $rule->getDailyFatRequirementsG(),
                'method' => 'getFatG'
            ],
            [
                'limit' => $rule->getDailyProteinRequirementsG(),
                'method' => 'getProteinG'
            ]
        ];
        
        foreach ($dailyRequirements as $dailyRequirement) {
            if($dailyRequirement['limit']){
                $isValid = $this->validateDailyRequirement(
                        $dailyRequirement['limit'], 
                        $dailyRequirement['method']
                        );
            }
        }
        return $isValid;
    }
    
    /**
     * Checks if daily requirement(calories, protein, carbo, fat [g]) are under
     * the given rule limit.
     *  
     * @param int    $limit  Value of calory limit.
     * @param string $method Name method to get value from meal entity.
     *  
     * @return boolean
     */
    private function validateDailyRequirement(int $limit, string $method)
    {
        foreach($this->diet as $dayset) {
            $dayValue = 0;
            foreach ($dayset as $meal) {
//                dump($meal);
                $dayValue += $meal->$method();
            }
            if ($dayValue > $limit) {
                return false;
            }
        }
        return true;    
    }    
}
