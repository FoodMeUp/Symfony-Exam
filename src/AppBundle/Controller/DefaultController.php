<?php

namespace AppBundle\Controller;

use AppBundle\Service\AlimentService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/homepage.html.twig');
    }

    /**
     * @param $code
     * @param AlimentService $alimentService
     *
     * @return Response
     *
     * @Route("/aliments/{code}", name="aliment")
     */
    public function getAliment($code, AlimentService $alimentService): Response
    {
        $aliment = $alimentService->getOne($code);

        return $this->render('default/aliment.html.twig', [
            'aliment' => $aliment
        ]);
    }

    /**
     * @param string $string
     * @param AlimentService $alimentService
     *
     * @return Response
     *
     * @Route("/aliments-list/{string}", name="aliments_list")
     */
    public function getAlimentsAction(string $string, AlimentService $alimentService): Response
    {
        $aliments = $alimentService->get($string);

        return $this->render('default/aliments.html.twig', [
            'aliments' => $aliments
        ]);
    }
}
