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
use App\Repository\IngredientFamilyRepository;

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

    /** @var IngredientFamilyRepository */
    private $familyRepo;

    public function __construct(IngredientRepository $repository, IngredientFamilyRepository $familyRepo, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->familyRepo = $familyRepo;

        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->query->has('ingredient')) {
            throw new BadRequestHttpException('Missing required field "ingredient"');
        }

        $family = null;

        if ($request->query->has('family')) {
            try {
                $family = $this->familyRepo->get($request->query->get('family'));
            } catch (IngredientFamilyNotFound $e) {
                throw new BadRequestHttpException("Ingredient family {$request->query->get('family')} not found.", 404);
            }
        }

        // todo : validate sortBy field
        $result = $this->repository->search($family, $request->query->get('ingredient'), $request->query->get('sortBy', 'id'));

        return new JsonResponse($this->serializer->serialize($result, 'json', ['groups' => ['all']]));
    }
}
