<?php

namespace App\Repository;

use App\Entity\FonctionClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FonctionClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method FonctionClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method FonctionClub[]    findAll()
 * @method FonctionClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FonctionClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FonctionClub::class);
    }

    // /**
    //  * @return FonctionClub[] Returns an array of FonctionClub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FonctionClub
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
