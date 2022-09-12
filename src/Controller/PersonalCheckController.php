<?php

namespace App\Controller;

use App\Entity\PersonalCheck;
use App\Form\PersonalCheckType;
use App\Repository\PersonalCheckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personal/check')]
class PersonalCheckController extends AbstractController
{
    #[Route('/', name: 'app_personal_check_index', methods: ['GET'])]
    public function index(PersonalCheckRepository $personalCheckRepository): Response
    {
        return $this->render('personal_check/index.html.twig', [
            'personal_checks' => $personalCheckRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_personal_check_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonalCheckRepository $personalCheckRepository): Response
    {
        $personalCheck = new PersonalCheck();
        $form = $this->createForm(PersonalCheckType::class, $personalCheck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalCheckRepository->add($personalCheck, true);

            return $this->redirectToRoute('app_personal_check_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personal_check/new.html.twig', [
            'personal_check' => $personalCheck,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personal_check_show', methods: ['GET'])]
    public function show(PersonalCheck $personalCheck): Response
    {
        return $this->render('personal_check/show.html.twig', [
            'personal_check' => $personalCheck,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_personal_check_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonalCheck $personalCheck, PersonalCheckRepository $personalCheckRepository): Response
    {
        $form = $this->createForm(PersonalCheckType::class, $personalCheck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalCheckRepository->add($personalCheck, true);

            return $this->redirectToRoute('app_personal_check_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personal_check/edit.html.twig', [
            'personal_check' => $personalCheck,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personal_check_delete', methods: ['POST'])]
    public function delete(Request $request, PersonalCheck $personalCheck, PersonalCheckRepository $personalCheckRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personalCheck->getId(), $request->request->get('_token'))) {
            $personalCheckRepository->remove($personalCheck, true);
        }

        return $this->redirectToRoute('app_personal_check_index', [], Response::HTTP_SEE_OTHER);
    }
}
