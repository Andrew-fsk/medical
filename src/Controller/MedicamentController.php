<?php

namespace App\Controller;

use App\Entity\Medicament;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicamentController extends AbstractController
{
    #[Route('/', name: 'medicament')]
    public function index(Request $request, MedicamentRepository $MedicamentRepository): Response
    {
        $data = $MedicamentRepository->findAll();

        $medicament = new Medicament();

        $form = $this->createFormBuilder($medicament)
            ->add('title', TextType::class)
            ->add('id_active_substance', TextType::class)
            ->add('id_manufacturer', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Добавить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicament = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medicament);
            $entityManager->flush();

            return $this->redirectToRoute('medicament');
        }

        return $this->renderForm('medicament/index.html.twig', [
            'controller_action_title' => 'Список лекарств',
            'form_action_title' => 'Добавить лекарство',
            'data' => $data,
            'form' => $form,
        ]);
    }

    #[Route('/medicament/delete/{id}', name: 'delete_medicament')]
    public function delete(int $id, Request $request, MedicamentRepository $MedicamentRepository): Response
    {
        $repository = $this->getDoctrine()->getRepository(Medicament::class);
        $medicament = $repository->find($id);

        if (!$medicament) {
            throw $this->notFoundException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($medicament);
        $entityManager->flush();

        return $this->redirectToRoute('medicament');
    }


    #[Route('/medicament/edit/{id}', name: 'edit_medicament')]
    public function edit(int $id, Request $request, MedicamentRepository $MedicamentRepository): Response
    {
        $repository = $this->getDoctrine()->getRepository(Medicament::class);

        $medicament = $repository->find($id);

        if (!$medicament) {
            throw $this->notFoundException();
        }

        $form = $this->createFormBuilder($medicament)
            ->add('title', TextType::class)
            ->add('id_active_substance', TextType::class)
            ->add('id_manufacturer', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Изменить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('medicament');
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'controller_action_title' => 'Редактировать лекарство',
            'form_action_title' => 'Редактировать лекарство',
            'id' => $id,
            'data' => $medicament,
            'form' => $form
        ]);
    }
}
