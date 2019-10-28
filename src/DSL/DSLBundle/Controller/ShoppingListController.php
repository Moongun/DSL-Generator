<?php
namespace DSL\DSLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use DSL\DSLBundle\Entity\CreatedDiet;

/**
 * @Route("/shopping_list")
 */
class ShoppingListController extends Controller
{
    /**
     * @Route ("/{dietRuleId}", name="shopping_list")
     */
    public function indexAction($dietRuleId) {

        $createdDietRepository =$this->getDoctrine()->getRepository(CreatedDiet::class);

        $month = [
            [
                'title' => 'Tydzień pierwszy',
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 1, 7)
            ],
            [
                'title' => 'Tydzień drugi',
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 8, 14)
            ],
            [
                'title' => 'Tydzień trzeci',
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 15, 21)
            ],
            [
                'title' => 'Tydzień czwarty',
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 22, 28)
            ],
            [
                'title' => 'Reszta miesiąca',
                'ingredients' => $createdDietRepository->findIngredientsByRuleIdAndGivenDays($dietRuleId, 29)
            ]
        ];
        
        return $this->render("shoppingList/index.html.twig", array(
            'month' => $month
        ));
    }
}
