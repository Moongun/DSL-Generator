<?php

namespace DSL\DSLBundle\Service;

class CreatedDietRecipies {

    private $data;

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    private function init()
    {
        return [];
    }


    private function prepare()
    {
        $recipies = $this->init();

        $collection = CreatedDietHelper::getMeals($this->data);

        foreach ($collection as $item) {
            $meal = [];

            $meal['meal_name'] = $item->getName();
            $meal['description'] = $item->getDescription();

            $meal['ingredients'] = [];
            $ingredients = $item->getIngredients()->getValues();
            foreach ($ingredients as $ingredient) {
                $product = $ingredient->getProduct();
                $ingredientData = [];
                $ingredientData['product_name'] = $product->getName();
                $ingredientData['product_quantity'] = $ingredient->getQuantity();

                $meal['ingredients'][] = $ingredientData;
            }

            $meal['statistics'] = [];
            $meal['statistics']['energy'] = $item->getEnergyKcal();
            $meal['statistics']['protein'] = $item->getProteinG();
            $meal['statistics']['carbohydrates'] = $item->getCarbohydratesG();
            $meal['statistics']['fat'] = $item->getFatG();

            $recipies[] = $meal;
        }

        return $recipies;
    }

    public function getRecipies()
    {
        $recipies = $this->prepare();

        return $recipies;
    }
}