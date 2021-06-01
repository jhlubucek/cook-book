<?php
namespace App\Service;

use \App\Entity\Recipe;
use \App\Repository\IngredientRepository;
use \App\Entity\Ingredient;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class IngredientsManager
{
    private $ingredientRepository;
    private $entityManager;

    public function __construct(IngredientRepository $ingredientRepository, EntityManagerInterface $em)
    {
     $this->ingredientRepository = $ingredientRepository;
     $this->entityManager = $em;
    }

    public function setNewIngredients($recipe, $ingredients){

        $oldIngredients = $this->ingredientRepository->findByRecipeId($recipe->getId());
        $this->deleteIngredients($recipe);
        foreach ($ingredients as $ingredient){
            $this->entityManager->persist($ingredient);
        }
        $this->entityManager->flush();
    }

    private function deleteIngredients($recipe){
        $oldIngredients = $this->ingredientRepository->findByRecipeId($recipe->getId());
        foreach ($oldIngredients as $ingredient){
            $this->entityManager->remove($ingredient);
            $this->entityManager->flush();
        }
    }
}