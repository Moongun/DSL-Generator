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
use Symfony\Component\Console\Style\SymfonyStyle;

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
            ->addArgument('dietRuleId', InputArgument::OPTIONAL, 'Id of diet rule to remove');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dietRuleId = $input->getArgument('dietRuleId');
        $io = new SymfonyStyle($input, $output);

        $filePathRepository = $this->filePathRepository;
        $em = $this->em;
        $counterDb = 0;
        $counterFiles = 0;

        if ($dietRuleId) {
            $filePath = $filePathRepository->findOneBy(['dietRule' => $dietRuleId]);
            if (!$filePath) {
                return $io->error(sprintf('There is no FilePath for diet_rule_id = %s', $dietRuleId));
            }
            $path = $filePath->getPath();
            try {
                $em->remove($filePath);
                $em->flush();
                $counterDb++;
                $io->writeln(sprintf('%s removed from Database', $path));

                unlink($path);
                $counterFiles++;
                $output->writeln(sprintf('%s removed from FileFirectory', $path));
            } catch (\Exception $e) {
                return $io->error($e->getMessage());
            }
        } else {
            try {
                $filePaths = $filePathRepository->findAll();
                foreach ($filePaths as $filePath) {
                    $em->remove($filePath);
                    $em->flush();
                    $counterDb++;
                }

                $pdfs = glob($this->pdfDir.'*.pdf');
                foreach ($pdfs as $pdf) {
                    unlink($pdf);
                    $counterFiles++;
                }
            }catch (\Exception $e) {
                return $io->error($e->getMessage());
            }
        }

        $summary = [
            sprintf('removed from Database: %s', $counterDb),
            sprintf('removed from File directory: %s', $counterFiles)
        ];
        return $io->success($summary);
    }
}
