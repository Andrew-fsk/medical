<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function create_substance(): Response
    {
        return $this->render('catalog/create_substance.html.twig', [
            'controller_action_title' => 'Создание действующего вещества'
        ]);
    }
}
