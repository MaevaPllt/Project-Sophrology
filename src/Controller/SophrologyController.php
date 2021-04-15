<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SophrologyController extends AbstractController
{

    /**
     * @Route("/sophrologie/", name="sophrology")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("sophrology/index.html.twig");
    }
}
