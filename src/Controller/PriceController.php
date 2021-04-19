<?php


namespace App\Controller;


use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PriceController extends AbstractController
{

    /**
     * @Route("/price/", name="price")
     * @param PriceRepository $priceRepository
     * @return Response
     */
    public function index(PriceRepository $priceRepository): Response
    {
        return $this->render("price/index.html.twig", [
            'prices' => $priceRepository->findAll(),
        ]);
    }
}
