<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Check;
use App\Entity\Guest;
use App\Entity\PersonalCheck;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PersonalCheckDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('oldEntity', $context)) //update
        {
            $personal = $context['oldEntity'];

            if (key_exists('check', $data))
            {
                $this->addCheck($data, $personal);
            }

            if (key_exists('product', $data))
            {
                $this->addProduct($data, $personal);
            }

            if (key_exists('amount', $data))
            {
                $personal->setAmount($data['amount']);
            }

            if (key_exists('guest', $data))
            {
                $this->addGuest($data, $personal);
            }

        }

        else //new
        {
            if (!(key_exists('check', $data)) || !(key_exists('product', $data)) || !(key_exists('amount', $data)) || !(key_exists('guest', $data)))
            {
                throw new Exception ('Переданы не все поля для данной сущности');
            }

            $personal = new PersonalCheck();

            $this->addCheck($data, $personal);
            $this->addProduct($data, $personal);
            $personal->setAmount($data['amount']);
            $this->addGuest($data, $personal);
        }

        return $personal;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return PersonalCheck::class == $type;
    }

    private function addCheck(mixed $data, PersonalCheck $personalCheck)
    {
        $check = $this->em->getRepository(Check::class)->find($data['check']['id']);
        if ($check == null)
        {
            throw new NotFoundHttpException('Чека с указанным id не существует');
        }
        $personalCheck->setFromCheck($check);
    }

    private function addProduct(mixed $data, PersonalCheck $personalCheck)
    {
        $product = $this->em->getRepository(Product::class)->find($data['product']['id']);
        if ($product == null)
        {
            throw new NotFoundHttpException('Продукта с указанным id не существует');
        }
        $personalCheck->setEatingProduct($product);
    }

    private function addGuest(mixed $data, PersonalCheck $personalCheck)
    {
        $guest = $this->em->getRepository(Guest::class)->find($data['guest']['id']);
        if ($guest == null)
        {
            throw new NotFoundHttpException('Продукта с указанным id не существует');
        }
        $personalCheck->setGuestWhoEat($guest);
    }
}