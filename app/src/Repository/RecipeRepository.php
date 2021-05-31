<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

     /**
      * @return Recipe[] Returns an array of Recipe objects
      */
    public function findByNameLike($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.name LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $value
     * @param array $ids
     * @return Recipe[] Returns an array of Recipe objects
     */
    public function findByNameAndIdIn($value, array $ids): array
    {
        $query = $this->createQueryBuilder('r');
        $result =  $query->select('r')
            ->add('where', $query->expr()->in('r.id', $ids));
        $result = $result->andWhere('r.name Like :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->getQuery();

        return $result->getResult();
    }

    public function findOneById($value): ?Recipe
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
