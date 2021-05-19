<?php

namespace App\Entity;

use App\Repository\RecipeHasCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipeHasCategoryRepository::class)
 */
class RecipeHasCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoryId;

    /**
     * @ORM\Column(type="integer")
     */
    private $recipeId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getRecipeId(): ?int
    {
        return $this->recipeId;
    }

    public function setRecipeId(int $recipeId): self
    {
        $this->recipeId = $recipeId;

        return $this;
    }
}
