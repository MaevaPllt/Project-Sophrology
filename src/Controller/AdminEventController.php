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
     */
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $form_search_filter = $this->createForm(SearchFilterType::class);
        $form_search_filter->handleRequest($request);
        $events = $eventRepository->findAll();

        if ($form_search_filter->isSubmitted() && $form_search_filter->isValid()) {
            $search = $form_search_filter->getData()['search'];
            if (!empty($search)) {
                $events = $eventRepository->findLikeName($search);
            } else {
                $events = $eventRepository->findAll();
            }
        }

        return $this->render('admin_event/index.html.twig', [
            'events' => $events,
            'form_search_filter' => $form_search_filter->createView(),
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
        }

        return $this->redirectToRoute('admin_event_index');
    }
}
