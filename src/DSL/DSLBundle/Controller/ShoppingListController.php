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
        
        $month = [
            ['title' => 'Tydzień pierwszy', 'ingredients' => $ingredientsWeek1],
            ['title' => 'Tydzień drugi', 'ingredients' => $ingredientsWeek2],
            ['title' => 'Tydzień trzeci', 'ingredients' => $ingredientsWeek3],
            ['title' => 'Reszta miesiąca', 'ingredients' => $ingredientsRest]
        ];
        
        return $this->render("shoppingList/index.html.twig", array(
                    'dietRuleId' => $dietRuleId,
                    'month' => $month
            
        ));
    }
}
