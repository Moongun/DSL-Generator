<?php
namespace DSL\DSLBundle\Service\Calculators;

interface CalculatorInterface
{
    /**
     * Return array with meals of composed diet.
     *
     * @return mixed
     */
    public function calculate();

    /**
     * Getter for composed diet.
     *
     * @return mixed
     */
    public function getDiet();
}