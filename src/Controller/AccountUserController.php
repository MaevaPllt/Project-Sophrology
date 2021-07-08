<?php

namespace App\Controller;

use App\Entity\Repport;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\RepportRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
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
        if (!isset($_SESSION['counter_message'])) {
            $_SESSION['counter_message'] = 1;

            $this->addFlash('success', 'Ravi de vous revoir ' . $this->getUser()->getFirstname() .
                ' ! Il y a peut-être du nouveau sur votre tableau de bord !' ?? '');
        } else {
            $_SESSION['counter_message']++;
        }

        return $this->render('account_user/user_home.html.twig');
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {

        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');
        }

        return $this->render('account_user/edit.html.twig', [
            'user' => $user,
            'formEditUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $this->container->get('security.token_storage')->setToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a bien été supprimé !');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/comptes-rendus", name="repport", methods={"GET","POST"})
     */
    public function repportUser(RepportRepository $repportRepository): Response
    {
        $repports = $repportRepository->findBy(['patient' => $this->getUser()]);

        return $this->render('account_user/repport_user.html.twig', [
            'repports' => $repports,
        ]);
    }

    /**
     * @Route("/{id}/", name="repport_show", methods={"GET","POST"})
     */
    public function show(Repport $repport): Response
    {
        return $this->render('account_user/show.html.twig', [
            'repport' => $repport,
        ]);
    }
}
