<?php
namespace DSL\DSLBundle\Service\CalculationTypes;

use DSL\DSLBundle\Entity\DietRules;

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
    
        
    }
    
}
