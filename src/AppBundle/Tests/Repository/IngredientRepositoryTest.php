<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 14/11/17
 * Time: 10:52
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Tests\Repository
 *
 * @author     Alexandre Vinet <alexandre.vinet@actiane.com>
 */

namespace AppBundle\Tests\Repository;

use AppBundle\Entity\Ingredient;
use AppBundle\Repository\IngredientRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class IngredientRepository
 */
class IngredientRepositoryTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testFindByName(): void
    {
        $doctrine = $this->getContainer()->get('doctrine');

        /** @var IngredientRepository $repo */
        $repo = $doctrine->getRepository(Ingredient::class);

        $result = $repo->findByNameOrCategory('pomme de terre', null);

        self::assertCount(1, $result);
        self::assertSame(4090, $result[0]->getOrigfdcd());
    }

    /**
     * @return void
     */
    public function testFindByCategory(): void
    {

        $doctrine = $this->getContainer()->get('doctrine');

        /** @var IngredientRepository $repo */
        $repo = $doctrine->getRepository(Ingredient::class);

        $result = $repo->findByNameOrCategory(null, 'Farines');

        self::assertCount(25, $result);
    }
}
