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
class WizytaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }
    

    public function findAllWizyta($start,$end, $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT w
            FROM App\Entity\Visit w
            WHERE (w.rozpoczecie BETWEEN :start AND :end OR w.zakonczenie BETWEEN :start and :end)
            AND w.unit = :id
            
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
            'SELECT w.id, w.rozpoczecie, w.zakonczenie, u.email, u.imie as u_imie, u.nazwisko as u_nazwisko, u.PESEL, p.nazwa, l.imie as l_imie, l.nazwisko as l_nazwisko
            FROM App\Entity\Visit w
            JOIN w.pacjent u      
            JOIN w.unit j 
            JOIN j.id_lekarza l    
            JOIN j.id_poradni p  
            ORDER BY w.rozpoczecie ASC'
        );
        return $query->getResult();
    }


    // /**
    //  * @return Visit[] Returns an array of Visit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
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
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
