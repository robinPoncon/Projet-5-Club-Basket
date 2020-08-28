<?php

namespace App\Repository;

use App\Entity\MemberClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberClub[]    findAll()
 * @method MemberClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberClub::class);
    }

    public function findByFonctionClub($fonctionClub)
    {
        return $this->createQueryBuilder("e")
            ->where(':fonctionClub MEMBER OF e.fonctionClub')
            ->setParameters(array('fonctionClub' => $fonctionClub))
            ;
    }

    // /**
    //  * @return MemberClub[] Returns an array of MemberClub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemberClub
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
