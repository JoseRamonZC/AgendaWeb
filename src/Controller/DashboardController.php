<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Evento;
use App\Repository\EventoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    // #[Route('/dashboard', name: 'app_dashboard')]

    
    public function index(EventoRepository $eventoRepository, ManagerRegistry $doctrine): Response
    {

        $em = $doctrine;
        $user = $this->getUser();

        dump($user);
    
        $ev = $em->getManager()->createQuery('SELECT x.titulo AS title, x.dia AS start, x.background_color AS color, x.text_color AS textColor FROM App:Evento x JOIN App:User s WHERE s.id = x.user AND s.id = ' . $user->getId() . '');
        $resultados1 = $ev->getResult();
        
        
        return $this->render('dashboard/index.html.twig', [
                'eventos' => $resultados1,
            ]);
        }
}
