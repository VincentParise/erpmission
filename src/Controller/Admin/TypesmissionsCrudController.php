<?php

namespace App\Controller\Admin;

use App\Entity\Typesmissions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypesmissionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Typesmissions::class;
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
