<?php

namespace App\Controller\Admin;

use App\Entity\Points;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PointsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Points::class;
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
