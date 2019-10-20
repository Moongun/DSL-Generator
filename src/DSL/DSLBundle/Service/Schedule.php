<?php


namespace DSL\DSLBundle\Service;


use DSL\DSLBundle\Entity\DietRules;
use Twig\Environment;

class Schedule
{
    private $pdfGenerator;
    private $statistics;
    private $recipies;
    private $twig;
    private $dietRule;
    private $html;

    /**
     * Schedule constructor.
     * @param PdfGenerator          $pdfGenerator   Pdf Generator
     * @param CreatedDietStatistics $statistics     Helper class for statistic
     * @param CreatedDietRecipies   $recipies       Helper class for recipies
     * @param Environment           $twig           Twig service
     */
    public function __construct(
        PdfGenerator $pdfGenerator,
        CreatedDietStatistics $statistics,
        CreatedDietRecipies $recipies,
        Environment $twig
    ) {
        $this->pdfGenerator = $pdfGenerator;
        $this->statistics = $statistics;
        $this->recipies = $recipies;
        $this->twig = $twig;
    }

    /**
     * Setter for DietRules.
     *
     * @param DietRules $dietRule DietRule
     *
     * @return $this
     */
    public function setDietRule (DietRules $dietRule) {
        $this->dietRule = $dietRule;

        return $this;
    }

    /**
     * Generates html.
     *
     * @return $this
     */
    public function generateHtml() {
        $diet = $this->dietRule->getCreatedDiet()->getValues();

        $this->html = $this->twig->render('generatePdf/pdf_for_diet.html.twig', [
            'requirements'  => $this->dietRule->getRequirements(),
            'statistics'    => $this->statistics->setData($diet)->getStatistics(),
            'grouped_meals' => CreatedDietHelper::groupMealsByWeekAndDay($diet),
            'recipies'      => $this->recipies->setData($diet)->getRecipies()
        ]);

        return $this;
    }

    /**
     * Make file from generated html.
     *
     * @throws \Exception
     */
    public function makeFile() {
        $generator = $this->pdfGenerator;
        $generator
            ->setFileName($this->getComponents())
            ->setPathToFile($generator->getFileName());

        if (!$this->html) {
            throw new \Exception('There is no generated html');
        }

        try {
            $this->pdfGenerator->generate($this->html, $generator->getPathToFile());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Getter for file name.
     *
     * @return mixed
     */
    public function getFileName() {
        return $this->pdfGenerator->getFileName();
    }

    /**
     * Getter for path to file.
     *
     * @return mixed
     */
    public function getPathToFile() {
        return $this->pdfGenerator->getPathToFile();
    }

    /**
     * Return array with unique data of DietRule.
     * 
     * @return array
     */
    private function getComponents() {
        return [
            $this->dietRule->getUser()->getUsername(),
            $this->dietRule->getId(),
            date('YmdHis')
        ];
    }
}