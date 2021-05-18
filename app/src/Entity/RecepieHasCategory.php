<?php

namespace App\Entity;

use App\Repository\RecepieHasCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecepieHasCategoryRepository::class)
 */
class RecepieHasCategory
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
    private $recepieId;

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

    public function getRecepieId(): ?int
    {
        return $this->recepieId;
    }

    public function setRecepieId(int $recepieId): self
    {
        $this->recepieId = $recepieId;

        return $this;
    }
}
