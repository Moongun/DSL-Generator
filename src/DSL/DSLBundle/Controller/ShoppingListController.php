<?php
namespace DSL\DSLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use DSL\DSLBundle\Entity\CreatedDiet;

/**
 * @Route("/shopping_list", name="shopping_list_")
 */
class ShoppingListController extends Controller
{
    /**
     * Show shopping list for given diet Rule.
     *
     * @Route ("/{dietRuleId}", name="index")
     */
    public function indexAction(int $dietRuleId)
    {
        $createdDietRepository =$this->getDoctrine()->getRepository(CreatedDiet::class);

        $month = [
            [
                'title' => 'Tydzień pierwszy',
                'number' => 1,
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 1, 7)
            ],
            [
                'title' => 'Tydzień drugi',
                'number' => 2,
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 8, 14)
            ],
            [
                'title' => 'Tydzień trzeci',
                'number' => 3,
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 15, 21)
            ],
            [
                'title' => 'Tydzień czwarty',
                'number' => 4,
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 22, 28)
            ],
            [
                'title' => 'Reszta miesiąca',
                'number' => 5,
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 29)
            ]
        ];
        
        return $this->render("shoppingList/index.html.twig", array(
            'month' => $month,
            'diet_rule_id' => $dietRuleId
        ));
    }
}
