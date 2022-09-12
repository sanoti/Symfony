<?php

namespace App\Serializer\Normalizer;

use App\Entity\Payment;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaymentNormalizer implements NormalizerInterface
{

    /**
     * @param Payment $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'date' => $object->getDate(),
            'from' => $object->getFromGuest() ? [
                'id' => $object->getFromGuest()->getId(),
                'name' => $object->getFromGuest()->getName(),
            ] : null,
            'to' => $object->getToGuest() ? [
                'id' => $object->getToGuest()->getId(),
                'name' => $object->getToGuest()->getName(),
            ] : null,
            'sum' => $object->getSum() . ' p.',
        ];
        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Payment;
    }
}