<?php

namespace App\Controller\Admin;

use App\Entity\Hopital;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HopitalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hopital::class;
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
