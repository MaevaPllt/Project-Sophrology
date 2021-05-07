<?php

namespace App\Controller;

use App\Entity\Repport;
use App\Form\RepportType;
use App\Repository\RepportRepository;
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
     * @Route("/", name="admin_repport_index", methods={"GET"})
     */
    public function index(RepportRepository $repportRepository): Response
    {
        return $this->render('admin_repport/index.html.twig', [
            'repports' => $repportRepository->findAll(),
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
     * @Route("/{id}", name="admin_repport_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Repport $repport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_repport_index');
    }
}
