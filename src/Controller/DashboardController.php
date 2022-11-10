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

        //mostramos loe eventos del user en el calendario

        $em = $doctrine;
        $user = $this->getUser();
    
        $ev = $em->getManager()->createQuery('SELECT x.titulo AS title, x.dia AS start, x.background_color AS color, x.text_color AS textColor, x.periodicidad AS DaysOfWeek FROM App:Evento x JOIN App:User s WHERE s.id = x.user AND s.id = ' . $user->getId() . 'ORDER BY x.dia ASC');
        $resultados1 = $ev->getResult();


        //Proximo evento

        $id = $user->getId();

        $Pevento = $em->getManager()->createQuery("SELECT x.titulo, x.descripcion FROM App:Evento x WHERE x.dia > CURRENT_TIMESTAMP() AND x.user = $id ORDER BY x.dia ASC")->setMaxResults(1);
        $EventoP = $Pevento->getResult();


        //Proximo evento de la semana que sigue

    $PeventoSem = $em->getManager()->createQuery("SELECT x FROM App:Evento x WHERE x.user = $id ORDER BY x.dia ASC");
    $EventoPSem = $PeventoSem->getResult();

    $events = [];

    foreach ($EventoPSem as $e) {
        $events[] = $e;
    }

    $week = date('Y-m-d H:i', strtotime("monday next week"));
    $domingo = date('Y-m-d H:i', strtotime("sunday next week"));

    //var_dump($eventos[count($EventoPSem)-1]);
    $events = array_values(array_filter($events, function($evento) use($week, $domingo) {
        $d = $evento->getDia()->format('Y-m-d H:i');
        return $d >= $week && $d <= $domingo;
    }));

    //var_dump($eventos[0]);

        //Categoria con mas eventos

        $Ncategoria = $em->getManager()->createQuery('SELECT x.categoria, COUNT(x.categoria) maximo FROM App:Evento x WHERE x.user ='. $id.' GROUP BY x.categoria
                                                      HAVING COUNT(x.categoria) = maximo ORDER BY x.categoria ASC ')->setMaxResults(1) ;
        $categoria = $Ncategoria->getResult();

        
        
        //Eventos del mes

        $mes = date('m');
            
            $Neventos = $em->getManager()->createQuery('SELECT MONTH(x.dia) AS mes, COUNT(x.titulo) AS veces FROM App:Evento x WHERE x.user = '. $id.' GROUP BY mes HAVING mes = ' . $mes . '');
            $mesEvento = $Neventos->getResult();

       
        
        
        return $this->render('dashboard/index.html.twig', [
                'eventos' => $resultados1,
                'mesEvento' => $mesEvento,
                'categoria' => $categoria,
                'EventoP' => $EventoP,
                'events' => $events[0],
            ]);
        }
}
