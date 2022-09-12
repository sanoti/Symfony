<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\PartyType;
use App\Repository\PartyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/party')]
class PartyController extends AbstractController
{
    #[Route('/', name: 'app_party_index', methods: ['GET'])]
    public function index(PartyRepository $partyRepository): Response
    {
        return $this->render('party/index.html.twig', [
            'parties' => $partyRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_party_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartyRepository $partyRepository): Response
    {
        $party = new Party();

        $this->denyAccessUnlessGranted('new', $party);

        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partyRepository->add($party, true);

            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('party/new.html.twig', [
            'party' => $party,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_party_show', methods: ['GET'])]
    public function show(Party $party): Response
    {
        $this->denyAccessUnlessGranted('new', $party);

        return $this->render('party/show.html.twig', [
            'party' => $party,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_party_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Party $party, PartyRepository $partyRepository): Response
    {
        $this->denyAccessUnlessGranted('new', $party);

        $form = $this->createForm(PartyType::class, $party);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partyRepository->add($party, true);

            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('party/edit.html.twig', [
            'party' => $party,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_party_delete', methods: ['POST'])]
    public function delete(Request $request, Party $party, PartyRepository $partyRepository): Response
    {
        $this->denyAccessUnlessGranted('new', $party);

        if ($this->isCsrfTokenValid('delete'.$party->getId(), $request->request->get('_token'))) {
            $partyRepository->remove($party, true);
        }

        return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
    }
}
