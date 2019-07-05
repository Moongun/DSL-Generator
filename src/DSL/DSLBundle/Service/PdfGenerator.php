<?php

namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Entity\User;
use Knp\Snappy\Pdf;

class PdfGenerator
{
    private $knpSnappyPdf;
    private $pdfDir;

    public function __construct(Pdf $knpSnappyPdf, string $pdfDir)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->pdfDir = $pdfDir;
    }

    public function createPathToFile(array $components, string $extension = 'pdf')
    {
        $pathToFile = implode('_',$components) . '.' . $extension;

        return $this->pdfDir . $pathToFile;
    }

    public function generate(string $html, $pathToFile)
    {
        return $this->knpSnappyPdf->generateFromHtml($html, $pathToFile);
    }


}