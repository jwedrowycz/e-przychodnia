<?php

namespace App\Repository;

use App\Entity\WorkTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkTime[]    findAll()
 * @method WorkTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkTime::class);
    }

    public function findAllByUnitId($unitId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c.id, c.day, c.start, c.end
            FROM App\Entity\WorkTime c
            
            WHERE c.unit = :id 
            ORDER BY c.day ASC'
            
        )->setParameter('id', $unitId);

        return $query->getResult();
    }

    public function findAllWithLekarzData($unitId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT w.id, w.day, w.start, w.end, d.name, d.last_name
            FROM App\Entity\WorkTime w
            JOIN w.unit u
            JOIN u.doctor d
            
            WHERE w.unit = :id
            ORDER BY w.day ASC'
        )->setParameter('id', $unitId);

        return $query->getResult();
    }

    public function checkWorkDay($start, $end, $unitId, $day)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT w.id, w.day, w.start, w.end
            FROM App\Entity\WorkTime w            
            WHERE w.unit = :id AND w.start < :end AND w.end > :start AND w.day = :day')
            ->setParameter('id', $unitId)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('day', $day);

        return $query->getResult();
    }





    // /**
    //  * @return WorkTime[] Returns an array of WorkTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkTime
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
