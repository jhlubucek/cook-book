<?php

namespace App\Repository;

use App\Entity\RecipeHasCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;

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

    /**
     * @return RecipeHasCategory[] Returns an array of Category objects
     */
    public function findByRecipeId($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.recipe_id = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return RecipeHasCategory[] Returns an array of Category objects
     */
    public function findIdsByCategoryId($ids)
    {
        $query =  $this->createQueryBuilder('c');
        $query = $query
            ->select('DISTINCT c.recipe_id')
            ->add('where', $query->expr()->in('c.category_id', $ids))
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;

        $result = [];
        foreach ($query as $id){
            $result[] = $id['recipe_id'];
        }
        return $result;
    }

//    /**
//     * @return RecipeHasCategory[] Returns an array of Category objects
//     */
//    public function findByRecipeIdd($value)
//    {
//        return $this->createQueryBuilder('h')
//            ->join('Category', 'c')
//            ->andWhere('h.recipe_id = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->getQuery()
//            ->getResult()
//            ;
//    }



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
