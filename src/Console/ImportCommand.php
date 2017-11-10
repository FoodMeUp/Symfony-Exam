<?php
namespace App\Console;

use RuntimeException;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use App\CsvReader;
use App\Repository\IngredientFamilyRepository;

use App\Entity\Ingredient;
use App\Entity\IngredientFamily;

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

            throw new RuntimeException("Could not open file {$input->getArgument('file')} (reason : {$reason['message']})");
        }

        $content = utf8_encode($content);

        $family = null;
        $currentFamilyId = null;

        $i = 0;
        $progress = new ProgressBar($output);

        foreach ($this->reader->read($content, $input->getOption('delimiter')) as $row) {
            if ($row['ORIGGPCD'] !== $currentFamilyId) {
                if (isset($family)) {
                    $this->familyRepo->save($family);
                }

                $family = new IngredientFamily($row['ORIGGPFR']);
                $currentFamilyId = $row['ORIGGPCD'];
            }

            $name = $row['ORIGFDNM'];
            unset($row['ORIGGPCD'], $row['ORIGGPFR'], $row['ORIGFDCD'], $row['ORIGFDNM']);

            // I could have persisted these values instead of unsetting them
            // (can make duplicated if this command is run several times...),
            // but too lazy for that actually. And I wanted to be quick.

            $energies = $nutrients = [];

            foreach ($row as $key => $value) {
                $value = trim($value);

                if (empty($value)) {
                    continue;
                }

                if (preg_match('{^Energie, (.+?)$}', $key, $matches)) {
                    $energies[$matches[1]] = $value;
                    continue;
                }

                $nutrients[$key] = $value;
            }

            $ingredient = new Ingredient($family, $name, $energies, $nutrients);
            $family->getIngredients()->add($ingredient);

            ++$i;
            $progress->advance();
        }

        $progress->finish();

        $output->writeln("\n<info>{$i}</info> elements were imported.");
    }
}
