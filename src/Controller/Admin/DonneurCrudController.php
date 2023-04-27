<?php

namespace App\Controller\Admin;

use App\Entity\Donneur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DonneurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Donneur::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
