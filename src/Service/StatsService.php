<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatsService{

    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    public function getStatsCount(){
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\Stats u')->getSingleScalarResult();
    }

    public function getGrandPrixCount(){
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\GrandPrix a')->getSingleScalarResult();
    }

    public function getPiloteCount(){
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Pilote b')->getSingleScalarResult();
    }

    public function getTeamCount(){
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Team c')->getSingleScalarResult();
    }

    public function getAdsStats($direction){
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c
            JOIN c.ad a
            JOIN a.author u
            GROUP BY a
            ORDER BY note '. $direction

        )
        ->setMaxResults(5)
        ->getResult();
    }

}