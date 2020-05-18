<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }
    

    public function findAllVisits($start,$end, $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\Visit v
            WHERE (v.start BETWEEN :start AND :end OR v.end BETWEEN :start and :end)
            AND v.unit = :id
            
            ')
        ->setParameter('start', $start->format('Y-m-d H:i:s'))
        ->setParameter('end', $end->format('Y-m-d H:i:s'))
        ->setParameter('id', $id);
        
        return $query->getResult();

    }

    public function findAllWithJoined()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
            FROM App\Entity\Visit v
            JOIN v.user us      
            JOIN v.unit u 
            JOIN u.doctor d  
            JOIN u.clinic c  
            ORDER BY v.start ASC'
        );
        return $query->getResult();
    }

    public function findOverlapping($start, $end, $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT v 
             FROM App\Entity\Visit v 
             WHERE v.start < :end AND v.end > :start
             AND v.id = :unit'
        )
            ->setParameter('start',$start)
            ->setParameter('end', $end)
            ->setParameter('unit', $id);
        return $query->getResult();

    }

    // /**
    //  * @return Visit[] Returns an array of Visit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visit
    {
        return $this->createQueryBuilder('w')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
