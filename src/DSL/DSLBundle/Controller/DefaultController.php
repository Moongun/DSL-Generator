<?php

namespace DSL\DSLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        if( $this->isGranted('IS_AUTHENTICATED_FULLY') ) {
            return $this->redirect('/start');
        }
        return $this->redirect("/login");
    }
    
    /**
     * @Route("/start", name="start")
     */
    public function startAction()
    {
        return $this->render('DSLBundle:Default:start.html.twig');
    }
    
    /**
     * @Route("thanks/{mealId}", name="thanks")
     * @Method({"GET", "POST"})
     */
    public function thanksAction($mealId)
    {
        $meal = $this->getDoctrine()->getRepository('DSLBundle:Meal')->find($mealId);
        
        return $this->render('DSLBundle:Default:thanks.html.twig', array(
            'meal' => $meal
        ));
    }
}
