<?php

namespace App\Controller;

use App\Entity\Repport;
use App\Entity\User;
use App\Form\RepportType;
use App\Form\SearchPatientType;
use App\Repository\RepportRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/repport")
 */
class AdminRepportController extends AbstractController
{
    /**
     * @Route("/", name="admin_repport_index", methods={"GET", "POST"})
     * @param RepportRepository $repportRepository
     * @param Request $request
     * @return Response
     */
    public function index(RepportRepository $repportRepository, Request $request): Response
    {
        $form = $this->createForm(SearchPatientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()['name'];
            $repports = $repportRepository->findBy(['patient' => $name]);

            $lastname = $name->getLastname();
            $firstname = $name->getFirstname();
        }
        return $this->render('admin_repport/index.html.twig', [
            'repports' => $repports ?? [],
            'form' => $form->createView(),
            'lastname' => $lastname ?? '',
            'firstname' => $firstname ?? '',
        ]);
    }

    /**
     * @Route("/new", name="admin_repport_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $repport = new Repport();
        $form = $this->createForm(RepportType::class, $repport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($repport);
            $entityManager->flush();

            return $this->redirectToRoute('admin_repport_index');
        }

        return $this->render('admin_repport/new.html.twig', [
            'repport' => $repport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_repport_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Repport $repport): Response
    {
        $form = $this->createForm(RepportType::class, $repport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_repport_index');
        }

        return $this->render('admin_repport/edit.html.twig', [
            'repport' => $repport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/", name="admin_repport_show", methods={"GET","POST"})
     */
    public function show(Repport $repport): Response
    {
        return $this->render('admin_repport/show.html.twig', [
            'repport' => $repport,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_repport_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Repport $repport): Response
    {
        if ($this->isCsrfTokenValid('delete' . $repport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_repport_index');
    }
}
