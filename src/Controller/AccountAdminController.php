<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminHomeController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AccountAdminController extends AbstractController
{

    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $this->addFlash('success', 'Bonjour ' . $this->getUser()->getFirstname() .
            ' ! Le tableau de bord vous permet de personnaliser votre site, lançez-vous !' ?? '');

        return $this->render('account_admin/admin_home.html.twig');
    }
}
