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
<<<<<<< HEAD
    public function pdfForDietAction(DietRules $dietRule)
    {
        //TODO przerzucić logikę do serwisu
        $pdfGenerator = $this->get('service.pdf_generator');

        $components = [
            $dietRule->getUser()->getUsername(),
            $dietRule->getCreatedDate()->format('Ymd_his')
        ];

        $pathToFile = $pdfGenerator->createPathToFile($components);

        $statisticsService = $this->get('service.created_diet_statistics');
        $diet = $dietRule->getCreatedDiet()->getValues();
        $statistics = $statisticsService->setData($diet)->getStatistics();

        $dietHelper = $this->get('service.created_diet_helper');
        $meals = $dietHelper::getMeals($diet);
        $groupedMeals = $dietHelper::groupMealsByWeekAndDay($diet);

        $html = $this->renderView('generatePdf/pdf_for_diet.html.twig', []);

        $pdfGenerator->generate($html, $pathToFile);

//        TODO tymczas - trzeba inaczej
        $explode = explode('/', $pathToFile);

        return $this->redirect('/pdf/' . array_pop($explode));
=======
    public function generateDiet(DietRules $dietRule)
    {

>>>>>>> add_pdf_generation
    }
}
