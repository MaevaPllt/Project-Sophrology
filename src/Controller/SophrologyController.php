<?php


namespace App\Controller;


use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SophrologyController extends AbstractController
{

    /**
     * @Route("/sophrologie/", name="sophrology")
     * @param ThemeRepository $themeRepository
     * @return Response
     */
    public function index( ThemeRepository $themeRepository): Response
    {
        return $this->render("sophrology/index.html.twig", [
            'themes' => $themeRepository->findAll(),
        ]);
    }
}
