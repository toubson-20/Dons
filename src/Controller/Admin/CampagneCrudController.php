<?php

namespace App\Controller\Admin;

use App\Entity\Campagne;
use App\Entity\Hopital;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class CampagneCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public static function getEntityFqcn(): string
    {
        return Campagne::class;
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function configureFields(string $pageName): iterable
    {

        $hopitalRepository = $this->entityManager->getRepository(Hopital::class);

        $hopitals = $this->entityManager->getRepository(Hopital::class)->findAll();
        $choices = [];

        foreach ($hopitals as $hopital) {
            $choices[$hopital->getNom()] = $hopital;
        }


        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('intitule'),
            DateField::new('date_debut'),
            DateField::new('date_fin'),
            TextField::new('adresse'),
            AssociationField::new('hopitals')
                ->setFormTypeOptions([
                    'query_builder' => fn () => $hopitalRepository->createQueryBuilder('h')->orderBy('h.nom', 'ASC'),
                    'multiple' => true,
                    'by_reference' => false,
                ])
                ->onlyOnForms(),
            TextEditorField::new('description'),
        ];
    }
}
