<?php

namespace App\Repository;

use App\Entity\CarAccident;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarAccident|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarAccident|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarAccident[]    findAll()
 * @method CarAccident[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarAccidentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarAccident::class);
    }

    // /**
    //  * @return CarAccident[] Returns an array of CarAccident objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarAccident
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
