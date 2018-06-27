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

        $em = $this->getDoctrine()->getManager();
        
        $createdDiet = $em->getRepository('DSLBundle:CreatedDiet')->findByDietRules($dietRuleId);
        $createdDietDate = $em->getRepository('DSLBundle:DietRules')
                ->find($dietRuleId)
                ->getCreatedDate();
        
        $dateWeek1 = date('Y-m-d H:i:s', strtotime($createdDietDate->format('Y-m-d H:i:s') . '+7 days'));
        $dateWeek2 = date('Y-m-d H:i:s', strtotime($createdDietDate->format('Y-m-d H:i:s') . '+14 days'));
        $dateWeek3 = date('Y-m-d H:i:s', strtotime($createdDietDate->format('Y-m-d H:i:s') . '+21 days'));
        $dateWeek4 = date('Y-m-d H:i:s', strtotime($createdDietDate->format('Y-m-d H:i:s') . '+28 days'));
        
        $ingredientsWeek1 = $em->getRepository(CreatedDiet::class)
                ->findIngredientsByRuleIdInGivenTime($dietRuleId, $createdDietDate, $dateWeek1);
        $ingredientsWeek2 = $em->getRepository(CreatedDiet::class)
                ->findIngredientsByRuleIdInGivenTime($dietRuleId, $dateWeek1, $dateWeek2);
        $ingredientsWeek3 = $em->getRepository(CreatedDiet::class)
                ->findIngredientsByRuleIdInGivenTime($dietRuleId, $dateWeek2, $dateWeek3);
        $ingredientsRest = $em->getRepository(CreatedDiet::class)
                ->findIngredientsByRuleIdInGivenTime($dietRuleId, $dateWeek3);
        
//        dump($ingredientsWeek1);


//        $mealIds = [];
//        $week1 = [];
//        $week2 = [];
//        $week3 = [];
//        $week4 = [];
//        $rest = [];
//        
//        foreach ($createdDiet as $k => $meal) {
//            $consumptionDate = $meal->getDate()->format('Y-m-d H:i:s');
//            switch($consumptionDate) {
//                case $consumptionDate <= $dateWeek1:
//                array_push($week1, $meal->getMeal()->getId());
//                break;
//                case $consumptionDate <= $dateWeek2:
//                array_push($week2, $meal->getMeal()->getId());
//                break;
//                case $consumptionDate <= $dateWeek3:
//                array_push($week3, $meal->getMeal()->getId());
//                break;
//                case $consumptionDate <= $dateWeek4:
//                array_push($week4, $meal->getMeal()->getId());
//                break;
//                case $consumptionDate > $dateWeek4:
//                array_push($rest, $meal->getMeal()->getId());
//                break;
//            }
//        };
////dump(array_count_values($week1));
////        dump($week1);
////        dump($week2);
////        dump($week3);
////        dump($week4);
////        dump($rest);
//
//        $ingredientWeek1=[];
//        $ingredientWeek2=[];
//        $ingredientWeek3=[];
//        $ingredientWeek4=[];
//        $ingredientRest=[];
//        
//        foreach($week1 as $mealId) {
//            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
//            $ingredientWeek1 = array_merge($ingredientWeek1, $mealIngredients);
//        }
//        foreach($week2 as $mealId) {
//            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
//            $ingredientWeek2 = array_merge($ingredientWeek2, $mealIngredients);
//        }
//        foreach($week3 as $mealId) {
//            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
//            $ingredientWeek3 = array_merge($ingredientWeek3, $mealIngredients);
//        }
//        foreach($week4 as $mealId) {
//            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
//            $ingredientWeek4 = array_merge($ingredientWeek4, $mealIngredients);
//        }
//        foreach($rest as $mealId) {
//            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
//            $ingredientRest = array_merge($ingredientRest, $mealIngredients);
//        }
//        dump($ingredientWeek1);
//        dump($ingredientWeek2);
//        dump($ingredientWeek3);
//        dump($ingredientWeek4);
//        dump($ingredientRest);

//        $occuranceWeek1 = array_count_values($ingredientWeek1);
//        dump($occuranceWeek1);
//        
//        $ingredients = [];
//        foreach ($mealIds as $mealId) {
//            $mealIngredients = $em->getRepository('DSLBundle:Ingredient')->findByMealId($mealId);
//            $ingredients[] = $mealIngredients;
//        };
////        dump($ingredients);

        return $this->render("shoppingList/index.html.twig", array(
                    'dietRuleId' => $dietRuleId,
//                    'ingredients' => $ingredients,
                    'firstWeek' => $ingredientsWeek1,
                    'secondWeek' => $ingredientsWeek2,
                    'thirdWeek' => $ingredientsWeek3,
                    'rest'  => $ingredientsRest
            
        ));
    }
}
