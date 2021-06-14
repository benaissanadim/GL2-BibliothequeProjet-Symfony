<?php

namespace App\Repository;

use App\Entity\ForBorrow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ForBorrow|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForBorrow|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForBorrow[]    findAll()
 * @method ForBorrow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForBorrowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForBorrow::class);
    }

    // /**
    //  * @return ForBorrow[] Returns an array of ForBorrow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForBorrow
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
