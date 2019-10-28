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
        $weeks = [
            1 => 'shopping_list.week.one',
            2 => 'shopping_list.week.two',
            3 => 'shopping_list.week.three',
            4 => 'shopping_list.week.four',
            5 => 'shopping_list.week.five',
        ];

        $helper = $this->get('service.shopping_list_helper');
        $month = [];
        array_walk($weeks, function ($title, $number) use (&$month, $dietRuleId, $helper) {
            $week = [
                'title' => $title,
                'number' => $number,
                'ingredients' => $helper->getShoppingListByWeek($dietRuleId, $number)
            ];
            $month[] = $week;
        });


        return $this->render("shoppingList/index.html.twig", array(
            'month' => $month,
            'diet_rule_id' => $dietRuleId
        ));
    }
}
