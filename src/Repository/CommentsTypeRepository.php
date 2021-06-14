<?php

namespace App\Repository;

use App\Entity\CommentsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentsType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentsType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentsType[]    findAll()
 * @method CommentsType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentsType::class);
    }

    // /**
    //  * @return CommentsType[] Returns an array of CommentsType objects
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
    public function findOneBySomeField($value): ?CommentsType
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
