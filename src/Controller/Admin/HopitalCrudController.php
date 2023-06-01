<?php

namespace App\Controller\Admin;

use App\Entity\Hopital;
use App\Entity\Departement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class HopitalCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;
    public static function getEntityFqcn(): string
    {
        return Hopital::class;
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function configureFields(string $pageName): iterable
    {
        $departements = $this->entityManager->getRepository(Departement::class)->findAll();
        $choices = [];

        foreach ($departements as $departement) {
            $choices[$departement->getNom()] = $departement;
        }

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            TextField::new('adresse'),
            TextField::new('telephone'),
            TextField::new('siteWeb'),
            TextField::new('ville'),
            // ChoiceField::new('departement', 'Département')->setChoices($choices),
            AssociationField::new('departement', 'Département'),
            //     // ->setFormType(CrudAutocompleteType::class)
            //     ->setFormTypeOptions([
            //         'property' => 'nom',
            //         'choices' => $choices,
            //     ]),

        ];
    }
}
