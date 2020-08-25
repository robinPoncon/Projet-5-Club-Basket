<?php

namespace App\Repository;

use App\Entity\Diaporama;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Diaporama|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diaporama|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diaporama[]    findAll()
 * @method Diaporama[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiaporamaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diaporama::class);
    }

    // /**
    //  * @return Diaporama[] Returns an array of Diaporama objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Diaporama
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
