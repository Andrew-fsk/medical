<?php

namespace App\Controller;

use App\Repository\ActiveSubstanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\ActiveSubstance;


class SubstanceController extends AbstractController
{
    #[Route('/substance', name: 'substance')]
    public function index(Request $request, ActiveSubstanceRepository $ActiveSubstanceRepository): Response
    {
        $data = $ActiveSubstanceRepository->findAll();
        $activeSubstance = new ActiveSubstance();

        $form = $this->createFormBuilder($activeSubstance)
            ->add('title', TextType::class, ['label' => 'Название',])
            ->add('save', SubmitType::class, ['label' => 'Добавить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activeSubstance = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activeSubstance);
            $entityManager->flush();

            return $this->redirectToRoute('substance');
        }

        return $this->renderForm('substance/index.html.twig', [
            'controller_action_title' => 'Список активных веществ',
            'form_action_title' => 'Добавить вещество',
            'data' => $data,
            'form' => $form
        ]);
    }

    #[Route('/substance/edit/{id}', name: 'edit_substance')]
    public function edit(int $id, Request $request, ActiveSubstanceRepository $ActiveSubstanceRepository): Response
    {
        $repository = $this->getDoctrine()->getRepository(ActiveSubstance::class);

        $activeSubstance = $repository->find($id);

        if (!$activeSubstance) {
            throw $this->notFoundException();
        }

        $form = $this->createFormBuilder($activeSubstance)
            ->add('title', TextType::class, ['label' => 'Название',])
            ->add('save', SubmitType::class, ['label' => 'Сохранить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('substance');
        }

        return $this->renderForm('substance/edit.html.twig', [
            'controller_action_title' => 'Редактировать вещество',
            'form_action_title' => 'Редактировать вещество',
            'id' => $id,
            'data' => $activeSubstance,
            'form' => $form
        ]);
    }

    #[Route('/substance/delete/{id}', name: 'delete_substance')]
    public function delete(int $id, Request $request, ActiveSubstanceRepository $ActiveSubstanceRepository): Response
    {
        $repository = $this->getDoctrine()->getRepository(ActiveSubstance::class);
        $substance = $repository->find($id);

        if (!$substance) {
            throw $this->notFoundException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($substance);
        $entityManager->flush();

        return $this->redirectToRoute('substance');
    }
}
