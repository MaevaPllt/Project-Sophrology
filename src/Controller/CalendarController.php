<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminHomeController
 * @package App\Controller
 * @Route("/user", name="user_home_")
 */
class CalendarController extends AbstractController
{

    /**
     * @return Response
     * @Route("/calendar", name="calendar")
     */
    public function index(): Response
    {

        return $this->render('account_user/calendar.html.twig');
    }
}
