<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @return object|User|null
     */
    protected function getUser()
    {
        return parent::getUser();
    }

    protected function isLoggedIn(): bool
    {
        return !(is_null($this->getUser()));
    }

    protected function isAdmin(): bool
    {
        return $this->isLoggedIn() && in_array("admin", $this->getUser()->getRoles());
    }
}
