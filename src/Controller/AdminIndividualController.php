<?php

namespace App\Controller;

use App\Entity\Individual;
use App\Form\IndividualType;
use App\Repository\IndividualRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/particuliers")
 */
class AdminIndividualController extends AbstractController
{
    /**
     * @Route("/", name="admin_individual_index", methods={"GET"})
     */
    public function index(IndividualRepository $individualRepository): Response
    {
        return $this->render('admin_individual/index.html.twig', [
            'individuals' => $individualRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_individual_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $individual = new Individual();
        $form = $this->createForm(IndividualType::class, $individual);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($individual);
            $entityManager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');

            return $this->redirectToRoute('admin_individual_index');
        }

        return $this->render('admin_individual/new.html.twig', [
            'individual' => $individual,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_individual_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Individual $individual): Response
    {
        $form = $this->createForm(IndividualType::class, $individual);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');

            return $this->redirectToRoute('admin_individual_index');
        }

        return $this->render('admin_individual/edit.html.twig', [
            'individual' => $individual,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_individual_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Individual $individual): Response
    {
        if ($this->isCsrfTokenValid('delete'.$individual->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($individual);
            $entityManager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');
        }

        return $this->redirectToRoute('admin_individual_index');
    }
}
