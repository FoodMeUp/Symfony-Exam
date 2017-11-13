<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppCsvImportCommand extends ContainerAwareCommand
{
    /* @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('app:csv:import')
            ->setDescription('Imports CSV file to the database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input,$output);
        $io->title("Trying to import the CSV file to the database ...");

        // read the csv
        $path = '%kernel.app_root_dir%/../src/AppBundle/Data/csv/Table_Ciqual_2016.csv';
        $content = file_get_contents($path);
        $CSVReader = Reader::createFromString($content);
        $CSVReader->setDelimiter(";");
        $CSVReader->setHeaderOffset(0);

        foreach ($CSVReader as $row)
        {

        }

        $io->success("The CVS has been successfully saved into the database");
    }

}
