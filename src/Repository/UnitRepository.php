<?php

namespace App\Repository;

use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unit[]    findAll()
 * @method Unit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    public function findAllByJoinedId($clinicId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT u.id as unit, d.id, d.lastName, d.name, d.status, d.numPwz, d.spec
            FROM App\Entity\Unit u
            JOIN u.doctor d
            JOIN u.clinic c
            WHERE c.id = :id'
        )->setParameter('id', $clinicId);

        return $query->getResult();
    }

//    public function findOneById($unitId)
//    {
//        $entityManager = $this->getEntityManager();
//        $query = $entityManager->createQuery(
//            'SELECT  d.lastName, d.name, d.numPwz, d.spec, c.name
//            FROM App\Entity\Unit j
//            INNER JOIN u.doctor d
//            INNER JOIN u.clinic c
//            WHERE u.id = :id'
//        )->setParameter('id', $unitId);
//
//        return $query->getResult();
//    }

    public function findAllJoined()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT u.id as unit, d.id, d.lastName, d.name, d.numPwz, d.spec, c.name as clinicName, c.id as clinicId
            FROM App\Entity\Unit u
            JOIN u.doctor d
            JOIN u.clinic c
            ');
        return $query->getResult();
    }

    public function findAllWithClinicAndDoctor()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT d.name as d_name, d.lastName, c.name, d.status, d.spec
            FROM App\Entity\Unit u
            JOIN u.doctor d
            JOIN u.clinic c'
        );
        return $query->getResult(); 
           
    }

    public function findAllByJoinedClinicIdsOnly($clinicId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT u.id
            FROM App\Entity\Unit u
            JOIN u.clinic c
            WHERE c.id = :id'
        )->setParameter('id', $clinicId);

        return $query->getResult();
    }
 

    // /**
    //  * @return Unit[] Returns an array of Unit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Unit
    {
        return $this->createQueryBuilder('j')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
