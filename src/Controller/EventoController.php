<?php

namespace App\Controller;

use App\Entity\Evento;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evento')]
class EventoController extends AbstractController
{
    //#[Route('/', name: 'home', methods: ['GET'])]

    public function index(EventoRepository $eventoRepository,ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $user = $this->getUser();
        $eventos = $em->getRepository(Evento::class)->findBy(['user'=>$user]);

      
        if (isset($_GET["query"])) {
            $query = $em->createQuery("SELECT x FROM App:Evento x WHERE x.titulo LIKE '%".$_GET["query"]."%'");
            $eventos = $query->getResult();
            $search = true;
        } else {
            $search = false;
        };


        return $this->render('evento/index.html.twig', [
        'evento'=>$eventos,
        'query' => $search,
        ]);
    }

    //#[Route('/new', name: 'app_evento_new', methods: ['GET', 'POST'])]

    public function new(Request $request,EventoRepository $eventoRepository): Response
    {
        $evento = new Evento();
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $evento->setUser($user);
            $eventoRepository->save($evento, true);

            return $this->redirectToRoute('app_evento', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evento/new.html.twig', [
            'evento' => $evento,
            'form' => $form,
        ]);
    }

   // #[Route('/{id}', name: 'app_evento_show', methods: ['GET'])]

    public function show(Evento $evento): Response
    {
        return $this->render('evento/show.html.twig', [
            'evento' => $evento,
        ]);
    }

   // #[Route('/{id}/edit', name: 'app_evento_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Evento $evento, EventoRepository $eventoRepository): Response
    {
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventoRepository->save($evento, true);

            return $this->redirectToRoute('app_evento', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evento/edit.html.twig', [
            'evento' => $evento,
            'form' => $form,
        ]);
    }

    //#[Route('/{id}', name: 'app_evento_delete', methods: ['POST'])]

    public function delete(Request $request, Evento $evento, EventoRepository $eventoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evento->getId(), $request->request->get('_token'))) {
            $eventoRepository->remove($evento, true);
        }

        return $this->redirectToRoute('app_evento', [], Response::HTTP_SEE_OTHER);
    }

    

   

}
