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
    
        $ev = $em->getManager()->createQuery("SELECT x.titulo AS title, x.dia AS start, x.background_color AS color, x.text_color AS textColor FROM App:Evento x JOIN App:User s WHERE s.id = x.user");
        $resultados1 = $ev->getResult();




            if (isset($_GET["query"])) {
                $query = $em->getManager()->createQuery("SELECT x FROM App:Evento x WHERE x.titulo LIKE '%".$_GET["query"]."%'");
                $ev = $query->getResult();
                $search = true;
            } else {
                $search = false;
            };
    
            return $this->render('dashboard/index.html.twig', [
                'eventos' => $resultados1,
                'query' => $search,
            ]);
        }
}
