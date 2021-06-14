<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Form\SearchFilterType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/event")
 */
class AdminEventController extends AbstractController
{
    /**
     * @Route("/", name="admin_event_index" , methods={"GET","POST"})
     * @param EventRepository $eventRepository
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        $form = $this->createForm(SearchFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            if (!empty($search)) {
                $events = $eventRepository->findLikeName($search);
            }
        }

        return $this->render('admin_event/index.html.twig', [
            'events' => $events,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="admin_event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');

            return $this->redirectToRoute('admin_event_index');
        }

        return $this->render('admin_event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');

            return $this->redirectToRoute('admin_event_index');
        }

        return $this->render('admin_event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été mises à jour !');
        }

        return $this->redirectToRoute('admin_event_index');
    }
}
