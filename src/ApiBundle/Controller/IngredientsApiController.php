<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Ingredients;
use AppBundle\Form\IngredientsSearchType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class IngredientApiController
 *
 * @Rest\NamePrefix("api.ingredient.")
 * @Rest\Prefix("ingredient")
 */
class IngredientsApiController extends FOSRestController
{

    /**
     * @Route("/search/ingredients", name="api_search_ingredients")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \LogicException
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\IngredientsSearchType",
     *     output="AppBundle\Entity\Ingredients",
     *     description="Returns a collection of Object",
     *     requirements={
     *          {
     *              "name"="ingredient",
     *              "dataType"="string",
     *              "description"="Ingredient name or part of name"
     *           }
     *     },
     *     statusCodes={
     *         200 = "Returned list of ingredients found",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postSearchIngredientsAction(Request $request)
    {
        $form = $this->createForm(
            IngredientsSearchType::class,
            new Ingredients()
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            if (empty($data->getOrigfdnm())) {
                return new JsonResponse(
                    ['error' => 'The field Ingredient Name cannot be empty.']
                );
            }

            $repo = $this->getDoctrine()->getRepository(Ingredients::class);
            $result = $repo->findByName($data->getOrigfdnm());

            if (!empty($result)) {
                // format data
                $arrayResults = [];

                foreach ($result as $ingredient) {
                    $arrayResults[] = [
                        'origfdcd' => $ingredient->getOrigfdcd(),
                        'origfdnm' => $ingredient->getOrigfdnm(),
                        'origgpfr' => $ingredient->getCategory()->getOriggpfr(),
                        'origgpcd' => $ingredient->getCategory()->getOriggpcd(),
                        'components' => $ingredient->getComponents(),
                    ];
                }

                return new JsonResponse($arrayResults);
            } else {
                return new JsonResponse(
                    ['error' => 'No result found.']
                );

            }
        } else {
            return new JsonResponse(
                ['error' => 'An error occured please retry later.']
            );
        }
    }
}
