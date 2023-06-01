<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Form\HopitalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\HopitalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HopitalController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/hopital', name: 'app_hopital')]
    public function index(Request $request, HopitalRepository $hopitalRepository, PaginatorInterface $paginator): Response
    {
        $repository = $this->entityManager->getRepository(Hopital::class);
        $hopitals = $repository->findAll();

        $paginationHopital = $paginator->paginate(
            $hopitalRepository->paginationQuery(),
            $request->query->get('page', 1),
            3 //nombre d'articles par page
        );

        return $this->render('hopital/index.html.twig', [
            'controller_name' => 'HopitalController',
            'hospitals' => $hopitals,
            'paginationHopital' => $paginationHopital,
        ]);
    }

    #[Route('/hopital/createHopital', name: 'app_create_hospital')]
    public function createHopital(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(HopitalType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hopital = $form->getData();
            $em->persist($hopital);
            $em->flush();

            // $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('hopital/createHopital.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/hopital/detail/{id}', name: 'app_detail_hopital')]
    public function detailHopital(EntityManagerInterface $em, int $id): Response
    {

        // récupérer la campagne correspondante à partir de l'ID
        $hopital = $em->getRepository(Hopital::class)->find($id);



        // Faites passer la campagne à votre template Twig
        return $this->render('hopital/detailHopital.html.twig', [
            'hopital' => $hopital,
        ]);
    }
}
