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


    public function findAllExceptAlreadyIn($poradniaId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT  l.id, l.nazwisko, l.imie, l.numerPWZ, l.specjalizacja, l.status
            FROM App\Entity\Lekarz l
            WHERE l.id IN 
                (SELECT lekarz.id
                FROM App\Entity\Lekarz lekarz
                INNER JOIN App\Entity\Jednostka j
                WHERE j.id_poradni = :id)'
        )->setParameter('id', $poradniaId);

        return $query->getResult();
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
