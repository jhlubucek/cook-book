<?php

namespace App\Repository;

use App\Entity\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    /**
     * @return Ingredient[] Returns an array of Category objects
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
     * @return Ingredient[] Returns an array of Category objects
     */
    public function findRecipeIdByNameLike($value)
    {
        $query = $this->createQueryBuilder('c')
            ->select('DISTINCT c.recipe_id')
            ->andWhere('c.name LIKE :val')
            ->setParameter('val', $value)
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

    /*
    public function findOneBySomeField($value): ?Ingredient
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
