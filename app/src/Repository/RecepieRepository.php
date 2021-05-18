<?php

namespace App\Repository;

use App\Entity\Recepie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recepie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recepie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recepie[]    findAll()
 * @method Recepie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecepieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recepie::class);
    }

    // /**
    //  * @return Recepie[] Returns an array of Recepie objects
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
    public function findOneBySomeField($value): ?Recepie
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
