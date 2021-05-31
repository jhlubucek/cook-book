<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

     /**
      * @return Category[] Returns an array of Category objects
      */
    public function findByRecipeIdd($users) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('c')
            ->from('App\Entity\RecipeHasCategory', 'r')
            ->join('App\Entity\Category', 'c', \Doctrine\ORM\Query\Expr\Join::WITH , 'r.category_id = c.id')
            ->where('r.recipe_id = :val')
            ->setParameter('val', $users)
            ->orderBy('c.id', 'ASC');;

        return $qb->getQuery()->getResult();
    }

    public function findOneById($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
