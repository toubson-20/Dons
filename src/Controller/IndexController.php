<?php

namespace App\Controller;

use App\Entity\Campagne;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Hopital;
use App\Repository\CampagneRepository;
use App\Repository\HopitalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_index')]
    public function index(HopitalRepository $hopitalRepository, CampagneRepository $campagneRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $hopitals = $this->entityManager->getRepository(Hopital::class)->findAll();

        $campagne = $this->entityManager->getRepository(Campagne::class)->findAll();

        $pagination = $paginator->paginate(
            $hopitalRepository->paginationQuery(),
            $request->query->get('page', 1),
            3 //nombre d'articles par page
        );

        $paginationCampagne = $paginator->paginate(
            $campagneRepository->paginationQuery(),
            $request->query->get('page', 1),
            3 //nombre d'articles par page
        );

        $paginationHopital = $paginator->paginate(
            $hopitalRepository->paginationQuery(),
            $request->query->get('page', 1),
            3 //nombre d'articles par page
        );

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'hopitals' => $hopitals,
            'pagination' => $pagination,
            'paginationCampagne' => $paginationCampagne,
            'campagne' => $campagne,
            'paginationHopital' => $paginationHopital
        ]);
    }
}
