<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Filter\FindByFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    /**
     * Recherche les annonces en fonction du formulaire
     * @return void
     */
    public function search($mots){
        $query = $this->createQueryBuilder('p');
        if($mots != null){
            $query->where('MATCH_AGAINST(p.name, p.description) AGAINST (:mots boolean)>0')
                ->setParameter('mots', '*'.$mots.'*');
        }
        return $query->getQuery()->getResult();
    }
    /**
      * @return int[]
     */
    public function findPrice()
    {
        return $this->createQueryBuilder('p')
            ->select('p.price')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Produit[]
     */
    public function findByFilter(FindByFilter $find):array
    {
        $query=
            $this->createQueryBuilder('p')
            ->select('c','p')
            ->join('p.Category','c');

        if(!empty($find->min)) {
            $query = $query -> andWhere('p.price>= :min')
                ->setParameter('min', $find->min);
        }
        if(!empty($find->max)) {
            $query = $query -> andWhere('p.price>= :max')
                ->setParameter('min', $find->max);
        }
        return $query->getQuery()->getResult();

    }




    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
