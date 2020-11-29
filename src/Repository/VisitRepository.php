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

    public function findAllWithJoined($clinic = '', $doctor = '', $type = '', $status = '')
    {
        $dateStart = new \DateTime();
        $currDateStart = $dateStart->setTime(0,0,0);
        $currDateStart = $currDateStart->format('Y-m-d H:i:s');

        $dateEnd = new \DateTime();
        $currDateEnd = $dateEnd->setTime(23,59,59);
        $currDateEnd = $currDateEnd->format('Y-m-d H:i:s');

        // INCOMING VISITS
        $qb = $this->createQueryBuilder('v') //MAIN QUERY
            ->addSelect('v.id, v.submit_date, v.start, v.end, us.email, us.numPhone, us.name as u_name, us.lastName as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.lastName as d_lastName')
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

            if($status == 0){
                $qb->andWhere('v.status = 0');
            }
            else if($status == 1) {
                $qb->andWhere('v.status = 1');
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

    public function countAllUserVisits($user)
    {
        $qb = $this->createQueryBuilder('v') //MAIN QUERY
            ->andWhere('v.user = :user')
            ->setParameter('user', $user)
            ->select('COUNT(v.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

//    public function findAssociatedVisits($user)
//    {
//        $qb = $this->createQueryBuilder('v')
//            ->orderBy('v.start','ASC')
//            ->setParameter('user', $user)
//            ->join('v.unit', 'u')
//            ->join('u.clinic', 'c')
//            ->addSelect('c.name')
//            ->andWhere('v.start >= current_date()');
//        return $qb->getQuery()->getResult();
//    }

    public function findAllAssociatedFilter($user, $clinic = '', $type = '', $sort = '')
    {
        $dateStart = new \DateTime();
        $currDateStart = $dateStart->setTime(0,0,0);
        $currDateStart = $currDateStart->format('Y-m-d H:i:s');

        $dateEnd = new \DateTime();
        $currDateEnd = $dateEnd->setTime(23,59,59);
        $currDateEnd = $currDateEnd->format('Y-m-d H:i:s');

        // INCOMING VISITS
        $qb = $this->createQueryBuilder('v')
            ->orderBy('v.start','ASC')
            ->andWhere('v.user = :user')
            ->setParameter('user', $user)
            ->join('v.unit', 'u')
            ->join('u.clinic', 'c')
            ->addSelect('c.name');

        if($sort==0){
            $qb->orderBy('v.start','ASC');
        }
        else if($sort==1){
            $qb->orderBy('v.start','DESC');
        }

        if ($clinic) // IF CLINIC IS CHOSEN
        {
            $qb->andWhere('c.id = :clinic')
                ->setParameter('clinic', $clinic);
        }
        if($type==0){ // INCOMING VISITS
            $qb->andWhere('v.start >= current_date()');
        } else if($type==1) { // PAST VISITS
            $qb->andWhere('v.start < current_date()');

        } else if($type==2) { // TODAY'S VISITS
            $qb->andWhere('v.start > :dateStart')
                ->andwhere('v.end < :dateEnd')
                ->setParameter('dateStart' ,$currDateStart)
                ->setParameter('dateEnd' ,$currDateEnd);
        } else { // ALL VISITS
            return $qb->getQuery()->getResult();
        }


        return $qb->getQuery()->getResult();
    }


    public function findSpecificVisit($id)
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.id = :id')
            ->setParameter('id', $id)
            ->join('v.unit', 'u')
            ->join('u.doctor', 'd')
            ->join('u.clinic', 'c')
            ->addSelect('d.name as dName')
            ->addSelect('d.lastName as dLastName')
            ->addSelect('c.name');

        return $qb->getQuery()->getResult();
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