<?php

namespace App\Controller;

use App\Entity\Disponibilites;
use App\Entity\Hopital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DonsType;

class DonsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/dons', name: 'app_dons')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        if ($request->isMethod('POST') && $request->request->get('ville') && $request->request->get('date')) {
            $ville = $request->request->get('ville');
            $date = $request->request->get('date');

            $queryBuilder = $em->createQueryBuilder();
            $queryBuilder->select('hopital', 'disponibilites')
                ->from(Hopital::class, 'hopital')
                ->join('hopital.disponibilites', 'disponibilites');

            if (!empty($ville) && !empty($date)) {
                $queryBuilder->andWhere('hopital.ville = :ville')
                    ->andWhere('disponibilites.date = :date')
                    ->setParameter('ville', $ville)
                    ->setParameter('date', $date);
            } elseif (!empty($ville)) {
                $queryBuilder->andWhere('hopital.ville = :ville')
                    ->setParameter('ville', $ville);
            } elseif (!empty($date)) {
                $queryBuilder->andWhere('disponibilites.date = :date')
                    ->setParameter('date', $date);
            } else {
                // RAS
            }

            $query = $queryBuilder->getQuery();
            $resultHopital = $query->getResult();

            return $this->render('dons/index.html.twig', [
                'controller_name' => 'DonsController',
                'hopital' => $resultHopital,

            ]);
        }

        $hopital = $this->entityManager->getRepository(Hopital::class);
        $query = $hopital->createQueryBuilder('h')
            ->leftJoin('h.disponibilites', 'd')
            ->getQuery();

        $result = $query->getResult();

        $disponibilites = $this->entityManager->getRepository(Disponibilites::class)->findAll();

        return $this->render('dons/index.html.twig', [
            'controller_name' => 'DonsController',
            'disponibilites' => $disponibilites,
            'hopital' => $result,
        ]);
    }

    #[Route('/dons/createDons/{id}', name: 'app_create_dons')]
    public function createDons(Request $request, EntityManagerInterface $em, Hopital $hopital)
    {
        // $hopital = $em->getRepository(Hopital::class)->find($id);
        $user = $this->getUser();

        $disponibilites = $hopital->getDisponibilites();

        $form = $this->createForm(DonsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dons = $form->getData();
            $em->persist($dons);
            $em->flush();

            $this->addFlash('message', 'Dons enregistré');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('dons/dons.html.twig', [
            'form' => $form->createView(),
            'hopital' => $hopital,
            'disponibilites' => $disponibilites,
            'utilisateur' => $user,
        ]);
    }
}
