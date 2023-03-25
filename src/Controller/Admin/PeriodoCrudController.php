<?php

namespace App\Controller\Admin;

use App\Entity\Periodo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PeriodoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Periodo::class;
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
