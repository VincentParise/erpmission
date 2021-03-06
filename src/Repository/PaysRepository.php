<?php

namespace App\Repository;

use App\Entity\Pays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pays|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pays|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pays[]    findAll()
 * @method Pays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pays::class);
    }

    /**
     *
     */
    public function findIdPaysByIdPlanque($value)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT p FROM App\Entity\Pays p
                 JOIN p.id i 
                 WHERE i.pays = :value 
                 ')
            ->setParameter('value',$value)
            ->getResult()
            ;
    }



    // /**
    //  * @return Pays[] Returns an array of Pays objects
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


    public function findIdByLibelle($value=null): ?Pays
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.libelle = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
