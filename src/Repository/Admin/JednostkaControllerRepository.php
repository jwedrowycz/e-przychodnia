<?php

namespace App\Repository\Admin;

use App\Entity\Admin\JednostkaController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JednostkaController|null find($id, $lockMode = null, $lockVersion = null)
 * @method JednostkaController|null findOneBy(array $criteria, array $orderBy = null)
 * @method JednostkaController[]    findAll()
 * @method JednostkaController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JednostkaControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JednostkaController::class);
    }

    // /**
    //  * @return JednostkaController[] Returns an array of JednostkaController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JednostkaController
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
