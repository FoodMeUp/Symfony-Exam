<?php
namespace App\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Entity\IngredientFamily;
use App\Repository\IngredientRepository;
use App\Repository\IngredientFamilyNotFound;
use App\Repository\IngredientFamilyRepository;

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

        $familyRepo = $this->prophesize(IngredientFamilyRepository::class);
        $familyRepo->get(Argument::any())->shouldNotBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize(Argument::cetera())->shouldNotBeCalled();

        $controller = new ApiSearch($repo->reveal(), $familyRepo->reveal(), $serializer->reveal());
        $controller(new Request);
    }

    public function test_it_searches_ingredients()
    {
        $repo = $this->prophesize(IngredientRepository::class);
        $repo->search(null, 'foo', 'id')->willReturn([])->shouldBeCalled();

        $familyRepo = $this->prophesize(IngredientFamilyRepository::class);
        $familyRepo->get(Argument::any())->shouldNotBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize([], 'json', ['groups' => ['all']])->willReturn([])->shouldBeCalled();

        $request = new Request;
        $request->query->set('ingredient', 'foo');

        $controller = new ApiSearch($repo->reveal(), $familyRepo->reveal(), $serializer->reveal());
        $this->assertInstanceOf(JsonResponse::class, $controller($request));
    }

    public function test_it_searches_sorted_ingredients()
    {
        $repo = $this->prophesize(IngredientRepository::class);
        $repo->search(null, 'foo', 'bar')->willReturn([])->shouldBeCalled();

        $familyRepo = $this->prophesize(IngredientFamilyRepository::class);
        $familyRepo->get(Argument::any())->shouldNotBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize([], 'json', ['groups' => ['all']])->willReturn([])->shouldBeCalled();

        $request = new Request;
        $request->query->set('ingredient', 'foo');
        $request->query->set('sortBy', 'bar');

        $controller = new ApiSearch($repo->reveal(), $familyRepo->reveal(), $serializer->reveal());
        $this->assertInstanceOf(JsonResponse::class, $controller($request));
    }

    public function test_it_searches_filtered_ingredients()
    {
        $familyRepo = $this->prophesize(IngredientFamilyRepository::class);
        $familyRepo->get('bar')->willReturn($family = new IngredientFamily('bar'))->shouldBeCalled();

        $repo = $this->prophesize(IngredientRepository::class);
        $repo->search($family, 'foo', 'id')->willReturn([])->shouldBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize([], 'json', ['groups' => ['all']])->willReturn([])->shouldBeCalled();

        $request = new Request;
        $request->query->set('ingredient', 'foo');
        $request->query->set('family', 'bar');

        $controller = new ApiSearch($repo->reveal(), $familyRepo->reveal(), $serializer->reveal());
        $this->assertInstanceOf(JsonResponse::class, $controller($request));
    }

    /**
     * @expectedException App\Repository\IngredientFamilyNotFound
     * @expectedExceptionMessage The ingredient family bar was not found.
     */
    public function test_it_throws_on_unknown_family()
    {
        $familyRepo = $this->prophesize(IngredientFamilyRepository::class);
        $familyRepo->get('bar')->willThrow(new IngredientFamilyNotFound('bar'))->shouldBeCalled();

        $repo = $this->prophesize(IngredientRepository::class);
        $repo->search(Argument::type(IngredientFamily::class), 'foo', 'id')->willReturn([])->shouldNotBeCalled();

        $serializer = $this->prophesize(SerializerInterface::class);
        $serializer->serialize([], 'json', ['groups' => ['all']])->willReturn([])->shouldNotBeCalled();

        $request = new Request;
        $request->query->set('ingredient', 'foo');
        $request->query->set('family', 'bar');

        $controller = new ApiSearch($repo->reveal(), $familyRepo->reveal(), $serializer->reveal());
        $this->assertInstanceOf(JsonResponse::class, $controller($request));
    }
}
