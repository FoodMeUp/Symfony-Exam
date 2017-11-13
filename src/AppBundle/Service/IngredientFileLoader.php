<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 21:55
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Service
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Service;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\IngredientCategory;
use AppBundle\Entity\IngredientComponent;
use AppBundle\Entity\IngredientComponentType;
use AppBundle\Interfaces\FileLoaderInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use League\Csv\Reader;

/**
 * Class IngredientFileLoader
 */
class IngredientFileLoader implements FileLoaderInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var EntityRepository
     */
    private $ingredientCategoryRepository;

    /**
     * @var EntityRepository
     */
    private $ingredientComponentTypeRepository;

    /**
     * IngredientFileLoader constructor.
     *
     * @param Registry $doctrine
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Registry $doctrine)
    {
        $this->objectManager = $doctrine->getManager();
        $this->ingredientCategoryRepository = $this->objectManager->getRepository(IngredientCategory::class);
        $this->ingredientComponentTypeRepository = $this->objectManager->getRepository(IngredientComponentType::class);
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function load(Reader $reader): void
    {
        /** @var array $record */
        foreach ($reader->getRecords() as $record) {
            $ingredient = new Ingredient();
            $this->fillRequiredFields($ingredient, $record);
            $this->fillOptionalFields($ingredient, $record);

            $this->objectManager->persist($ingredient);
        }
        $this->objectManager->flush();
    }

    /**
     * @param Ingredient $ingredient
     * @param array      $record
     */
    private function fillRequiredFields(Ingredient $ingredient, array &$record): void
    {
        $ingredient
            ->setCategory($this->getCategory($record))
            ->setOrigfdcd((int) $record['ORIGFDCD'])
            ->setOrigfdnm($record['ORIGFDNM'])
        ;

        unset($record['ORIGGPCD'], $record['ORIGGPFR'], $record['ORIGFDCD'], $record['ORIGFDNM']);
    }

    /**
     * @param Ingredient $ingredient
     * @param array      $record
     */
    private function fillOptionalFields(Ingredient $ingredient, array &$record): void
    {
        foreach ($record as $key => $value) {
            if ($component = $this->createComponent($key, $value)) {
                $ingredient->addComponent($component);
            }
        }
    }

    /**
     * @param array $record
     *
     * @return IngredientCategory|null|object
     */
    private function getCategory(array $record)
    {
        if (!$category = $this->ingredientCategoryRepository->findOneBy(['origgpcd' => $record['ORIGGPCD']])) {
            $category = new IngredientCategory();

            $category
                ->setOriggpcd($record['ORIGGPCD'])
                ->setOriggpfr($record['ORIGGPFR'])
            ;
            $this->objectManager->persist($category);
            $this->objectManager->flush();
        }

        return $category;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return null|IngredientComponent
     */
    private function createComponent(string $key, string $value): ?IngredientComponent
    {
        if ('-' === $value) {
            return null;
        }

        $ingredientComponent = new IngredientComponent();

        $ingredientComponent->setType($this->getComponentType($key));

        if ('traces' === $value) {
            $ingredientComponent->setTraces(true);
        }
        if (false !== $value = strpbrk($value, '<>')) {
            $ingredientComponent->setOperator($value[0]);
        }
        $ingredientComponent->setValue((float) $value);

        return $ingredientComponent;
    }

    /**
     * @param string $key
     *
     * @return IngredientComponentType
     */
    private function getComponentType(string $key): IngredientComponentType
    {
        if (!$componentType = $this->ingredientComponentTypeRepository->findOneBy(['label' => $key])) {
            $componentType = new IngredientComponentType();

            $componentType->setLabel($key);

            $this->objectManager->persist($componentType);
            $this->objectManager->flush();
        }

        return $componentType;
    }
}
