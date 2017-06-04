<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\Diet_rules;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Diet_rule controller.
 *
 * @Route("diet_rules")
 */
class Diet_rulesController extends Controller
{
    /**
     * Lists all diet_rule entities.
     *
     * @Route("/", name="diet_rules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();

        $diet_rules = $this->getDoctrine()->getRepository('DSLBundle:Diet_rules')->findAll();

        return $this->render('diet_rules/index.html.twig', array(
            'diet_rules' => $diet_rules,
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
        $diet_rule = new Diet_rules();
        $form = $this->createForm('DSL\DSLBundle\Form\diet_rulesType', $diet_rule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diet_rule);
            $em->flush($diet_rule);
//            echo"tak jest";
//            dump($diet_rule->getId());
            return $this->redirectToRoute('createddiet_show', array('dietRuleId' => $diet_rule->getId()));
        }

        return $this->render('diet_rules/new.html.twig', array(
            'diet_rule' => $diet_rule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a diet_rule entity.
     *
     * @Route("/{id}", name="diet_rules_show")
     * @Method("GET")
     */
    public function showAction(diet_rules $diet_rule)
    {
        $deleteForm = $this->createDeleteForm($diet_rule);

        return $this->render('diet_rules/show.html.twig', array(
            'diet_rule' => $diet_rule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing diet_rule entity.
     *
     * @Route("/{id}/edit", name="diet_rules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, diet_rules $diet_rule)
    {
        $deleteForm = $this->createDeleteForm($diet_rule);
        $editForm = $this->createForm('DSL\DSLBundle\Form\diet_rulesType', $diet_rule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diet_rules_edit', array('id' => $diet_rule->getId()));
        }

        return $this->render('diet_rules/edit.html.twig', array(
            'diet_rule' => $diet_rule,
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
    public function deleteAction(Request $request, diet_rules $diet_rule)
    {
        $form = $this->createDeleteForm($diet_rule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($diet_rule);
            $em->flush($diet_rule);
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
    private function createDeleteForm(diet_rules $diet_rule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diet_rules_delete', array('id' => $diet_rule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
