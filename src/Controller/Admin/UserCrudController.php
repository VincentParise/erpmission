<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;


class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
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
            EmailField::new('email')
                ->setLabel('Email'),
            TextField::new('password','Password')
                ->setRequired(1)
                ->formatValue(function($value){
                    return password_hash($value,PASSWORD_ARGON2I);
                }),
            DateTimeField::new('birthday')
                ->setLabel('Date Anniversaire'),
            DateTimeField::new('created_at')
                ->setLabel('Date Création'),
            AssociationField::new('paysuser')
                ->setLabel('Pays')
                ->setRequired(1),
            AssociationField::new('typeuser')
                ->setLabel('Type Utilisateur')
                ->setRequired(1),
        ];
    }

}
