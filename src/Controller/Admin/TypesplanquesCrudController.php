<?php

namespace App\Controller\Admin;

use App\Entity\Typesplanques;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypesplanquesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Typesplanques::class;
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
