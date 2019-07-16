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

    public function createPathToFile(string $fileName)
    {
        return $this->pdfDir . $fileName;
    }

    public function generate(string $html, $pathToFile)
    {
        return $this->knpSnappyPdf->generateFromHtml($html, $pathToFile);
    }

    public function createFileName(array $components, string $extension = 'pdf')
    {
        return md5(implode('_',$components)) . '.' . $extension;
    }
}
