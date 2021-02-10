<?php

namespace App\Repository;

use App\Entity\Planques;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Planques|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planques|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planques[]    findAll()
 * @method Planques[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanquesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planques::class);
    }

    // /**
    //  * @return Planques[] Returns an array of Planques objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Planques
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
