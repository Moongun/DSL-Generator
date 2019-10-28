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
     * Redirect to pdf of diet.
     *
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

        $schedule = $this->get('service.schedule');

        try {
            $schedule
                ->setDietRule($dietRule)
                ->generateHtml()
                ->makeFile();

            $filePath = $this->saveFilePath($schedule->getFileName(), $schedule->getPathToFile(), $dietRule);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $this->redirect('/pdf/' . $filePath->getName());
    }

    /**
     * Redirect to pdf of shopping list.
     *
     * @Route("shopping_list/{id}/{week}", name="shopping_list")
     * @param DietRules $dietRule
     * @param int       $Week
     */
    public function pdfForShoppingListAction(DietRules $dietRule, int $week)
    {
        dump($dietRule, $week);

    }

    /**
     * Saving FilePath Entity
     * TODO create command
     *
     * @param string    $fileName   FileName
     * @param string    $path       Path to File
     * @param DietRules $dietRule   DietRule
     *
     * @return FilePath
     * @throws \Exception
     */
    private function saveFilePath(string $fileName, string $path, DietRules $dietRule) {
        $dateTime = new \DateTime();
        $dateTime->format('Y-m-d H:i:s');

        $filePath = new FilePath();
        $filePath
            ->setName($fileName)
            ->setPath($path)
            ->setDietRule($dietRule)
            ->setUser($dietRule->getUser())
            ->setCreatedAt($dateTime);

        $em = $this->getDoctrine()->getManager();
        $em->persist($filePath);
            $em->flush();

        return $filePath;
    }
}
