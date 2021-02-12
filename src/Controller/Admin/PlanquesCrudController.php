<?php

namespace App\Controller\Admin;

use App\Entity\Pays;
use App\Entity\Planques;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlanquesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Planques::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('code')
                ->setLabel('Code Planque'),
            TextField::new('adresse')
                ->setLabel('Adresse'),
            IntegerField::new('postal')
                ->setLabel('Code Postal'),
            TextField::new('city')
                ->setLabel('Ville'),
           AssociationField::new('paysplanque')
               ->setLabel('Pays')
               ->setRequired(1),
            AssociationField::new('typeplanque')
            ->setLabel('Type')
            ->setRequired(1)
        ];
    }

}
