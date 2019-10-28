<?php

namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Repository\CreatedDietRepository;

class ShoppingListHelper
{
    private $createdDietRepository;

    public function __construct(CreatedDietRepository $createdDietRepository)
    {
        $this->createdDietRepository = $createdDietRepository;
    }

    public function getShoppingListByWeek(int $dietRuleId, int $week)
    {
        switch ($week) {
            case 1:
                $ingredients = $this->createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 1, 7);
                break;
            case 2:
                $ingredients = $this->createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 8, 14);
                break;
            case 3:
                $ingredients = $this->createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 15, 21);
                break;
            case 4:
                $ingredients = $this->createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 22, 28);
                break;
            case 5:
                $ingredients = $this->createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 29);
                break;
            default:
                throw new \Exception('You can choose between 1-5 week');
        };

        return $ingredients;

    }
}
