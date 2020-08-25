<?php

namespace App\Repository;

use App\Entity\PhotoDiaporama;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoDiaporama|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoDiaporama|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoDiaporama[]    findAll()
 * @method PhotoDiaporama[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoDiaporamaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoDiaporama::class);
    }

    // /**
    //  * @return PhotoDiaporama[] Returns an array of PhotoDiaporama objects
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
    public function findOneBySomeField($value): ?PhotoDiaporama
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
