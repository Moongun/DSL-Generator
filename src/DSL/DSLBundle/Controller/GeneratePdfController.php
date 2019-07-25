<?php

namespace DSL\DSLBundle\Controller;

use DSL\DSLBundle\Entity\DietRules;
use DSL\DSLBundle\Entity\FilePath;
use DSL\DSLBundle\Entity\User;
use DSL\DSLBundle\Repository\FilePathRepository;
use PHPUnit\Runner\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/generate_pdf", name="generate_pdf_")
 */
class GeneratePdfController extends Controller
{
    /**
     * @Route("/diet/{id}", name="diet")
     * @param DietRules $dietRule
     */
    public function pdfForDietAction(DietRules $dietRule)
    {
        $user = $this->getUser();

        $filePathRepository = $this->getDoctrine()->getRepository(FilePath::class);
        $filePath = $filePathRepository->findFilePathByUserIdAndDietRuleId($user->getId(), $dietRule->getId());

        if ($filePath) {
            return $this->redirect('/pdf/' . $filePath->getName());
        }

        //TODO przerzucić logikę do serwisu
        $pdfGenerator = $this->get('service.pdf_generator');

        $components = [
            $dietRule->getUser()->getUsername(),
            $dietRule->getId(),
            date('YmdHis')
        ];

        $fileName = $pdfGenerator->createFileName($components);
        $pathToFile = $pdfGenerator->createPathToFile($fileName);





        $statisticsService = $this->get('service.created_diet_statistics');
        $diet = $dietRule->getCreatedDiet()->getValues();
        $statistics = $statisticsService->setData($diet)->getStatistics();

        $recipiesService = $this->get('service.created_diet_recipies');
        $recipies = $recipiesService->setData($diet)->getRecipies();

        $dietHelper = $this->get('service.created_diet_helper');
//        $meals = $dietHelper::getMeals($diet);
        $groupedMeals = $dietHelper::groupMealsByWeekAndDay($diet);
//dump($statistics, $groupedMeals);
        $html = $this->renderView('generatePdf/pdf_for_diet.html.twig', [
            'requirements'  => $dietRule->getRequirements(),
            'statistics'    => $statistics,
            'grouped_meals' => $groupedMeals,
            'recipies'      => $recipies
        ]);

        try {
            $pdfGenerator->generate($html, $pathToFile);
            $filePath = $this->saveFilePath($fileName, $pathToFile, $dietRule, $user);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $this->redirect('/pdf/' . $filePath->getName());
    }

    private function saveFilePath(string $fileName, string $path, DietRules $dietRule,User $user) {
        $dateTime = new \DateTime();
        $dateTime->format('Y-m-d H:i:s');

        $filePath = new FilePath();
        $filePath
            ->setName($fileName)
            ->setPath($path)
            ->setDietRule($dietRule)
            ->setUser($user)
            ->setCreatedAt($dateTime);

        $em = $this->getDoctrine()->getManager();
        $em->persist($filePath);
            $em->flush();

        return $filePath;
    }
}
