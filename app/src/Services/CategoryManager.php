<?php
namespace App\Service;

use \App\Entity\Recipe;
use App\Repository\CategoryRepository;
use \App\Repository\IngredientRepository;
use \App\Entity\Ingredient;
use App\Repository\RecipeHasCategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CategoryManager
{
    private $repository;
    private $entityManager;
    private $categoryRepository;

    public function __construct(
        RecipeHasCategoryRepository $repository,
        EntityManagerInterface $em,
        CategoryRepository $categoryRepository
    )
    {
        $this->repository = $repository;
        $this->entityManager = $em;
        $this->categoryRepository = $categoryRepository;
    }

    public function setNewCategories($recipe, $categories){
        $oldCategories = $this->repository->findByRecipeId($recipe->getId());
        $this->deleteCategories($recipe);
        foreach ($categories as $category){
            $this->entityManager->persist($category);
        }
        $this->entityManager->flush();
    }

    private function deleteCategories($recipe){
        $oldCategories = $this->repository->findByRecipeId($recipe->getId());
        foreach ($oldCategories as $category){
            $this->entityManager->remove($category);
            $this->entityManager->flush();
        }
    }

    public function getAllCategoriesByName(){
        $categories = $this->categoryRepository->findAll();
        $names = [];
        foreach ($categories as $category){
            $names[$category->getName()] = $category->getId();
        }
        return $names;
    }

    public function getAllCategoriesById(){
        $categories = $this->categoryRepository->findAll();
        $names = [];
        foreach ($categories as $category){
            $names[$category->getId()] = $category->getName();
        }
        return $names;
    }

    public function  getCategories(Recipe $recipe){
        $result = [];
        $categories = $this->categoryRepository->findByRecipeIdd($recipe->getId());
        foreach ($categories as $category){
            $result[] = $category->getName();
        }
        return $result;
    }
}