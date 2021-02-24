<?php

namespace App\Repository;

use App\Entity\Missions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Missions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Missions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Missions[]    findAll()
 * @method Missions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Missions::class);
    }
    /*
     * Recherche mission par les mot title et description
     */
    public function findMotRecherche($mot){
        $query= $this->createQueryBuilder('m');
            if($mot!=null){
            $query->where('MATCH_AGAINST(m.title, m.description) AGAINST 
            (:mots boolean)>0')
                ->setParameter('mots',$mot);
            }
            return $query->getQuery()->getResult();
    }

    /**
    * @return Missions[] Returns an array of Missions objects
    */
    public function findByPaysSpecialites($pays,$specialites)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.paysmission = :pays')
            ->setParameter('pays', $pays)
            ->andWhere('m.specialitemission = :specialites')
            ->setParameter('specialites', $specialites)
            ->orderBy('m.datestart', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            //->getResult()
            ->getOneOrNullResult()
        ;
    }

    /**
    * @return Missions[] Returns an array of Missions objects
    */
    public function findByAgents($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.agents = :val')
            ->setParameter('val', $value)
            ->orderBy('m.datestart', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     *
     */
    public function getPaginatedMissions($page, $limit){
        $query = $this->createQueryBuilder('m');

        $query->setFirstResult(($page * $limit) - $limit)
              ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }

    /**
     *  On compte le nombre total de missions
     */
    public function getTotalMissions(){
        $query = $this->createQueryBuilder('m')
                      ->select('COUNT(m)');

        return $query->getQuery()->getSingleScalarResult();
    }


    /*
    public function findOneBySomeField($value): ?Missions
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
