<?php


namespace App\Controller;

use App\Entity\Event;
use App\Form\SearchFilterType;
use App\Form\SearchCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController

{
    /**
     * @Route("/", name="index" )
     * @param EventRepository $eventRepository
     * @param Request $request
     * @return Response
     */
    public function index(EventRepository $eventRepository, Request $request): Response
    {

        $form_search_category = $this->createForm(SearchCategoryType::class);
        $form_search_category->handleRequest($request);
        $events = $eventRepository->findAll();

        if ($form_search_category->isSubmitted() && $form_search_category->isValid()) {
            $name = $form_search_category->getData()['name'];
            $events = $eventRepository->findBy(['category' => $name]);
        } else {
            $events = $eventRepository->findAll();
        }

        return $this->render("blog/index.html.twig", [
            'events' => $events,
            'form_search_category' => $form_search_category->createView(),
        ]);
    }


    /**
     * @Route("/{id}/", name="show", methods={"GET","POST"})
     */
    public function show(Event $event): Response
    {
        return $this->render('blog/show.html.twig', [
            'event' => $event,
        ]);
    }
}
