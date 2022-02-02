<?php

namespace App\Repository;

use App\Entity\Rabbit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rabbit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rabbit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rabbit[]    findAll()
 * @method Rabbit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RabbitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rabbit::class);
    }

    // /**
    //  * @return Rabbit[] Returns an array of Rabbit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rabbit
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
