<?php
namespace DSL\DSLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopping_list")
 */
class ShoppingListController extends Controller
{
    /**
     * @Route ("/{dietRuleId}", name="shopping_list")
     */
    public function indexAction($dietRuleId) {

        $em = $this->getDoctrine()->getManager();
        $createdDiet = $em->getRepository('DSLBundle:CreatedDiet')->findByDietRules($dietRuleId);

        $mealIds = [];
        foreach ($createdDiet as $meal) {
            array_push($mealIds, $meal->getMeal()->getId());
        };
//        dump($mealIds);

        $ingredients = [];
        foreach ($mealIds as $mealId) {
            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
            $ingredients[] = $mealIngredients;
        };
//        dump($ingredients);

        return $this->render("ingredient/shoppingList.html.twig", array(
                    'dietRuleId' => $dietRuleId,
                    'ingredients' => $ingredients
        ));
    }
}
