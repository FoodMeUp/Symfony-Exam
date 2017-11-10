<?php
namespace App\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Repository\IngredientRepository;

class ApiSearchTest extends TestCase
{
    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage Missing required field "ingredient"
     */
    public function test_no_ingredient_parameter()
    {
        $repo = $this->prophesize(IngredientRepository::class);
        $repo->search(Argument::any())->shouldNotBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize(Argument::cetera())->shouldNotBeCalled();

        $controller = new ApiSearch($repo->reveal(), $serializer->reveal());
        $controller(new Request);
    }

    public function test_it_searches_ingredients()
    {
        $repo = $this->prophesize(IngredientRepository::class);
        $repo->search('foo')->willReturn([])->shouldBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize([], 'json', ['groups' => ['all']])->willReturn('[]')->shouldBeCalled();

        $request = new Request;
        $request->query->set('ingredient', 'foo');

        $controller = new ApiSearch($repo->reveal(), $serializer->reveal());
        $this->assertInstanceOf(JsonResponse::class, $controller($request));
    }
}
