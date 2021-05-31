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
    private $category_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $recipe_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getRecipeId(): ?int
    {
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): self
    {
        $this->recipe_id = $recipe_id;

        return $this;
    }
}
