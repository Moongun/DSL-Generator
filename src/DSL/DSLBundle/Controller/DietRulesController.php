<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\DietRules;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Diet_rule controller.
 *
 * @Route("diet_rules")
 */
class DietRulesController extends Controller
{
    /**
     * Lists all DietRule entities.
     *
     * @Route("/", name="diet_rules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();

//        $dietsRepo = $em->getRepository('DSLBundle:CreatedDiet')->findAll();
        $diets = $em->getRepository('DSLBundle:DietRules')->findByUser($user);
//        $chunkedDiets = array_chunk($dietsRepo, 150);
//        $diets = [];
//        foreach ($chunkedDiets as $singleDiet) {
//            $date = $singleDiet[0]->getDate();
//            $dietRule = $singleDiet[0]->getDietRules()->getId();
//            array_push($singleDiet, $date, $dietRule);
//            $diets[] = $singleDiet;
//        }
        return $this->render('dietRules/index.html.twig', array(
                    'diets' => $diets,
        ));
    }

    /**
     * Creates a new diet_rule entity.
     *
     * @Route("/new", name="diet_rules_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dietRule = new DietRules();
        $form = $this->createForm('DSL\DSLBundle\Form\DietRulesType', $dietRule);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dietRule->setUser($this->getUser());
            $em->persist($dietRule);
            $em->flush($dietRule);
            return $this->redirectToRoute('createddiet_show', array('dietRuleId' => $dietRule->getId()));
        }

        return $this->render('dietRules/new.html.twig', array(
            'diet_rule' => $dietRule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a diet_rule entity.
     *
     * @Route("/{id}", name="diet_rules_show")
     * @Method("GET")
     */
    public function showAction($dietRule)
    {
        $deleteForm = $this->createDeleteForm($dietRule);

        return $this->render('dietRules/show.html.twig', array(
            'diet_rule' => $dietRule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing diet_rule entity.
     *
     * @Route("/{id}/edit", name="diet_rules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $dietRule)
    {
        $deleteForm = $this->createDeleteForm($dietRule);
        $editForm = $this->createForm('DSL\DSLBundle\Form\dietRulesType', $dietRule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diet_rules_edit', array('id' => $dietRule->getId()));
        }

        return $this->render('dietRules/edit.html.twig', array(
            'diet_rule' => $dietRule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a diet_rule entity.
     *
     * @Route("/{id}", name="diet_rules_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $dietRule)
    {
        $form = $this->createDeleteForm($dietRule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dietRule);
            $em->flush($dietRule);
        }

        return $this->redirectToRoute('diet_rules_index');
    }

    /**
     * Creates a form to delete a diet_rule entity.
     *
     * @param diet_rules $diet_rule The diet_rule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($dietRule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diet_rules_delete', array('id' => $dietRule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
