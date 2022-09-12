<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Guest;
use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
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

class PaymentDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('oldEntity', $context)) //update
        {
            $payment = $context['oldEntity'];

            if (key_exists('date', $data))
            {
                $payment->setDate(new \DateTimeImmutable($data['date']));
            }

            if (key_exists('sum', $data))
            {
                $payment->setSum($data['sum']);
            }

            if (key_exists('from', $data))
            {
                $payment->setFromGuest($this->addGuest($data, 'from'));
            }

            if (key_exists('from', $data))
            {
                $payment->setToGuest($this->addGuest($data, 'to'));
            }
        }

        else //new
        {
            if (!(key_exists('date', $data)) || !(key_exists('sum', $data)) || !(key_exists('from', $data)) || !(key_exists('to', $data)))
            {
                throw new Exception ('Переданы не все поля для данной сущности');
            }

            $payment = new Payment();

            $payment->setDate(new \DateTimeImmutable($data['date']));
            $payment->setSum($data['sum']);
            $payment->setFromGuest($this->addGuest($data, 'from'));
            $payment->setToGuest($this->addGuest($data, 'to'));
        }



        return $payment;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Payment::class == $type;
    }

    private function addGuest(mixed $data, string $context)
    {
        $guest =  $this->em->getRepository(Guest::class)->find($data[$context]['id']);
        if ($guest == null)
        {
            throw new NotFoundHttpException('Гостя с указанным id не существует');
        }

        return $guest;
    }
}