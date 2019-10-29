<?php

namespace App\Repository;

use App\Entity\TypeHandicap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeHandicap|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeHandicap|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeHandicap[]    findAll()
 * @method TypeHandicap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeHandicapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeHandicap::class);
    }

    // /**
    //  * @return TypeHandicap[] Returns an array of TypeHandicap objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeHandicap
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
