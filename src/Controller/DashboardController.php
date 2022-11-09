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
    
        $ev = $em->getManager()->createQuery('SELECT x.titulo AS title, x.dia AS start, x.background_color AS color, x.text_color AS textColor, x.periodicidad AS DaysOfWeek FROM App:Evento x JOIN App:User s WHERE s.id = x.user AND s.id = ' . $user->getId() . '');
        $resultados1 = $ev->getResult();


        //Proximo evento

        $id = $user->getId();

        $Pevento = $em->getManager()->createQuery("SELECT x.titulo, x.descripcion FROM App:Evento x WHERE x.dia > CURRENT_TIMESTAMP() AND x.user = $id")->setMaxResults(1);
        $EventoP = $Pevento->getResult();


        //Proximo evento de la semana que sigue

    $PeventoSem = $em->getManager()->createQuery("SELECT x FROM App:Evento x WHERE x.user = $id ORDER BY x.dia ASC");
    $EventoPSem = $PeventoSem->getResult();

    $eventos=[];

    $week = date('Y-m-d', strtotime("monday next week"));
    $domingo = date('Y-m-d', strtotime("sunday next week"));

        $EventoPSem = array_filter($EventoPSem, function($evento) use($week, $domingo) {
            $d = $evento->getDia();
            $str = $d->format("Y-m-d");
            return $str >= $week && $str <= $domingo;
        });


        //Categoria con mas eventos

        $Ncategoria = $em->getManager()->createQuery('SELECT x.categoria, COUNT(x.categoria) maximo FROM App:Evento x GROUP BY x.categoria
                                                      HAVING COUNT(x.categoria) = maximo ORDER BY x.categoria DESC ')->setMaxResults(1) ;
        $categoria = $Ncategoria->getResult();

        
        
        //Eventos del mes

        $mes = date('m');
            
            $Neventos = $em->getManager()->createQuery('SELECT MONTH(x.dia) AS mes, COUNT(x.titulo) AS veces FROM App:Evento x GROUP BY mes HAVING mes = ' . $mes . '');
            $mesEvento = $Neventos->getResult();

       
        
        
        return $this->render('dashboard/index.html.twig', [
                'eventos' => $resultados1,
                'mesEvento' => $mesEvento,
                'categoria' => $categoria,
                'EventoP' => $EventoP,
                'EventoPSem' => $EventoPSem,
            ]);
        }
}
