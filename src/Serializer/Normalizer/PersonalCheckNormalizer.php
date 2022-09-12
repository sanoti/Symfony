<?php

namespace App\Serializer\Normalizer;

use App\Entity\PersonalCheck;
use App\Entity\Product;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PersonalCheckNormalizer implements NormalizerInterface
{
    /**
     * @param PersonalCheck $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'check' => $object->getFromCheck() ? [
                'id' => $object->getFromCheck()->getId(),
                'store' => $object->getFromCheck()->getStore(),
            ] : null,
            'product' => $object->getEatingProduct() ? [
                'id' => $object->getEatingProduct()->getId(),
                'name' => $object->getEatingProduct()->getName(),
                'price' => $object->getEatingProduct()->getPrice(),
            ] : null,
            'amount' => $object->getAmount(),
            'guest' => $object->getGuestWhoEat() ? [
                'id' => $object->getGuestWhoEat()->getId(),
                'name' => $object->getGuestWhoEat()->getName(),
                'number' => $object->getGuestWhoEat()->getNumber(),
            ] : null,
        ];

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof PersonalCheck;
    }
}