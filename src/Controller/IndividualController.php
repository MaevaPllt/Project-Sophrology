<?php


namespace App\Controller;

use App\Repository\IndividualRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IndividualController extends AbstractController
{

    /**
     * @Route("/particuliers/", name="individual")
     * @return Response
     */
    public function index(IndividualRepository $individualRepository): Response
    {
        return $this->render("individual/index.html.twig", [
            'individuals' => $individualRepository->findAll(),
        ]);
    }
}
