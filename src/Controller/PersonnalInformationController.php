<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminHomeController
 * @package App\Controller
 * @Route("/membre", name="user_home_")
 */
class PersonnalInformationController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     * @Route("/information", name="information")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');
            }

        return $this->render('account_user/personnal_information.html.twig', [
            'formEditUser' => $form->createView()
        ]);
    }
}
