<?php

namespace AppBundle\Command;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\IngredientFamily;
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

        $currentIngredientFamilyId = null;
        $IngredientFamily = null;

        foreach ($CSVReader as $line)
        {
            // if the ingredient's family happen for the first time we persist it.
            if ($line['ORIGGPCD'] !== $currentIngredientFamilyId)
            {
                if (isset($IngredientFamily))
                {
                    $this->em->persist($IngredientFamily);
                    $this->em->flush();
                }

                $IngredientFamily = new IngredientFamily($line['ORIGGPFR']);
                $currentIngredientFamilyId = $line['ORIGGPCD'];
            }

            $ingredientName = $line['ORIGFDNM'];
            $energies = [];
            $nutrients = [];

            foreach ($line as $key => $value) {
                // clean the blank spaces
                $value = trim($value);

                // if it's an energy, we are verifying if it prefixed by Energie, ...
                if (preg_match('/^Energie, (.+?)$/', $key, $matches))
                {
                    $energies[$matches[1]] = $value;
                }

                // others are nutrients
                $nutrients[$key] = $value;
            }

            // now persist our ingredients
            $ingredient = new Ingredient($ingredientName, $energies, $nutrients, $IngredientFamily);
            // adding ingredient to the collection
            $IngredientFamily->addIngredient($ingredient);
        }

        $io->success("The CVS has been successfully saved into the database");
    }

}
