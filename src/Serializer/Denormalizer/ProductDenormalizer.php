<?php

namespace App\Serializer\Denormalizer;

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

class ProductDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('deleteEntity', $context))
        {
            $product = $context['deleteEntity'];
            $this->em->getRepository(Product::class)->remove($product);
        }

        else if (key_exists('oldEntity', $context)) //update
        {
            $product = $context['oldEntity'];

            if (key_exists('name', $data)){
                $product->setName($data['name']);
            }

            if (key_exists('price', $data)){
                $product->setPrice($data['price']);
            }
        }

        else //new
        {
            if (!(key_exists('name', $data)) || !(key_exists('price', $data))){
                throw new Exception ('Переданы не все поля для данной сущности');
            }

            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
        }

        return $product;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Product::class == $type;
    }
}