<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ingredient controller.
 *
 * @Route("ingredient")
 */
class IngredientController extends Controller {

    /**
     * Lists all ingredient entities.
     *
     * @Route("/", name="ingredient_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $ingredients = $em->getRepository('DSLBundle:Ingredient')->findAll();

        return $this->render('ingredient/index.html.twig', array(
                    'ingredients' => $ingredients,
        ));
    }

    /**
     * Creates a new ingredient entity.
     *
     * @Route("/new/{mealId}", name="ingredient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $mealId) {
        $meal = $this->getDoctrine()->getRepository('DSLBundle:Meal')->find($mealId);

        $ingredient = new Ingredient();
        $form = $this->createForm('DSL\DSLBundle\Form\IngredientType', $ingredient, array(
            'mealId' => $mealId,
            'meal' => $meal
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient->setMeal($meal);
            $ingredient->setMealId($mealId);

            $em = $this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush($ingredient);

            return $this->redirectToRoute('thanks', array(
                        'mealId' => $mealId,
            ));
        }

        return $this->render('ingredient/new.html.twig', array(
                    'ingredient' => $ingredient,
                    'form' => $form->createView(),
                    'mealName' => $meal->getName(),
        ));
    }

    /**
     * Finds and displays a ingredient entity.
     *
     * @Route("/{id}", name="ingredient_show")
     * @Method("GET")
     */
    public function showAction(Ingredient $ingredient) {
        $deleteForm = $this->createDeleteForm($ingredient);

        return $this->render('ingredient/show.html.twig', array(
                    'ingredient' => $ingredient,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ingredient entity.
     *
     * @Route("/{id}/edit", name="ingredient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ingredient $ingredient) {
        $deleteForm = $this->createDeleteForm($ingredient);
        $editForm = $this->createForm('DSL\DSLBundle\Form\IngredientType', $ingredient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ingredient_edit', array('id' => $ingredient->getId()));
        }

        return $this->render('ingredient/edit.html.twig', array(
                    'ingredient' => $ingredient,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ingredient entity.
     *
     * @Route("/{id}", name="ingredient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ingredient $ingredient) {
        $form = $this->createDeleteForm($ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ingredient);
            $em->flush($ingredient);
        }

        return $this->redirectToRoute('ingredient_index');
    }

    /**
     * Creates a form to delete a ingredient entity.
     *
     * @param Ingredient $ingredient The ingredient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ingredient $ingredient) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('ingredient_delete', array('id' => $ingredient->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
}
