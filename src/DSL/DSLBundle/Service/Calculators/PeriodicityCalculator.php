<?php
namespace DSL\DSLBundle\Service\Calculators;

class PeriodicityCalculator extends AbstractCalculator implements CalculatorInterface
{
    const NUMBER_OF_DIET_DAYS = 30;

    private $diet;

    /**
     * {@inheritDoc}
     */
    public function calculate()
    {
        $periodicities = $this->dietRule->getPeriodicities();
        $diet = [];
        $day = 1;
        do {
            $dayMeals = $this->getRandomMealsForDay();
            $diet[$day] = $dayMeals;
            $day++;
        } while ($day <= self::NUMBER_OF_DIET_DAYS);

        foreach ($periodicities as $periodicity) {
            if ($periodicity->getProduct() && $periodicity->getMeal()){
                throw new \Exception(sprintf('Periodicity (id= %s) cannot have defined product and meal together', $periodicity->getId()));
            }

            $daysToModify = $this->getDaysToModify($periodicity->getStartDay(), $periodicity->getCycle());

            $wantedProduct = $periodicity->getProduct();
            $mealsWithWantedProduct = $wantedProduct ? $this->mealRepository->getMealsByProductId($wantedProduct->getId()) : null;
            foreach ($daysToModify as $dayToModify) {
                $wantedMeal = $periodicity->getMeal() ? $periodicity->getMeal() : $mealsWithWantedProduct[array_rand($mealsWithWantedProduct, 1)];
                array_walk($diet[$dayToModify], function(&$meal) use($wantedMeal){
                    if ($meal->getType() === $wantedMeal->getType()) {
                        $meal = $wantedMeal;
                    }
                });
            }
        }

        $this->diet = $diet;

        return $this;
    }

    /**
     * Return days in which meals need to be verified/modified.
     *
     * @param int $start Day to start counting cycle.
     * @param int $cycle Number of single cycle length.
     *
     * @return array
     */
    private function getDaysToModify(int $start, int $cycle)
    {
        $day = $start;
        $result = [];

        while ($day <= self::NUMBER_OF_DIET_DAYS) {
            $result[]= $day;
            $day = $day + $cycle;
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function getDiet()
    {
        return $this->diet;
    }
}

