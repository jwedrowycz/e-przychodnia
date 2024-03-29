<?php

namespace App\Repository;

use App\Entity\Doctor;
use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Doctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doctor[]    findAll()
 * @method Doctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doctor::class);
    }


    public function findAllExceptAlreadyIn($clinicId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT  d.id, d.lastName, d.name, d.numPwz, d.spec, d.status
            FROM App\Entity\Doctor d
            
            WHERE d.id NOT IN 
                (SELECT IDENTITY(u.doctor)
                FROM App\Entity\Unit u
                WHERE u.clinic = :id)'
        )->setParameter('id', $clinicId);

        return $query->getResult();
    }

    public function findAllAlphabetical()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT d
            FROM App\Entity\Doctor d
            ORDER BY d.lastName ASC
            '
        );
        return $query->getResult();
    }

    // public function findAllAlphabetical()
    // {
    //     $qb = $this->createQueryBuilder('d')
        
    //         ->orderBy('d.lastName', 'ASC');

    //     return $qb->getQuery()->getResult();
    // }
    // /**
    //  * @return Doctor[] Returns an array of Doctor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Doctor
    {
        return $this->createQueryBuilder('l')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
