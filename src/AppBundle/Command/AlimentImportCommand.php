<?php

namespace AppBundle\Command;

use AppBundle\Entity\Aliment;
use AppBundle\Service\CsvToArrayService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AlimentImportCommand extends ContainerAwareCommand
{
    const MAPPING = [
        'alim_code' => 'code',
        'alim_nom_fr' => 'name',
        'alim_grp_nom_fr' => 'groupName',
        'alim_ssgrp_nom_fr' => 'sousGroupName',
        'Eau (g/100g)' => 'eau',
        'Protéines brutes, N x 6.25 (g/100g)' => 'proteine',
        'Glucides (g/100g)' => 'glucide',
        'Lipides (g/100g)' => 'lipide',
        'Sucres (g/100g)' => 'sucre',
        'Amidon (g/100g)' => 'amidon',
    ];

    /** @var  CsvToArrayService */
    protected $csvToArrayService;

    /** @var  EntityManagerInterface */
    protected $em;

    /**
     * AlimentImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     * @param CsvToArrayService $csvToArrayService
     * @param null $name
     */
    public function __construct(
        EntityManagerInterface $em,
        CsvToArrayService $csvToArrayService,
        $name = null
    ) {
        parent::__construct($name);

        $this->csvToArrayService = $csvToArrayService;
        $this->em = $em;
    }

    /**
     * Command configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('app:ciqual')
            ->setDescription('Import Ciqual data from CSV file.');
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timer = new \DateTime();

        $output->writeln('Import starts : ' . $timer->format('d-m-Y G:i:s'));

        $this->resetTable();
        $this->import($input, $output);

        $timer = new \DateTime();

        $output->writeln('Import ends : ' . $timer->format('d-m-Y G:i:s'));
    }

    /**
     * Import CSV file into the database.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function import(InputInterface $input, OutputInterface $output)
    {
        $data = $this->get();

        if (empty($data)) {
            return;
        }

        $size = count($data);

        $progress = new ProgressBar($output, $size);
        $progress->start();

        foreach($data as $row) {
            $aliment = new Aliment();

            foreach (self::MAPPING as $key => $value) {
                if ($row[$key]) {

                    $method = 'set' . ucfirst($value);

                    if (method_exists(Aliment::class, $method)) {
                        $aliment->$method($row[$key]);
                    }
                }
            }

            $this->em->persist($aliment);
        }

        $this->em->flush();

        $progress->finish();
    }

    /**
     * Get converted data.
     *
     * @return array
     */
    protected function get(): array
    {
        $fileName = 'web/data.csv';

        $data = $this->csvToArrayService->convert($fileName, ';');

        return $data;
    }

    /**
     * Reset Aliment table.
     */
    private function resetTable()
    {
        $tool = new SchemaTool($this->em);
        $tool->dropSchema([$this->em->getClassMetadata(Aliment::class)]);
        $tool->updateSchema([$this->em->getClassMetadata(Aliment::class)]);
    }
}
