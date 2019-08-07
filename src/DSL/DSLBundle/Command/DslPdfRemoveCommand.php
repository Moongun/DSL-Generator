<?php

namespace DSL\DSLBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use DSL\DSLBundle\Repository\FilePathRepository;
use FOS\UserBundle\Model\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DslPdfRemoveCommand extends Command
{
    private $filePathRepository;
    private $em;
    private $pdfDir;

    public function __construct(FilePathRepository $filePathRepository, EntityManagerInterface $em, string $pdfDir)
    {
        $this->filePathRepository = $filePathRepository;
        $this->em = $em;
        $this->pdfDir = $pdfDir;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('dsl:pdf:remove')
            ->setDescription('Removes pdf files and clear datatable connected with those files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $filePathRepository = $this->filePathRepository;
        $em = $this->em;

        $pdfs = glob($this->pdfDir.'*.pdf');


        $counter = 0;

        foreach($pdfs as $pdf) {
            $row = $filePathRepository->findOneByPath($pdf);
            if ($row) {
                try {
                    $em->remove($row);
                    $em->flush();
                    unlink($pdf);

                    $output->writeln(sprintf('%s removed', $pdf));
                    $counter++;
                } catch (\Exception $e) {
                    $output->writeln($e->getMessage());
                }
            }
        }

        $output->writeln(sprintf('removed: %s', $counter));
    }
}
