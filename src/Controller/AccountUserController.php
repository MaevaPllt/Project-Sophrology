<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class AdminHomeController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 * @Route("/membre", name="user_")
 */
class AccountUserController extends AbstractController
{

    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $this->addFlash('success', 'Ravi de vous revoir ' . $this->getUser()->getFirstname() .
            ' ! Il y a peut-être du nouveau sur votre tableau de bord !' ?? '');

        return $this->render('account_user/user_home.html.twig');
    }
}
