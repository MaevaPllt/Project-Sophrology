<?php


namespace App\Controller;

use App\Entity\Event;
use App\Form\SearchFilterType;
use App\Form\SearchCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use DateTimeInterface;
use DateTime;
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

        $form = $this->createForm(SearchCategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()['name'];
            $events = $eventRepository->findBy(['category' => $name]);

        } else {
            $events = $eventRepository->findAll();
        }

        return $this->render("blog/index.html.twig", [
            'events' => $events,
            'form' => $form->createView(),
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
