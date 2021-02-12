<?php

namespace App\Controller\Admin;

use App\Entity\Agents;
use App\Entity\Specialites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class AgentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agents::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('code')
                ->setLabel('Code')
                ->setRequired(1),
            TextField::new('firstname')
                ->setLabel('Prénom'),
            TextField::new('lastname')
                ->setLabel('Nom'),
            EmailField::new('email')
                ->setLabel('Email'),
            DateTimeField::new('birthday')
                ->setLabel('Date Anniversaire'),
            AssociationField::new('pays')
                ->setLabel('Pays')
                ->setRequired(1),
            AssociationField::new('specialites','Spécialité',[
                        'class'=>Specialites::class,
                        'mapped'=>true,
                        'required'=>true
                ])
            ];
    }

}
