<?php

namespace App\Controller\Admin;

use App\Entity\Specialites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SpecialitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Specialites::class;
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
