<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EventoRepository;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    // #[Route('/dashboard', name: 'app_dashboard')]

    
    public function index(EventoRepository $eventoRepository): Response
    {
    
            $eventos = $eventoRepository->findAll();
    
            $array = [];
    
                foreach ($eventos as $evento) {
                    $array[] = [
                        'id' => $evento->getId(),
                        'start' => $evento->getDia(),
                        'backgroundColor' => $evento->getBackgroundColor(),
                        'textColor' => $evento->getTextColor(),
                    ];
                }
    
                $data = json_encode($array);
    
                return $this->render('dashboard/index.html.twig', compact('data'));
        }
}
