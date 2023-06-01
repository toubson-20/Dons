<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilites;
use App\Entity\Hopital;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class DisponibilitesCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public static function getEntityFqcn(): string
    {
        return Disponibilites::class;
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function configureFields(string $pageName): iterable
    {
        $repository = $this->entityManager->getRepository(Hopital::class);
        $hopitals = $repository->findAll();

        $hopitalChoices = [];
        foreach ($hopitals as $hopital) {
            $hopitalChoices[$hopital->getNom()] = $hopital;
        }

        $disponibilitesCallback = function (Hopital $hopital) {
            if ($hopital !== null) {
                return $hopital->getDisponibilites();
            } else {
                return null;
            }
        };

        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('hopital', 'Hopital')
                ->setFormTypeOption('choices', $hopitalChoices)
                ->setFormTypeOption('choice_label', function (Hopital $hopital) {
                    return $hopital->getNom();
                }),
            DateField::new('date'),
            TextField::new('heure'),
        ];
    }
}
