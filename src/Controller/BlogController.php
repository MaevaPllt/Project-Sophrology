<?php


namespace App\Controller;

use App\Entity\Event;
use App\Form\SearchFilterType;
use App\Form\SearchCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use DateTimeInterface;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
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
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(EventRepository $eventRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $form = $this->createForm(SearchCategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()['name'];
            $datas = $eventRepository->findBy(['category' => $name]);

            $events = $paginator->paginate(
                $datas, // Requête des données à paginer
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                2); // Nombre de résultats par page

        } else {
            $events = $eventRepository->findAll();
        }

        return $this->render("blog/index.html.twig", [
            'form' => $form->createView(),
            'events' => $events,
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
