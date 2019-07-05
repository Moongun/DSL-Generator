<?php

namespace DSL\DSLBundle\Service;

class CreatedDietSorter
{
    static function getMeals(array $collection)
    {
        $meals = [];

        array_walk($collection, function ($item) use (&$meals){
            $meal = $item->getMeal();
            if (!key_exists($meal->getId(), $meals)) {
                $meals[$meal->getId()] = $meal;
            }
        });

        return $meals;
    }
}
