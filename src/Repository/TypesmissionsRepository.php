<?php

namespace App\Repository;

use App\Entity\Typesmissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typesmissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typesmissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typesmissions[]    findAll()
 * @method Typesmissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesmissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typesmissions::class);
    }

    // /**
    //  * @return Typesmissions[] Returns an array of Typesmissions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Typesmissions
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
