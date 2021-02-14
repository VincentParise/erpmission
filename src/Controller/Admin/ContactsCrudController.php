<?php

namespace App\Controller\Admin;

use App\Entity\Contacts;
use App\Entity\Specialites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contacts::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('codename')
                ->setLabel('Code')
                ->setRequired(1),
            TextField::new('firstname')
                ->setLabel('Prénom'),
            TextField::new('lastname')
                ->setLabel('Nom'),
            DateTimeField::new('birthday')
                ->setLabel('Date Anniversaire'),
            AssociationField::new('pays')
                ->setLabel('Pays')
                ->setRequired(1),
        ];
    }

}
