<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 11:39
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Command
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Command;

use AppBundle\Service\IngredientFileLoader;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadIngredientCommand
 */
class LoadIngredientCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setName('app:ingredient:load')
            ->setDescription('Load the ingredients from CSV file')
            ->addArgument('file', InputArgument::REQUIRED, 'File path to laod')
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \League\Csv\Exception
     * @throws \LogicException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        /** @var Reader $reader */
        $reader = Reader::createFromPath($input->getArgument('file'));

        $reader->setHeaderOffset(0)->setDelimiter(';');

        $this->getContainer()->get(IngredientFileLoader::class)->load($reader);

        return 1;
    }
}
