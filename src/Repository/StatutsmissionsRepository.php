<?php

namespace App\Repository;

use App\Entity\Statutsmissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Statutsmissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statutsmissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statutsmissions[]    findAll()
 * @method Statutsmissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutsmissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statutsmissions::class);
    }

    // /**
    //  * @return Statutsmissions[] Returns an array of Statutsmissions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findIdByLibelle($value): ?Statutsmissions
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.libelle = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
