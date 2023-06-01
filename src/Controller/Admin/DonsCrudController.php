<?php

namespace App\Controller\Admin;

use App\Entity\Disponibilites;
use App\Entity\Dons;
use App\Entity\Hopital;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DonsCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;

    public static function getEntityFqcn(): string
    {
        return Dons::class;
    }

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function configureFields(string $pageName): iterable
    {
        $types = ["Sang", "Organe", "Espèce"];

        return [
            IdField::new('id')->onlyOnDetail(),
            ChoiceField::new('type')->setChoices(array_combine($types, $types)),
            AssociationField::new('hopital'),
            AssociationField::new('disponibilites')->setFormTypeOptions([
                'class' => Disponibilites::class,
                'query_builder' => $this->entityManager->getRepository(Disponibilites::class)->createQueryBuilder('d')
                    ->where('d.hopital = :hopital')
                    ->setParameter('hopital', null),
                'choice_label' => 'id',
            ]),
            AssociationField::new('utilisateur'),
            DateField::new('date'),
            TextEditorField::new('commentaire'),
        ];
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (!$data instanceof Dons) {
            return;
        }

        $this->updateDisponibilitesField($form, $data->getHopital());
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (!isset($data['hopital'])) {
            return;
        }

        $hopital = $this->entityManager->getRepository(Hopital::class)->find($data['hopital']);

        $this->updateDisponibilitesField($form, $hopital);
    }

    private function updateDisponibilitesField($form, Hopital $hopital = null)
    {
        $form->add('disponibilites', EntityType::class, [
            'class' => Disponibilites::class,
            'query_builder' => function ($repository) use ($hopital) {
                return $repository->createQueryBuilder('d')
                    ->where('d.hopital = :hopital')
                    ->setParameter('hopital', $hopital);
            },
            'choice_label' => 'id',
            'placeholder' => '',
            'required' => false,
            'label' => 'Disponibilités',
        ]);
    }
}
