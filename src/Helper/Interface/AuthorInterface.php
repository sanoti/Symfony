<?php
namespace App\Helper\Interface;

use App\Entity\User;

interface AuthorInterface
{
    public function setWhoAuthor(User $user);

    public function getWhoAuthor(): ?User;
}