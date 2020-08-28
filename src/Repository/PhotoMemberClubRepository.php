<?php

namespace App\Repository;

use App\Entity\PhotoMemberClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoMemberClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoMemberClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoMemberClub[]    findAll()
 * @method PhotoMemberClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoMemberClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoMemberClub::class);
    }

    // /**
    //  * @return PhotoMemberClub[] Returns an array of PhotoMemberClub objects
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
    public function findOneBySomeField($value): ?PhotoMemberClub
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
