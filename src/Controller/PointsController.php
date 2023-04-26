<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointsController extends AbstractController
{
    #[Route('/points', name: 'app_points')]
    public function index(): Response
    {
        return $this->render('points/index.html.twig', [
            'controller_name' => 'PointsController',
        ]);
    }
}
