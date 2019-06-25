<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\CreatedDiet;
use DSL\DSLBundle\Entity\DietRules;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $createdDiet = new CreatedDiet();
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
     * Generate diet
     *
     * @Route("/generate/{id}", name="createddiet_generate")
     */
    public function generateAction(DietRules $dietRule) {
        $createdDietRepository = $this->getDoctrine()->getRepository('DSLBundle:CreatedDiet');
        $createdDiet = $createdDietRepository->findBy(['dietRules' => $dietRule]);

        if($createdDiet) {
            $this->redirectToRoute('createddiet_show', ['dietRuleId' => $dietRule->getId()]);
        }

        $dietGenerator = $this->get('service.diet_generator');
        $createdDiet = $dietGenerator->generate($dietRule);

        return $this->render('createddiet\generate.html.twig', [
            'diet' => $createdDiet,
            'dietRule' => $dietRule
        ]);
    }

    /**
     * Save diet.
     *
     * @Route("/save/", options={"expose"=true}, name="createddiet_save")
     */
    public function saveAction(Request $request) {
        $ruleId = (int) $request->request->get('rule');

        $em = $this->getDoctrine()->getManager();
        $dietRulesRepository = $this->getDoctrine()->getRepository('DSLBundle:DietRules');
        $dietRule = $dietRulesRepository->find($ruleId);
        $createdDietRepository = $this->getDoctrine()->getRepository('DSLBundle:CreatedDiet');
        $createdDiet = $createdDietRepository->findBy(['dietRules' => $dietRule]);
        if ($createdDiet) {
            throw new \Exception(sprintf('There is created diet for this rule (id = %s)', $ruleId));
        }

        $diet = $request->request->get('diet');
        $mealRepository = $this->getDoctrine()->getRepository('DSLBundle:Meal');

        foreach($diet as $day => $mealIds) {
            foreach($mealIds as $mealId){
                $meal = $mealRepository->find((int) $mealId);

                $createdDiet = new CreatedDiet();
                $createdDiet->setDietRules($dietRule)
                    ->setMeal($meal)
                    ->setDay((int) $day);

                $em->persist($createdDiet);
            }
        }
        $em->flush();

        return new JsonResponse('ok', 200);
    }

    /**
     * Finds and displays a createdDiet entity.
     *
     * @Route("/{dietRule}", options={"expose"=true}, name="createddiet_show")
     * @Method("GET")
     */
    public function showAction(DietRules $dietRule) {
        if ($dietRule->getUser() !== $this->getUser()) {
            throw new \Exception(sprintf('This diet (rule_id = %s) does not belong to this user.', $dietRule->getId()));
        }

        $createdDiet = $dietRule->getCreatedDiet();

        if (!count($createdDiet)) {
            throw $this->createNotFoundException(sprintf('There is no created diet for given rule (rule_id = %s)', $dietRule->getId()));
        }

        $mealRepository = $this->getDoctrine()->getRepository('DSLBundle:Meal');

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

            $meal = $mealRepository->findOneById($singleId);
            $meals[] = $meal;

            $energy = $energy + $meal->getEnergyKcal();
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
                    'dietRuleId' =>$dietRule->getId()
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
}
