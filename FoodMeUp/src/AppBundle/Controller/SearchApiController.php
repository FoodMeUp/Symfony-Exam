<?php

namespace AppBundle\Controller;

use AppBundle\Repository\Ingredient;
use Proxies\__CG__\AppBundle\Entity\IngredientFamily;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchApiController extends Controller
{
    /**
     * @Route("/search/api", name="search_api")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('Rechercher', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->getData();

            $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Ingredient');
            $res = $em->createQueryBuilder('ingredient')
                ->where("ingredient.name like :name")
                ->orderBy('ingredient.id', 'ASC')
                ->setParameter('name', '%'.$searchString['Rechercher'].'%')
                ->getQuery()
                ->getArrayResult();
            dump($res);die;
            return new JsonResponse($res);
        }

        return $this->render('search/index.html.twig', ['form' => $form->createView()]);
    }
}
