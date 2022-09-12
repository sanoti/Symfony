<?php

namespace App\Controller\Api;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
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

#[Route('api/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'api_payment_index', methods: ['GET'])]
    public function index(PaymentRepository $paymentRepository, NormalizerInterface $normalizer): Response
    {
        $payments = $paymentRepository->findAll();
        return $this->json($payments);
    }

    #[Route('/new', name: 'api_payment_new', methods: ['POST'])]
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer): Response
    {
        $guest = $serializer->deserialize($request->getContent(), Payment::class, 'json');
        $entityManager->persist($guest);
        $entityManager->flush();
        return $this->json($guest, 201);
    }

    #[Route('/{id}', name: 'api_payment_show', methods: ['GET'])]
    public function show(Payment $payment, PaymentRepository $paymentRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($paymentRepository->find($payment->getId()));
    }

    #[Route('/{id}/edit', name: 'api_payment_edit', methods: ['PUT'])]
    public function edit(Payment $payment, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $editProduct = $serializer->deserialize($request->getContent(), Payment::class, 'json', ['oldEntity' => $payment]);

        $entityManager->flush();

        return $this->json($editProduct, 201);
    }

    #[Route('/{id}', name: 'api_payment_delete', methods: ['DELETE'])]
    public function delete(Payment $payment, PaymentRepository $paymentRepository, EntityManagerInterface $entityManager): Response
    {
        $delId = $payment->getId();
        $entityManager->remove($payment);
        $entityManager->flush();

        $data = [
            'id' => $delId,
            'delStatus' => "successful",
        ];

        return $this->json($data, 201);
    }
}