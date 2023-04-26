<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HopitalController extends AbstractController
{
    #[Route('/hopital', name: 'app_hopital')]
    public function index(): Response
    {
        return $this->render('hopital/index.html.twig', [
            'controller_name' => 'HopitalController',
        ]);
    }
}
