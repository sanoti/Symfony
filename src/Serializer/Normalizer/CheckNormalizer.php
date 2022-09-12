<?php

namespace App\Serializer\Normalizer;

use App\Entity\Check;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CheckNormalizer implements NormalizerInterface
{
    /**
     * @param Check $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = [
            'id' => $object->getId(),
            'date' => $object->getDate(),
            'store' => $object->getStore(),
            'buyingGuest' => $object->getByingGuest() ? [
                'id' => $object->getByingGuest()->getId(),
                'name' => $object->getByingGuest()->getName(),
                'number' => $object->getByingGuest()->getNumber(),
                'user' => $object->getByingGuest()->getWhoUser() ? [
                    'id' => $object->getByingGuest()->getWhoUser()->getId(),
                    'email' => $object->getByingGuest()->getWhoUser()->getEmail()
                ] : null,
            ] : null,
        ];
        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Check;
    }
}