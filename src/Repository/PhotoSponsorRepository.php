<?php

namespace App\Repository;

use App\Entity\PhotoSponsor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoSponsor|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoSponsor|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoSponsor[]    findAll()
 * @method PhotoSponsor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoSponsorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoSponsor::class);
    }

    // /**
    //  * @return Sponsor[] Returns an array of Sponsor objects
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

    /*
    public function findOneBySomeField($value): ?Sponsor
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
