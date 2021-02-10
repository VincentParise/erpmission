<?php

namespace App\Repository;

use App\Entity\Cibles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cibles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cibles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cibles[]    findAll()
 * @method Cibles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CiblesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cibles::class);
    }

    // /**
    //  * @return Cibles[] Returns an array of Cibles objects
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
    public function findOneBySomeField($value): ?Cibles
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
