<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class RoleService
{

    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $em)
    {
    }

    public function grandAdmin(int $userId): void
    {
        $this->grantRole($userId, 'ROLE_ADMIN');
    }

    public function grandUser(int $userId): void
    {
        $this->grantRole($userId, 'ROLE_USER');
    }


    private function grantRole(int $userId, string $role): void
    {
        $user = $this->userRepository->getUser($userId);
        $user->setRoles([$role]);

        $this->em->flush();
    }
}