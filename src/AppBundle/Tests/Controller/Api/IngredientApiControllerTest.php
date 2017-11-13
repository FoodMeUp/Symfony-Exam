<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 09/11/17
 * Time: 08:59
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle
 *
 * @subpackage AppBundle\Tests\Controller\Api
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Tests\Controller\Api;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class IngredientApiControllerTest
 */
class IngredientApiControllerTest extends WebTestCase
{
    /**
     * Test if we can get one ingredient.
     */
    public function testGetAction()
    {
        $client = $this->makeClient();

        $client->request('GET', $this->getUrl('api.ingredient.get', ['id' => 1]));

        $this->isSuccessful($client->getResponse());
        if ($response = $client->getResponse()) {
            $ingredient = json_decode($response->getContent());

            self::assertSame(1, $ingredient->id);
        }
    }
}
