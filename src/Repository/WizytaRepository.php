<?php

namespace App\Repository;

use App\Entity\Wizyta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wizyta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wizyta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wizyta[]    findAll()
 * @method Wizyta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WizytaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wizyta::class);
    }
    

    public function findAllWizyta($start,$end, $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT w
            FROM App\Entity\Wizyta w
            WHERE (w.rozpoczecie BETWEEN :start AND :end OR w.zakonczenie BETWEEN :start and :end)
            AND w.jednostka = :id
            
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
            FROM App\Entity\Wizyta w
            JOIN w.pacjent u      
            JOIN w.jednostka j 
            JOIN j.id_lekarza l    
            JOIN j.id_poradni p  
            ORDER BY w.rozpoczecie ASC'
        );
        return $query->getResult();
    }


    // /**
    //  * @return Wizyta[] Returns an array of Wizyta objects
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
    public function findOneBySomeField($value): ?Wizyta
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
