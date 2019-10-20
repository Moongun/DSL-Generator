<?php

namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Entity\User;
use Knp\Snappy\Pdf;

class PdfGenerator
{
    private $knpSnappyPdf;
    private $pdfDir;
    private $fileName;
    private $pathToFile;

    /**
     * PdfGenerator constructor.
     *
     * @param Pdf $knpSnappyPdf SnappyPDF
     * @param string $pdfDir    Path to pdf directory
     */
    public function __construct(Pdf $knpSnappyPdf, string $pdfDir)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->pdfDir = $pdfDir;
    }

    /**
     * Create absolute path for file.
     *
     * @param string $fileName Filename
     *
     * @return string
     */
    public function setPathToFile(string $fileName)
    {
        $this->pathToFile = $this->pdfDir . $fileName;

        return $this;
    }

    public function getPathToFile() {
        return $this->pathToFile;
    }

    /**
     * Set file name.
     *
     * @param array $components Array with unique diet data
     * @return string
     */
    public function setFileName(array $components)
    {
        $this->fileName = md5(implode('_',$components)) . '.pdf';

        return $this;
    }

    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Generate pdf file.
     *
     * @param string $html Html
     * @param $pathToFile Path to file
     */
    public function generate(string $html, $options = [])
    {
        $options = ['page-width' => 595];

        return $this->knpSnappyPdf->generateFromHtml($html, $this->pathToFile, $options);
    }
}
