<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 12/11/17
 * Time: 21:30
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Tests\Command
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Tests\Command;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class LoadIngredientCommandTest
 */
class LoadIngredientCommandTest extends WebTestCase
{
    /**
     * Test if normale execution work fine.
     */
    public function testExecute()
    {
        $result = $this->runCommand('app:ingredient:load', ['file' => __DIR__.'/../DataFixtures/table_simple.csv']);

        static::assertEmpty($result);
    }
}
