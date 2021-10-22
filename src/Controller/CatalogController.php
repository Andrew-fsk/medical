<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\ActiveSubstance;

class CatalogController extends AbstractController
{
    #[Route('/', name: 'catalog')]
    public function index(): Response
    {
        return $this->render('catalog/index.html.twig', [
            'controller_action_title' => 'Главная'
        ]);
    }

    #[Route('/create/substance/', name: 'create_substance')]
    public function create_substance(Request $request): Response
    {
        $activeSubstance = new ActiveSubstance();

        $form = $this->createFormBuilder($activeSubstance)
            ->add('title', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Добавить'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activeSubstance = $form->getData();

            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($activeSubstance);
             $entityManager->flush();

            return $this->redirectToRoute('catalog');
        }

        return $this->renderForm('catalog/create_substance.html.twig', [
            'controller_action_title' => 'Добавить действующее вещество',
            'form' => $form
        ]);
    }
}
