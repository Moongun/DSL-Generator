<?php

namespace DSL\DSLBundle\Service;

<<<<<<< HEAD
class CreatedDietHelper
=======
class CreatedDietSorter
>>>>>>> add_pdf_generation
{
    static function getMeals(array $collection)
    {
        $meals = [];

<<<<<<< HEAD
        array_walk($collection, function ($item) use (&$meals) {
=======
        array_walk($collection, function ($item) use (&$meals){
>>>>>>> add_pdf_generation
            $meal = $item->getMeal();
            if (!key_exists($meal->getId(), $meals)) {
                $meals[$meal->getId()] = $meal;
            }
        });

        return $meals;
    }
<<<<<<< HEAD

    static function groupMealsByWeekAndDay(array $collection)
    {
        $meals = [];
        foreach ($collection as $item) {
            $day = $item->getDay();
            if($day <= 7) {
                $meals['week_1']['day_' . $day][] = $item->getMeal();
            } elseif ($day <=14) {
                $meals['week_2']['day_' . $day][] = $item->getMeal();
            } elseif ($day <= 21) {
                $meals['week_3']['day_' . $day][] = $item->getMeal();
            } elseif ($day <= 28) {
                $meals['week_4']['day_' . $day][] = $item->getMeal();
            } elseif ($day <= 30) {
                $meals['week_5']['day_' . $day][] = $item->getMeal();
            } else {
                throw new \Exception('There is more than 30 days');
            }
        }

        return $meals;
    }
=======
>>>>>>> add_pdf_generation
}
