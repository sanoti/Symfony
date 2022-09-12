<?php

namespace App\Controller\Api;

use App\Entity\PersonalCheck;
use App\Repository\PersonalCheckRepository;
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

#[Route('api/personal')]
class PersonalCheckController extends AbstractController
{
    #[Route('/', name: 'api_personal_index', methods: ['GET'])]
    public function index(PersonalCheckRepository $personalRepository, NormalizerInterface $normalizer): Response
    {
        $payments = $personalRepository->findAll();
        return $this->json($payments);
    }

    #[Route('/new', name: 'api_personal_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer): Response
    {
        $guest = $serializer->deserialize($request->getContent(), PersonalCheck::class, 'json');
        $entityManager->persist($guest);
        $entityManager->flush();
        return $this->json($guest, 201);
    }

    #[Route('/{id}', name: 'api_personal_show', methods: ['GET'])]
    public function show(PersonalCheck $personalCheck, PersonalCheckRepository $personalRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($personalRepository->find($personalCheck->getId()));
    }

    #[Route('/{id}/edit', name: 'api_personal_edit', methods: ['PUT'])]
    public function edit(PersonalCheck $personalCheck, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editProduct = $serializer->deserialize($request->getContent(), PersonalCheck::class, 'json', ['oldEntity' => $personalCheck]);

        $entityManager->flush();

        return $this->json($editProduct, 201);
    }

    #[Route('/{id}', name: 'api_personal_delete', methods: ['DELETE'])]
    public function delete(PersonalCheck $personalCheck, PersonalCheckRepository $personalRepository, EntityManagerInterface $entityManager): Response
    {
        if (!($personalRepository->find($personalCheck->getId()))){
            throw new Exception('Персонального чека с указанным id не существует');
        }

        $delId = $personalCheck->getId();
        $entityManager->remove($personalCheck);
        $entityManager->flush();

        $data = [
            'id' => $delId,
            'delStatus' => "successful",
        ];

        return $this->json($data, 201);
    }
}