<?php

namespace App\Repository;

use App\Entity\CzasPracy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CzasPracy|null find($id, $lockMode = null, $lockVersion = null)
 * @method CzasPracy|null findOneBy(array $criteria, array $orderBy = null)
 * @method CzasPracy[]    findAll()
 * @method CzasPracy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CzasPracyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CzasPracy::class);
    }

    public function findAllByJednostkaId($jednostkaId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c.id, c.dzien, c.start, c.koniec
            FROM App\Entity\CzasPracy c
            
            WHERE c.jednostka = :id 
            ORDER BY c.dzien ASC'
            
        )->setParameter('id', $jednostkaId);

        return $query->getResult();
    }

    public function findAllWithLekarzData($jednostkaId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c.id, c.dzien, c.start, c.koniec, l.imie, l.nazwisko
            FROM App\Entity\CzasPracy c
            JOIN c.jednostka j
            JOIN j.id_lekarza l
            
            WHERE c.jednostka = :id
            ORDER BY c.dzien ASC'
        )->setParameter('id', $jednostkaId);

        return $query->getResult();
    }



    // /**
    //  * @return CzasPracy[] Returns an array of CzasPracy objects
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
    public function findOneBySomeField($value): ?CzasPracy
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
