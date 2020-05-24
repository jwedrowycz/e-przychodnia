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

        $entityManager = $this->getEntityManager();
        dump($type);
        if ($type == 0) { // INCOMING VISITS
            if ($doctor == '' and $clinic) { // IF DOCTOR IS NOT CHOSEN AND CLINIC IS CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                FROM App\Entity\Visit v
                JOIN v.user us      
                JOIN v.unit u 
                JOIN u.doctor d  
                JOIN u.clinic c 
                WHERE c.id = :clinic AND v.start >= current_date() 
                ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic);
                return $query->getResult();
            } else if ($clinic and $doctor) { // IF CLINIC IS CHOSEN AND DOCTOR IS  CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE c.id = :clinic AND u.doctor = :doctor AND v.start >= current_date() 
                        ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic)
                    ->setParameter('doctor', $doctor);
                return $query->getResult();
            }
            else { // IF ALL DEFAULT -> ALL CLINICS AND ALL DOCTORS
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE v.start >= current_date() 
                        ORDER BY v.start ASC'
                );
                return $query->getResult();
            }


        } else if ($type == 1) { // PAST VISITS
            if ($doctor == '' and $clinic) { // IF DOCTOR IS NOT CHOSEN AND CLINIC IS CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                FROM App\Entity\Visit v
                JOIN v.user us      
                JOIN v.unit u 
                JOIN u.doctor d  
                JOIN u.clinic c 
                WHERE c.id = :clinic AND v.start < current_date() 
                ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic);
                return $query->getResult();
            } else if ($clinic and $doctor) { // IF CLINIC IS CHOSEN AND DOCTOR IS  CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE c.id = :clinic AND u.doctor = :doctor AND v.start < current_date() 
                        ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic)
                    ->setParameter('doctor', $doctor);
                return $query->getResult();
            } else { // IF ALL DEFAULT -> ALL CLINICS AND ALL DOCTORS
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE v.start < current_date() 
                        ORDER BY v.start ASC'
                );
                return $query->getResult();
            }

        } else if ($type == 2) { // TODAY'S VISITS
            if ($doctor == '' and $clinic) { // IF DOCTOR IS NOT CHOSEN AND CLINIC IS CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE c.id = :clinic AND v.start = current_date() 
                        ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic);
                return $query->getResult();
            } else if ($clinic and $doctor) { // IF CLINIC IS CHOSEN AND DOCTOR IS  CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE c.id = :clinic AND u.doctor = :doctor AND v.start = current_date() 
                        ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic)
                    ->setParameter('doctor', $doctor);
                return $query->getResult();
            }  else { // IF ALL DEFAULT -> ALL CLINICS AND ALL DOCTORS
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE v.start = current_date() 
                        ORDER BY v.start ASC'
                );
                return $query->getResult();
            }
        } else if ($type == 3) { // ALL VISITS
            if ($doctor == '' and $clinic) { // IF DOCTOR IS NOT CHOSEN AND CLINIC IS CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE c.id = :clinic
                        ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic);
                return $query->getResult();
            } else if ($clinic and $doctor) { // IF CLINIC IS CHOSEN AND DOCTOR IS  CHOSEN
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        WHERE c.id = :clinic AND u.doctor = :doctor 
                        ORDER BY v.start ASC'
                )
                    ->setParameter('clinic', $clinic)
                    ->setParameter('doctor', $doctor);
                return $query->getResult();
            }
            else { // IF ALL DEFAULT -> ALL CLINICS AND ALL DOCTORS
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                        FROM App\Entity\Visit v
                        JOIN v.user us      
                        JOIN v.unit u 
                        JOIN u.doctor d  
                        JOIN u.clinic c 
                        ORDER BY v.start ASC'
                );
                return $query->getResult();
            }
        }
                // DEFAULT VIEW - INCOMING VISITS
                $query = $entityManager->createQuery(
                    'SELECT v.id, v.submit_date, v.start, v.end, us.email, us.num_phone, us.name as u_name, us.last_name as u_lastName, us.PESEL, c.name as c_name, d.name as d_name, d.last_name as d_lastName
                FROM App\Entity\Visit v
                JOIN v.user us      
                JOIN v.unit u 
                JOIN u.doctor d  
                JOIN u.clinic c 
                WHERE v.start >= current_date() 
                ORDER BY v.start ASC'
                );
                return $query->getResult();
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
