<?php declare(strict_types=1);
/**
 * PHP version 7
 *
 * Created by PhpStorm.
 * User: alexandre_vinet
 * Date: 09/11/17
 * Time: 08:44
 *
 * @category   Symfony-Exam
 *
 * @package    AppBundle\Controller
 *
 * @subpackage AppBundle\Controller\Api
 *
 * @author     Alexandre Vinet <contact@alexandrevinet.fr>
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Ingredient;
use AppBundle\Form\IngredientSearchType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IngredientApiController
 *
 * @Rest\NamePrefix("api.ingredient.")
 * @Rest\Prefix("ingredient")
 */
class IngredientApiController extends FOSRestController
{
    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \LogicException
     */
    public function getAction(int $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Ingredient::class);

        if (!$ingredient = $repo->find($id)) {
            throw $this->createNotFoundException('Ingredient not found.');
        }
        $view = $this->view($ingredient);

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \LogicException
     */
    public function postSearchAction(Request $request): Response
    {
        $result = $form = $this->createForm(IngredientSearchType::class, null, ['csrf_protection' => false]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $repo = $this->getDoctrine()->getRepository(Ingredient::class);
            $result = $repo->findByNameOrCategory($data['name'], $data['category']);
        }

        $view = $this->view($result);

        return $this->handleView($view);
    }
}
