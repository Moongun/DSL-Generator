<?php

namespace DSL\DSLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('DSLBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/start", name="start")
     */
    public function startAction()
    {
        return $this->render('DSLBundle:Default:start.html.twig');
    }
    /**
     * @Route("thanks", name="thanks")
     */
    public function thanksAction()
    {
        return $this->render('DSLBundle:Default:thanks.html.twig');
    }
}
