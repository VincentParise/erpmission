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

    /**
     *Trouve la liste des planques dont le nom du pays correspond au libelle jointure pays
     */
    public function findAllPaysByIdPlanque($value)
    {
        return $this->getEntityManager()->createQuery(
                'SELECT p FROM App\Entity\Planques p
                 JOIN p.paysplanque i 
                 WHERE i.libelle = :value 
                 ')
                ->setParameter('value',$value)
                ->getResult()
                ;
    }

    /**
     * Trouve l'id du pays planque par rapport à l'id de la planque
     */
    public function findIdPaysplanqueByIdplanque(int $value)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT typeplanque_id FROM App\Entity\Planques p
                  WHERE p.id = :value 
                 ')
            ->setParameter('value',$value)
            ->getResult()
            ;
    }

    /*public function findIdPaysPlanqueByIdPlanque(int $value)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT p FROM App\Entity\Planques p
                 JOIN p.paysplanque i
                 WHERE i.libelle = :value
                 ')
            ->setParameter('value',$value)
            ->getResult()
            ;
    }*/


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
