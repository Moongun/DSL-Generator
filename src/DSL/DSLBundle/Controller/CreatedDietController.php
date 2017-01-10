<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\CreatedDiet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Createddiet controller.
 *
 * @Route("createddiet")
 */
class CreatedDietController extends Controller
{
    /**
     * Lists all createdDiet entities.
     *
     * @Route("/", name="createddiet_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $createdDiets = $em->getRepository('DSLBundle:CreatedDiet')->findAll();

        return $this->render('createddiet/index.html.twig', array(
            'createdDiets' => $createdDiets,
        ));
    }

    /**
     * Creates a new createdDiet entity.
     *
     * @Route("/new", name="createddiet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
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
    public function showAction($dietRuleId)
    {
        //getting to repo of diet_rules
        $ruleRepo = $this->getDoctrine()->getRepository('DSLBundle:Diet_rules');
        
        //finding single meal
        $rule = $ruleRepo->findOneById($dietRuleId);
        
        
        $createdDiet = $rule->getCreatedDiet();
//        var_dump($createdDiet);
//        
        //creating new diet
        if(!count($createdDiet)){
           
            echo 'create';
            //geting to repo of createdDiet
            $repoCreate = $this->getDoctrine()->getRepository('DSLBundle:CreatedDiet');
            $repoCreate->calcDiet($dietRuleId);
            
            
            $createdDiet = $rule->getCreatedDiet();
       
        }
        
        $createdDiet = $rule->getCreatedDiet();
//        var_dump($createdDiet[149]->getMeal()->getId());
//        
        $repoMeal= $this->getDoctrine()->getRepository('DSLBundle:Meal');
//        
//        $meal=$repoMeal->findOneById($createdDiet[149]->getMeal()->getId());
//        var_dump($meal);
        
        $arrayWithMealIds=[];
        foreach($createdDiet as $meal){
            $mealId=$meal->getMeal()->getId();
            $arrayWithMealIds[]=$mealId;
        }
//        var_dump($arrayWithMealIds);
        
        $meals=[];
        foreach($arrayWithMealIds as $singleId){
            $meals[]=$repoMeal->findOneById($singleId);
        }
//        var_dump($meals);
        
        return $this->render('createddiet/show.html.twig', array('meals'=>$meals
        ));
    }

    /**
     * Displays a form to edit an existing createdDiet entity.
     *
     * @Route("/{id}/edit", name="createddiet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CreatedDiet $createdDiet)
    {
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
     * @Route("/{id}", name="createddiet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CreatedDiet $createdDiet)
    {
        $form = $this->createDeleteForm($createdDiet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($createdDiet);
            $em->flush($createdDiet);
        }

        return $this->redirectToRoute('createddiet_index');
    }

    /**
     * Creates a form to delete a createdDiet entity.
     *
     * @param CreatedDiet $createdDiet The createdDiet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CreatedDiet $createdDiet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('createddiet_delete', array('id' => $createdDiet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
