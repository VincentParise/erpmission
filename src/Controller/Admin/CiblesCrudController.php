<?php

namespace App\Controller\Admin;

use App\Entity\Cibles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CiblesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cibles::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('namecode')
                ->setLabel('Nom de code')
                ->setRequired(1),
            IntegerField::new('code')
                ->setLabel('Code')
                ->setRequired(1),
            TextField::new('firstname')
                ->setLabel('Prénom'),
            TextField::new('lastname')
                ->setLabel('Nom'),
            DateTimeField::new('birthday')
                ->setLabel('Date Anniversaire'),
            AssociationField::new('payscible')
                ->setLabel('Pays')
                ->setRequired(1),
        ];
    }

}
