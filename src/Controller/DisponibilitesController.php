<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisponibilitesController extends AbstractController
{
    #[Route('/disponibilites', name: 'app_disponibilites')]
    public function index(): Response
    {
        return $this->render('disponibilites/index.html.twig', [
            'controller_name' => 'DisponibilitesController',
        ]);
    }
}
