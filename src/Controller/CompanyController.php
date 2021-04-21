<?php


namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CompanyController extends AbstractController
{

    /**
     * @Route("/company/", name="company")
     * @param CompanyRepository $companyRepository
     * @return Response
     */
    public function index( CompanyRepository $companyRepository): Response
    {
        return $this->render("company/index.html.twig", [
            'companies' => $companyRepository->findAll(),
        ]);
    }
}
