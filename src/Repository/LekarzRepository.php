<?php

namespace App\Repository;

use App\Entity\Lekarz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lekarz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lekarz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lekarz[]    findAll()
 * @method Lekarz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LekarzRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lekarz::class);
    }

    // /**
    //  * @return Lekarz[] Returns an array of Lekarz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lekarz
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
