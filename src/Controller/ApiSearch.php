<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;

/**
 * @Route("/api/search", name="api_search")
 * @Method("GET")
 */
class ApiSearch
{
    /** @var IngredientRepository */
    private $repository;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(IngredientRepository $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->query->has('ingredient')) {
            throw new BadRequestHttpException('Missing required field "ingredient"');
        }

        $result = $this->repository->search($request->query->get('ingredient'));

        return new JsonResponse($this->serializer->serialize($result, 'json', ['groups' => ['all']]));
    }
}
