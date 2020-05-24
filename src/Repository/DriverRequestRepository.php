<?php

namespace App\Repository;

use App\Entity\DriverRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DriverRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method DriverRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method DriverRequest[]    findAll()
 * @method DriverRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DriverRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DriverRequest::class);
    }

    // /**
    //  * @return DriverRequest[] Returns an array of DriverRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
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
    public function findOneBySomeField($value): ?DriverRequest
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
