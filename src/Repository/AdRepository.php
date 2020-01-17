<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

     /**
      * @return Ad[] Returns an array of Ad objects
      */
    
    public function sortingAds($pattern, $imgOnly, $min, $max)
    {
        if($imgOnly){
            /** QueryBuilder $qb */
        $qb = $this->createQueryBuilder('a');
        $qb
            ->join('a.photos', 'p')
            ->andWhere( $qb->expr()->like('a.name', ':pattern'))
            //->andWhere($qb->expr()->isNotNull('a.photos'))
            ->andWhere('a.price >= :min')
            ->andWhere('a.price <= :max') 
            ->setParameter('pattern', '%'. $pattern . '%')
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->orderBy('a.price', 'ASC')
            ->getQuery()
        ;
        
        $query = $qb->getQuery();
        }else{
            $qb = $this->createQueryBuilder('a');
            $qb
                ->andWhere( $qb->expr()->like('a.name', ':pattern'))
                ->andWhere('a.price >= :min')
                ->andWhere('a.price <= :max') 
                ->setParameter('pattern', '%'. $pattern . '%')
                ->setParameter('min', $min)
                ->setParameter('max', $max)
                ->orderBy('a.price', 'ASC')
            ;
            
            $query = $qb->getQuery();
        }
        
        return $query->execute();
        
    }
    

    /*
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
