<?php

namespace App\Repository;

use App\Entity\RecepieHasCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecepieHasCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecepieHasCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecepieHasCategory[]    findAll()
 * @method RecepieHasCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecepieHasCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecepieHasCategory::class);
    }

    // /**
    //  * @return RecepieHasCategory[] Returns an array of RecepieHasCategory objects
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
    public function findOneBySomeField($value): ?RecepieHasCategory
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
