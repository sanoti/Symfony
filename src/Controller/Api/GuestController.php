<?php

namespace App\Controller\Api;

use App\Entity\Guest;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/guest')]
class GuestController extends AbstractController
{
    #[Route('/', name: 'api_guest_index', methods: ['GET'])]
    public function index(GuestRepository $guestRepository, NormalizerInterface $normalizer) :Response
    {
        $guests = $guestRepository->findAll();
        return $this->json($guests);
    }

    #[Route('/new', name: 'api_guest_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
        $guest = $serializer->deserialize($request->getContent(), Guest::class, 'json');
        $entityManager->persist($guest);
        $entityManager->flush();
        return $this->json($guest, 201);
    }

    #[Route('/{id}', name: 'api_guest_show', methods: ['GET'])]
    public function show(Guest $guest, GuestRepository $guestRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($guestRepository->find($guest->getId()));
    }

    #[Route('/{id}/edit', name: 'api_guest_edit', methods: ['PUT'])]
    public function edit(Guest $guest, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editProduct = $serializer->deserialize($request->getContent(), Guest::class, 'json', ['oldEntity' => $guest]);

        $entityManager->flush();

        return $this->json($editProduct, 201);
    }

    #[Route('/{id}', name: 'api_guest_delete', methods: ['DELETE'])]
    public function delete(Guest $guest, GuestRepository $guestRepository, EntityManagerInterface $entityManager): Response
    {
        $delId = $guest->getId();
        $entityManager->remove($guest);
        $entityManager->flush();

        $data = [
            'id' => $delId,
            'delStatus' => "successful",
        ];

        return $this->json($data, 201);
    }
}