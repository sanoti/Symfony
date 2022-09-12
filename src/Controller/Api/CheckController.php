<?php

namespace App\Controller\Api;

use App\Entity\Check;
use App\Repository\CheckRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/check')]
class CheckController extends AbstractController
{
    #[Route('/', name: 'api_check_index', methods: ['GET'])]
    public function index(CheckRepository $checkRepository, NormalizerInterface $normalizer): Response
    {
        $checks = $checkRepository->findAll();
        return $this->json($checks);
    }

    #[Route('/new', name: 'api_check_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer): Response
    {
        $guest = $serializer->deserialize($request->getContent(), Check::class, 'json');
        $entityManager->persist($guest);
        $entityManager->flush();
        return $this->json($guest, 201);
    }

    #[Route('/{id}', name: 'api_check_show', methods: ['GET'])]
    public function show(Check $check, CheckRepository $checkRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($checkRepository->find($check->getId()));
    }

    #[Route('/{id}/edit', name: 'api_check_edit', methods: ['PUT'])]
    public function edit(Check $check, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editProduct = $serializer->deserialize($request->getContent(), Check::class, 'json', ['oldEntity' => $check]);

        $entityManager->flush();

        return $this->json($editProduct, 201);
    }

    #[Route('/{id}', name: 'api_check_delete', methods: ['DELETE'])]
    public function delete(Check $check, CheckRepository $checkRepository, EntityManagerInterface $entityManager): Response
    {
        $delId = $check->getId();
        $entityManager->remove($check);
        $entityManager->flush();

        $data = [
            'id' => $delId,
            'delStatus' => "successful",
        ];

        return $this->json($data, 201);
    }
}