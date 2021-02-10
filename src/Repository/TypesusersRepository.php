<?php

namespace App\Repository;

use App\Entity\Typesusers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typesusers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typesusers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typesusers[]    findAll()
 * @method Typesusers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypesusersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typesusers::class);
    }

    // /**
    //  * @return Typesusers[] Returns an array of Typesusers objects
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
    public function findOneBySomeField($value): ?Typesusers
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
