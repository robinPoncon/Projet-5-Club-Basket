<?php

namespace App\Repository;

use App\Entity\PhotoEquipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoEquipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoEquipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoEquipe[]    findAll()
 * @method PhotoEquipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoEquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoEquipe::class);
    }

    // /**
    //  * @return PhotoEquipe[] Returns an array of PhotoEquipe objects
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
    public function findOneBySomeField($value): ?PhotoEquipe
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
