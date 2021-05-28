<?php
use \App\Entity\Recipe;

class IngredientsManager
{
    private $recipe;

    public function __construct(Recipe $recipe)
    {
     $this->recipe = $recipe;
    }
}