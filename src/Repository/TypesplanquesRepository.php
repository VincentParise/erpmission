<?php

namespace App\Repository;

use App\Entity\Typesplanques;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typesplanques|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typesplanques|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typesplanques[]    findAll()
 * @method Typesplanques[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesplanquesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typesplanques::class);
    }

    // /**
    //  * @return Typesplanques[] Returns an array of Typesplanques objects
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
    public function findOneBySomeField($value): ?Typesplanques
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
