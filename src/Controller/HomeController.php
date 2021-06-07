<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\EventRepository;
use App\Repository\TestinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeInterface;
use DateTime;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param TestinessRepository $testinessRepository
     * @param EventRepository $eventRepository
     * @return Response
     */
    public function index(TestinessRepository $testinessRepository, Request $request, MailerInterface $mailer, EventRepository $eventRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($contact->getEmail())
                ->to($this->getParameter('mailer_admin'))
                ->html($this->renderView('home/mail.html.twig', [
                    'contact' => $contact,
                ]));
            $mailer->send($email);
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('home');
        }

        return $this->render("home/index.html.twig", [
            'testinesses' => $testinessRepository->findAll(),
            'form' => $form->createView(),
            'events' => $eventRepository->getLastNews(),
        ]);
    }
}
