<?php

namespace App\Controller;

use App\Entity\Guest;
use App\Form\GuestType;
use App\Repository\GuestRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/guest')]
class GuestController extends AbstractController
{
    #[Route('/', name: 'app_guest_index', methods: ['GET'])]
    public function index(GuestRepository $guestRepository): Response
    {
        return $this->render('guest/index.html.twig', [
            'guests' => $guestRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_guest_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GuestRepository $guestRepository): Response
    {
        $guest = new Guest();

        $this->denyAccessUnlessGranted('new', $guest);
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guestRepository->add($guest, true);

            return $this->redirectToRoute('app_guest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guest/new.html.twig', [
            'guest' => $guest,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_guest_show', methods: ['GET'])]
    public function show(Guest $guest): Response
    {
        $this->denyAccessUnlessGranted('show', $guest);

        return $this->render('guest/show.html.twig', [
            'guest' => $guest,
        ]);
        //$this->getUser seqchas kto v sesii`d
    }


    #[Route('/{id}/edit', name: 'app_guest_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guest $guest, GuestRepository $guestRepository): Response
    {
        $this->denyAccessUnlessGranted('edit', $guest);

        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guestRepository->add($guest, true);

            return $this->redirectToRoute('app_guest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guest/edit.html.twig', [
            'guest' => $guest,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_guest_delete', methods: ['POST'])]
    public function delete(Request $request, Guest $guest, GuestRepository $guestRepository): Response
    {
        $this->denyAccessUnlessGranted('delete', $guest);

        if ($this->isCsrfTokenValid('delete'.$guest->getId(), $request->request->get('_token'))) {
            $guestRepository->remove($guest, true);
        }

        return $this->redirectToRoute('app_guest_index', [], Response::HTTP_SEE_OTHER);
    }
}
