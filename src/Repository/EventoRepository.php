<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evento>
 *
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, ManagerRegistry $doctrine)
    {
        parent::__construct($registry, Evento::class);
    }

    public function save(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evento $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function buscar(User $user)
    {
        $em = $doctrine->getManager();

        $qEvento = $em->getManager()->createQuery(''
        . 'SELECT x FROM App:Evento x '
        . 'JOIN x.user u '
        . 'WHERE x.user_id = ' . $user->getId() . ' '
        );
            $eventos = $qEvento ->getResult();

            echo json_encode($eventos);
    }

//    /**
//     * @return Evento[] Returns an array of Evento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evento
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
