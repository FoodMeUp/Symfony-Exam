<?php

namespace AppBundle\Command;

use AppBundle\Entity\Ingredients;
use AppBundle\Entity\IngredientsCategories;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImportCommand extends ContainerAwareCommand
{

    private $em;
    private $container;

    function __construct(EntityManager $em, ContainerInterface $container)
    {
        parent::__construct();
        $this->em = $em;
        $this->container = $container;
    }

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('import:csv')
            ->setDescription('Import ingredients from CSV file to database')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'The CSV file is required to import data.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $data = $this->getData($input->getArgument('file'));

        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln(
            '<comment>Start : '.$now->format('d-m-Y G:i:s').' ---</comment>'
        );

        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output, $data);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln(
            '<comment>End : '.$now->format('d-m-Y G:i:s').' ---</comment>'
        );
    }

    private function getData($file) {
        $serializer = $this->container->get('serializer');

        $data = $serializer->decode(
            file_get_contents($file),
            'csv'
        );

        return $data;
    }

    protected function import(InputInterface $input, OutputInterface $output, Array $data)
    {
        // Getting doctrine manager
        $em = $this->em;

        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 20;
        $i = 0;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        foreach ($data as $row) {
            if ($i == 20) {
                // Detaches all objects from Doctrine for memory save
                $em->clear();
                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(
                    ' of ingredients imported ... | '.$now->format(
                        'd-m-Y G:i:s'
                    )
                );
                $i = 0;
            }

            $ingredient = array_slice($row, 0, 4);
            $components = array_slice($row, 4);

            $ingredientE = new Ingredients();
            $ingredientE->setOrigfdcd($ingredient['ORIGFDCD']);
            $ingredientE->setOrigfdnm($ingredient['ORIGFDNM']);

            $category = $em->getRepository('AppBundle:IngredientsCategories')
                ->findOneBy(array('origgpcd' => $row['ORIGGPCD']));

            if (!empty($category)) {
                $ingredientE->setCategory($category);
            }
            else {
                $category = new IngredientsCategories();

                $category->setOriggpcd($row['ORIGGPCD']);
                $category->setOriggpfr($row['ORIGGPFR']);
                $em->persist($category);
                $em->flush($category);
                $ingredientE->setCategory($category);
            }


            $ingredientE->setComponents(json_encode($components));

            $em->persist($ingredientE);
            $em->flush();
            $i++;
        }
    }
}