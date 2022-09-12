<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter\PassthroughFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[Route('api/login')]
class SecurityController extends AbstractController
{
    #[Route('/', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher){
        $content = json_decode($request->getContent(), true);
        $user = $userRepository->findOneBy(['email' => $content['email']]);

        $password = $content['password'];

        $hashPassword = $hasher->hashPassword($user, $password);

        if ($user->getPassword() == $hashPassword)
        {
            $tocken = md5(microtime());
            return $this->json($tocken);
        }
        else
        {
            return $this->json($user->getPassword());
            //throw new AuthenticationException("Пароль неверный");
        }


    }
}