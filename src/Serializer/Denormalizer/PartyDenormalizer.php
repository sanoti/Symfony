<?php

namespace App\Serializer\Denormalizer;

use App\Entity\Guest;
use App\Entity\Party;
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

class PartyDenormalizer implements DenormalizerInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {

    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        if (key_exists('oldEntity', $context)) //update
        {
            $party = $context['oldEntity'];

            if (key_exists('name', $data))
            {
                $party->setName($data['name']);
            }

            if (key_exists('date', $data))
            {
                $party->setDateAt(new \DateTimeImmutable($data['date']));
            }

            if (key_exists('location', $data))
            {
                $party->setLocation($data['location']);
            }
        }

        else //new
        {
            if (!(key_exists('name', $data)) || !(key_exists('date', $data)) || !(key_exists('location', $data)))
            {
                throw new Exception ('Переданы не все поля для данной сущности');
            }

            $party = new Party();

            $party->setName($data['name']);
            $party->setDateAt(new \DateTimeImmutable($data['date']));
            $party->setLocation($data['location']);

            if (key_exists('guests', $data)){
                $guests = $data['guests'];

                foreach ($guests as $g){
                    $guest = $this->em->getRepository(Guest::class)->find($g['id']);

                    if($guest == null){
                        throw new NotFoundHttpException('Гостя с указанным id не существует');
                    }

                    $party->addGuest($guest);
                }
            }
        }





        return $party;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null)
    {
        return Party::class == $type;
    }

}