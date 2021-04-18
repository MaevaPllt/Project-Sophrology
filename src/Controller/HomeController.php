<?php

namespace App\Controller;

use App\Repository\TestinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param TestinessRepository $testinessRepository
     * @return Response
     */
    public function index(TestinessRepository $testinessRepository): Response
    {
        return $this->render("home/index.html.twig", [
            'testinesses' => $testinessRepository->findAll(),
        ]);
    }
}
