<?php

namespace App\Controller;

use App\Entity\Campagne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreateCampagneType;

class CampagneController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/campagne', name: 'app_campagne')]
    public function index(): Response
    {

        $campagne = $this->entityManager->getRepository(Campagne::class)->findAll();

        return $this->render('campagne/index.html.twig', [
            'controller_name' => 'CampagneController',
            'campagne' => $campagne,
        ]);
    }

    #[Route('/campagne/createCampagne', name: 'app_create_campagne')]
    public function createCampagne(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CreateCampagneType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campagne = $form->getData();
            $em->persist($campagne);
            $em->flush();


            $this->addFlash('message', 'Campagne crée');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('campagne/createCampagne.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/campagne/detail/{id}', name: 'app_detail_campagne')]
    public function detailCampagne(Request $request, EntityManagerInterface $em, int $id): Response
    {

        // Par exemple, vous pouvez récupérer la campagne correspondante à partir de l'ID
        $campagne = $em->getRepository(Campagne::class)->find($id);

        // Faites passer la campagne à votre template Twig
        return $this->render('campagne/detailCampagne.html.twig', [
            'campagne' => $campagne,
        ]);
    }
}



//vérifier si l'id est un entier