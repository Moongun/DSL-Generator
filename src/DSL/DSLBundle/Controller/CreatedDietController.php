<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\CreatedDiet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use DSL\DSLBundle\Entity\Meal;

/**
 * Createddiet controller.
 *
 * @Route("createddiet")
 */
class CreatedDietController extends Controller {

    /**
     * Creates a new createdDiet entity.
     *
     * @Route("/new", name="createddiet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $createdDiet = new Createddiet();
        $form = $this->createForm('DSL\DSLBundle\Form\CreatedDietType', $createdDiet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($createdDiet);
            $em->flush($createdDiet);

            return $this->redirectToRoute('createddiet_show', array('id' => $createdDiet->getId()));
        }

        return $this->render('createddiet/new.html.twig', array(
                    'createdDiet' => $createdDiet,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a createdDiet entity.
     *
     * @Route("/{dietRuleId}", name="createddiet_show")
     * @Method("GET")
     */
    public function showAction($dietRuleId) {
        //getting to repo of diet_rules
        $ruleRepo = $this->getDoctrine()->getRepository('DSLBundle:DietRules');
        $user = $this->getUser();

        //finding single meal
        $rule = $ruleRepo->findOneById($dietRuleId);

        $createdDiet = $rule->getCreatedDiet();
//        
        //creating new diet
        if (!count($createdDiet)) {
            $repoCreate = $this->getDoctrine()->getRepository('DSLBundle:CreatedDiet');
            $repoCreate->calcDiet($dietRuleId, $user);

            $createdDiet = $rule->getCreatedDiet();
        }

        $repoMeal = $this->getDoctrine()->getRepository('DSLBundle:Meal');

        $arrayWithMealIds = [];
        foreach ($createdDiet as $meal) {
            $mealId = $meal->getMeal()->getId();
            $arrayWithMealIds[] = $mealId;
        }

        $meals = [];
        $energy = 0;
        $proteins = 0;
        $fats = 0;
        $carbohydrates = 0;
        $costs = 0;
        $firstWeek = 0;
        $secondWeek = 0;
        $thirdWeek = 0;
        $fourthWeek = 0;
        $restOfMonth = 0;
        $counter = 0;
        foreach ($arrayWithMealIds as $singleId) {
            $counter++;

            $meal = $repoMeal->findOneById($singleId);
            $meals[] = $meal;

            $energy = $energy + $meal->getEnergyValueKcal();
            $proteins = $proteins + $meal->getProteinG();
            $fats = $fats + $meal->getFatG();
            $carbohydrates = $carbohydrates + $meal->getCarbohydratesG();
            $costs = $costs + $meal->getAverageCost();

            switch ($counter) {
                case $counter <= 35;
                    $firstWeek = $firstWeek + $meal->getAverageCost();
                    break;
                case $counter <= 70;
                    $secondWeek = $secondWeek + $meal->getAverageCost();
                    break;
                case $counter <= 105;
                    $thirdWeek = $thirdWeek + $meal->getAverageCost();
                    break;
                case $counter <= 140;
                    $fourthWeek = $fourthWeek + $meal->getAverageCost();
                    break;
                case $counter > 140;
                    $restOfMonth = $restOfMonth + $meal->getAverageCost();
                    break;
            };
        };
        
        $energy = $energy / 30;
        $proteins = $proteins / 30;
        $fats = $fats / 30;
        $carbohydrates = $carbohydrates / 30;

        return $this->render('createddiet/show.html.twig', array(
                    'meals' => $meals,
                    'energy' => $energy,
                    'proteins' => $proteins,
                    'fats' => $fats,
                    'carbohydrates' => $carbohydrates,
                    'costs' => $costs,
                    'firstWeek' => $firstWeek,
                    'secondWeek' => $secondWeek,
                    'thirdWeek' => $thirdWeek,
                    'fourthWeek' => $fourthWeek,
                    'restOfMonth' => $restOfMonth,
                    'dietRuleId' =>$dietRuleId
        ));
    }

    /**
     * Displays a form to edit an existing createdDiet entity.
     *
     * @Route("/{id}/edit", name="createddiet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CreatedDiet $createdDiet) {
        $deleteForm = $this->createDeleteForm($createdDiet);
        $editForm = $this->createForm('DSL\DSLBundle\Form\CreatedDietType', $createdDiet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('createddiet_edit', array('id' => $createdDiet->getId()));
        }

        return $this->render('createddiet/edit.html.twig', array(
                    'createdDiet' => $createdDiet,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a createdDiet entity.
     *
     * @Route("/del/{id}", name="createddiet_delete")
     * 
     */
    public function deleteAction(Request $request, $id) {
//        $repo = $this->getDoctrine()->getRepository('DSLBundle:CreatedDiet');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT diet FROM DSLBundle:CreatedDiet diet WHERE diet.dietRules=$id");
        $results = $query->getResult();
        foreach ($results as $result) {
            $em->remove($result);
            $em->flush($result);
        }

//        $form = $this->createDeleteForm($createdDiet);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
////            $em = $this->getDoctrine()->getManager();
//            $em->remove($createdDiet);
//            $em->flush($createdDiet);
//        }

        return $this->redirectToRoute('createddiet_index');
    }

    /**
     * Creates a form to delete a createdDiet entity.
     *
     * @param CreatedDiet $createdDiet The createdDiet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CreatedDiet $createdDiet) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('createddiet_delete', array('id' => $createdDiet->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * @Route ("/delete", name="delete_diet")
     */
    public function deleteDietAction() {
        
    }

}
