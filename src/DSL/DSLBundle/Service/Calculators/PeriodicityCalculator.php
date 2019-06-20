<?php
namespace DSL\DSLBundle\Service\Calculators;

use DSL\DSLBundle\Entity\DietRules;

class PeriodicityCalculator extends AbstractCalculator implements CalculatorInterface
{
    private $dietRule;
    private $diet;

    /**
     * {@inheritDoc}
     */
    public function getDiet() 
    {
        return $this->diet;
    }

    /**
     * {@inheritDoc}
     */
    public function setRule(DietRules $dietRule) 
    {
        $this->dietRule = $dietRule;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function calculate()
    {
        $periodicities = $this->dietRule->getPeriodicities();
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getDayMeals();
            $diet[$day] = $dayMeals;
            $day++;
        } while ($day <= 30);


//        TODO dorobić dla prodktu
        foreach ($periodicities as $periodicity) {
            $daysToModify = $this->getDaysToModify($periodicity->getStartDay(), $periodicity->getCycle());
            if($periodicity->getProduct()) {
                dump($periodicity->getProduct())->getId();

            }
            foreach ($daysToModify as $dayToModify) {
                array_walk($diet[$dayToModify], function(&$meal) use($periodicity){
                    $wantedProduct = $periodicity->getProduct();
//                    dump($wantedProduct);
                    if ($wantedProduct) {

                    }

                    if($periodicity->getMeal() && $meal->getType() === $periodicity->getMeal()->getType()) {
                        $meal = $periodicity->getMeal();
                    }
                });
            }
        }

        $this->diet = $diet;

        return $this;
    }

    /**
     * Return days which meals needed to verify/modify.
     *
     * @param $start
     * @param $cycle
     *
     * @return array
     */
    private function getDaysToModify($start, $cycle)
    {
        $day = $start;
        $result = [];

        while ($day <= 30) {
            $result[]= $day;
            $day = $day + $cycle;
        }

        return $result;
    }
}

