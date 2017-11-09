<?php
namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use App\CsvReader;

use App\Entity\Ingredient;
use App\Entity\IngredientFamily;

use App\Repository\IngredientRepository;
use App\Repository\IngredientFamilyRepository;

class ImportCommand extends Command
{
    /** @var CsvReader */
    private $reader;

    /** @var IngredientFamilyRepository */
    private $familyRepo;

    public function __construct(CsvReader $reader, IngredientFamilyRepository $familyRepo)
    {
        parent::__construct('import:csv');

        $this->reader = $reader;
        $this->familyRepo = $familyRepo;
    }

    protected function configure()
    {
        $this->setDescription('Import data from a given CSV file');
        $this->addArgument('file', InputArgument::REQUIRED, 'File to import data from');
        $this->addOption('delimiter', null, InputOption::VALUE_REQUIRED, 'Delimiter used in the CSV file', ';');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = @file_get_contents($input->getArgument('file'));

        if (!$content) {
            $reason = error_get_last();

            throw new RuntimeException("Could not open file {$file} (reason : {$reason['message']})");
        }

        $family = null;
        $currentFamilyId = null;

        foreach ($this->reader->read($content, $input->getOption('delimiter')) as $row) {
            if ($row['ORIGGPCD'] !== $currentFamilyId) {
                if (isset($family)) {
                    $this->familyRepo->save($family);
                }

                $family = new IngredientFamily(utf8_encode($row['ORIGGPFR']));
                $currentFamilyId = $row['ORIGGPCD'];
            }

            $name = $row['ORIGFDNM'];
            unset($row['ORIGGPCD'], $row['ORIGGPFR'], $row['ORIGGPFR'], $row['ORIGFDCD']);

            $energies = $nutrients = [];

            foreach ($row as $key => $value) {
                $value = utf8_encode(trim($value));

                if (empty($value)) {
                    continue;
                }

                if (preg_match('{^Energie, (.+?)$}', $key, $matches)) {
                    $energies[utf8_encode($matches[1])] = $value;
                    continue;
                }

                $nutrients[utf8_encode($key)] = $value;
            }

            $ingredient = new Ingredient($family, utf8_encode($name), $energies, $nutrients);
            $family->getIngredients()->add($ingredient);
        }
    }
}
