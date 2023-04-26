<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonneurController extends AbstractController
{
    #[Route('/donneur', name: 'app_donneur')]
    public function index(): Response
    {
        return $this->render('donneur/index.html.twig', [
            'controller_name' => 'DonneurController',
        ]);
    }
}
