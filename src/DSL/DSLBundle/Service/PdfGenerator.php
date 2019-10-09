<?php

namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Entity\User;
use Knp\Snappy\Pdf;

class PdfGenerator
{
    private $knpSnappyPdf;
    private $pdfDir;

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
    public function createPathToFile(string $fileName)
    {
        return $this->pdfDir . $fileName;
    }

    /**
     * Generate pdf file.
     *
     * @param string $html Html
     * @param $pathToFile Path to file
     */
    public function generate(string $html, $pathToFile)
    {
        $options = ['page-width' => 595];

        return $this->knpSnappyPdf->generateFromHtml($html, $pathToFile, $options);
    }

    /**
     * Create file name.
     *
     * @param array $components Array with unique diet data
     * @param string $extension Extension
     * @return string
     */
    public function createFileName(array $components, string $extension = 'pdf')
    {
        return md5(implode('_',$components)) . '.' . $extension;
    }
}
