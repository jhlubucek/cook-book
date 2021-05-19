<?php

namespace App\Repository;

use App\Entity\RecipeHasCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipeHasCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeHasCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeHasCategory[]    findAll()
 * @method RecipeHasCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeHasCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeHasCategory::class);
    }

    // /**
    //  * @return RecipeHasCategory[] Returns an array of RecipeHasCategory objects
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
    public function findOneBySomeField($value): ?RecipeHasCategory
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
