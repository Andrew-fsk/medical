<?php

namespace App\Controller;

use App\Entity\Manufacturer;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManufacturerController extends AbstractController
{
    #[Route('/manufacturer', name: 'manufacturer')]
    public function index(Request $request, ManufacturerRepository $ManufacturerRepository): Response
    {
        $data = $ManufacturerRepository->findAll();
        $manufacturer = new Manufacturer();

        $form = $this->createFormBuilder($manufacturer)
            ->add('title', TextType::class)
            ->add('site_url', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Добавить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manufacturer = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manufacturer);
            $entityManager->flush();

            return $this->redirectToRoute('manufacturer');
        }

        return $this->renderForm('manufacturer/index.html.twig', [
            'controller_action_title' => 'Список производителей',
            'form_action_title' => 'Добавить производителя',
            'data' => $data,
            'form' => $form
        ]);
    }

    #[Route('/manufacturer/edit/{id}', name: 'edit_manufacturer')]
    public function edit(int $id, Request $request, Manufacturer $Manufacturer): Response
    {
        $repository = $this->getDoctrine()->getRepository(Manufacturer::class);

        $manufacturer = $repository->find($id);

        if (!$manufacturer) {
            throw $this->notFoundException();
        }

        $form = $this->createFormBuilder($manufacturer)
            ->add('title', TextType::class)
            ->add('site_url', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Сохранить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manufacturer = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manufacturer);
            $entityManager->flush();

            return $this->redirectToRoute('manufacturer');
        }

        return $this->renderForm('manufacturer/edit.html.twig', [
            'controller_action_title' => 'Редактировать производителя',
            'form_action_title' => 'Редактировать производителя',
            'id' => $id,
            'data' => $manufacturer,
            'form' => $form
        ]);
    }

    #[Route('/manufacturer/delete/{id}', name: 'delete_manufacturer')]
    public function delete(int $id, Request $request, Manufacturer $manufacturer): Response
    {
        $repository = $this->getDoctrine()->getRepository(Manufacturer::class);
        $manufacturer = $repository->find($id);

        if (!$manufacturer) {
            throw $this->notFoundException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($manufacturer);
        $entityManager->flush();

        return $this->redirectToRoute('manufacturer');
    }
}
