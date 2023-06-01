<?php

namespace App\Controller;

use App\Form\CreateDepartementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement')]
    public function index(): Response
    {
        return $this->render('departement/index.html.twig', [
            'controller_name' => 'DepartementController',
        ]);
    }

    #[Route('/departement/createDepartement', name: 'app_create_departement')]
    public function createDepartement(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CreateDepartementType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $departement = $form->getData();
            $em->persist($departement);
            $em->flush();

            // $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('departement/createDepartement.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
