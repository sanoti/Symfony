<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Check;
use App\Entity\Guest;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GuestDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Guest
    {
        if (key_exists('oldEntity', $context)) //update
        {
            $guest = $context['oldEntity'];

            if (key_exists('name', $data))
            {
                $guest->setName($data['name']);
            }

            if (key_exists('number', $data))
            {
                $guest->setNumber($data['number']);
            }

            if (key_exists('user', $data))
            {
                $this->addUser($data, $guest);
            }
        }
        else //new
        {
            if (!(key_exists('name', $data)) || !(key_exists('number', $data)) || !(key_exists('user', $data)))
            {
                throw new Exception ('Переданы не все поля для данной сущности');
            }

            $guest = new Guest();
            $guest->setName($data['name']);
            $guest->setNumber($data['number']);
            $this->addUser($data, $guest);

            if (key_exists('parties', $data)){
                $parties = $data['parties'];

                foreach ($parties as $party)
                {
                    $p = $this->em->getRepository(Guest::class)->find($party['id']);
                    if($p == null)
                    {
                        throw new NotFoundHttpException('Вечеринки с указанным id не существует');
                    }
                    $guest->addParty($p);
                }
            }
        }

        return $guest;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Guest::class == $type;
    }

    private function addUser(mixed $data, Guest $guest)
    {
        $user = $this->em->getRepository(User::class)->find($data['user']['id']);
        if($user == null)
        {
            throw new NotFoundHttpException('Пользователя с указанным id не существует');
        }
        $guest->setWhoUser($user);
    }
}