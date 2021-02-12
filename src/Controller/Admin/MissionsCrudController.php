<?php

namespace App\Controller\Admin;

use App\Entity\Cibles;
use App\Entity\Missions;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MissionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Missions::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Titre mission')
                ->setRequired(1),
            TextareaField::new('description')
                ->setLabel('Description')
            ->setRequired(1),
            TextField::new('codename')
                ->setLabel('Code Name'),
            DateTimeField::new('datestart')
                ->setLabel('Date Début'),
            DateTimeField::new('dateend')
                ->setLabel('Date Fin'),
            AssociationField::new('typemission')
                ->setLabel('Type Mission')
                ->setRequired(1),
            AssociationField::new('specialitemission')
                ->setLabel('Spécialité Mission')
                ->setRequired(1),
            AssociationField::new('paysmission')
                ->setLabel('Pays Mission')
                ->setRequired(1),
            AssociationField::new('statutmission')
                ->setLabel('Statut Mission')
                ->setRequired(1),
            CollectionField::new('Cibles','Cibles')
        ];
    }
}
