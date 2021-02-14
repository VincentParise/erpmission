<?php

namespace App\Controller\Admin;

use App\Entity\Agents;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AgentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agents::class;
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
