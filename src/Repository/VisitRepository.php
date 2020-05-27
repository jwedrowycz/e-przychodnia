<?php

namespace App\Repository;

use App\Entity\Visit;
use DateTime;
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


    public function findAllVisits($start, $end, $id)
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

    public function findAllWithJoined($clinic = '', $doctor = '', $type = '')
    {
        $dateStart = new \DateTime();
        $currDateStart = $dateStart->setTime(0,0,0);
        $currDateStart = $currDateStart->format('Y-m-d H:i:s');

        $dateEnd = new \DateTime();
        $currDateEnd = $dateEnd->setTime(23,59,59);
        $currDateEnd = $currDateEnd->format('Y-m-d H:i:s');

        // INCOMING VISITS
        $qb = $this->createQueryBuilder('v') //MAIN QUERY
            ->addSelect('v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName')
            ->join('v.user', 'us')
            ->join('v.unit', 'u')
            ->join('u.doctor', 'd')
            ->join('u.clinic', 'c')
            ->orderBy('v.start', 'ASC');

            if ($doctor == '' and $clinic) // IF DOCTOR IS NOT CHOSEN BUT CLINIC IS CHOSEN
            {
                $qb->andWhere('c.id = :clinic');
                $qb->setParameter('clinic', $clinic);

            } else if ($clinic and $doctor) // IF CLINIC AND DOCTOR ARE CHOSEN
            {
                $qb->andWhere('c.id = :clinic');
                $qb->andWhere('u.doctor = :doctor');
                $qb->setParameter('clinic', $clinic);
                $qb->setParameter('doctor', $doctor);

            }

            if($type==0){ // INCOMING VISITS
                $qb->andWhere('v.start >= current_date()');
            } else if($type==1) { // PAST VISITS
                $qb->andWhere('v.start < current_date()');
            } else if($type==2) { // TODAY'S VISITS
                $qb->andWhere('v.start > :dateStart');
                $qb->andwhere('v.end < :dateEnd');
                $qb->setParameter('dateStart' ,$currDateStart);
                $qb->setParameter('dateEnd' ,$currDateEnd);
            } else { // ALL VISITS
                return $qb->getQuery()->getResult();
            }


        return $qb->getQuery()->getResult();
    }

    public function findOverlapping($start, $end, $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT v 
             FROM App\Entity\Visit v 
             WHERE v.start < :end AND v.end > :start
             AND v.unit = :unit'
        )
            ->setParameter('start', $start)
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