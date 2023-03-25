<?php

namespace App\Controller\Admin;

use App\Entity\Asignatura;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AsignaturaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Asignatura::class;
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
