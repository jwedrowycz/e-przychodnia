<?php


namespace App\Repository;

use App\Entity\PoradniaInfo;
use App\Entity\Lekarz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PoradniaInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoradniaInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoradniaInfo[]    findAll()
 * @method PoradniaInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoradniaInfoRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoradniaInfo::class);
    }

    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT poradnia FROM App:PoradniaInfo poradnia ORDER BY poradnia.nazwa ASC'
            )
            ->getResult();
    }

   
}