<?php

namespace App\Repository;

use App\Entity\GrandPrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GrandPrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrandPrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrandPrix[]    findAll()
 * @method GrandPrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrandPrixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GrandPrix::class);
    }

    // /**
    //  * @return GrandPrix[] Returns an array of GrandPrix objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GrandPrix
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
