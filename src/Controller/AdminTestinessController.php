<?php

namespace App\Controller;

use App\Entity\Testiness;
use App\Form\SearchFilterTestinessType;
use App\Form\TestinessType;
use App\Repository\TestinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/temoignages")
 */
class AdminTestinessController extends AbstractController
{
    /**
     * @Route("/", name="admin_testiness_index", methods={"GET","POST"})
     */
    public function index(TestinessRepository $testinessRepository, Request $request): Response
    {
        $form = $this->createForm(SearchFilterTestinessType::class);
        $form->handleRequest($request);
        $testinesses = $testinessRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            if (!empty($search)) {
                $testinesses = $testinessRepository->findLikeName($search);
            } else {
                $testinesses = $testinessRepository->findAll();
            }
        }
        return $this->render('admin_testiness/index.html.twig', [
            'testinesses' => $testinesses,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="admin_testiness_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $testiness = new Testiness();
        $form = $this->createForm(TestinessType::class, $testiness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($testiness);
            $entityManager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');

            return $this->redirectToRoute('admin_testiness_index');
        }

        return $this->render('admin_testiness/new.html.twig', [
            'testiness' => $testiness,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_testiness_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Testiness $testiness): Response
    {
        $form = $this->createForm(TestinessType::class, $testiness);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');

            return $this->redirectToRoute('admin_testiness_index');
        }

        return $this->render('admin_testiness/edit.html.twig', [
            'testiness' => $testiness,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_testiness_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Testiness $testiness): Response
    {
        if ($this->isCsrfTokenValid('delete' . $testiness->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($testiness);
            $entityManager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');
        }

        return $this->redirectToRoute('admin_testiness_index');
    }
}
