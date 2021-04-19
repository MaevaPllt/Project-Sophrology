<?php

namespace App\Controller;

use App\Entity\Price;
use App\Form\PriceType;
use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin_price")
 */
class AdminPriceController extends AbstractController
{
    /**
     * @Route("/", name="admin_price_index", methods={"GET"})
     */
    public function index(PriceRepository $priceRepository): Response
    {
        return $this->render('admin_price/index.html.twig', [
            'prices' => $priceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_price_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $price = new Price();
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($price);
            $entityManager->flush();

            return $this->redirectToRoute('admin_price_index');
        }

        return $this->render('admin_price/new.html.twig', [
            'price' => $price,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_price_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Price $price): Response
    {
        $form = $this->createForm(PriceType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_price_index');
        }

        return $this->render('admin_price/edit.html.twig', [
            'price' => $price,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_price_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Price $price): Response
    {
        if ($this->isCsrfTokenValid('delete'.$price->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($price);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_price_index');
    }
}
