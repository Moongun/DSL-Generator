<?php
namespace DSL\DSLBundle\Service\CalculationTypes;


use DSL\DSLBundle\Entity\DietRules;

interface CalculationTypeInterface
{
    /**
     * Return array with meals of composed diet.
     *
     * @return mixed
     */
    public function calculate();

    /**
     * Setter for DietRule.
     *
     * @param DietRules $dietRule DietRules Entity.
     *
     * @return mixed
     */
    public function setRule(DietRules $dietRule);

    /**
     * Getter for composed diet.
     *
     * @return mixed
     */
    public function getDiet();
}