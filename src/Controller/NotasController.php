<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotasController extends AbstractController
{
    #[Route('/notas', name: 'app_notas')]
    public function index(): Response
    {
        return $this->render('notas/index.html.twig', [
            'controller_name' => 'NotasController',
        ]);
    }

    #[Route('/registro-notas', name: 'registro_notas')]
    public function registroNotas(Request $request): Response
    {
        return $this->render('notas/index.html.twig', [
            'controller_name' => 'NotasController',
        ]);
    }

}
