<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\DietRules;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/generate_pdf", name="generate_pdf_")
 */
class GeneratePdfController extends Controller
{
    /**
     * @Route("/diet/{id}", name="diet")
     * @param DietRules $dietRule
     */
    public function generateDiet(DietRules $dietRule)
    {

    }
}
