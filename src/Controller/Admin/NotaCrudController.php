<?php

namespace App\Controller\Admin;

use App\Entity\Nota;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class NotaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Nota::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            TextField::new('descripcion'),
            IntegerField::new('porcentaje'),
            BooleanField::new('calificacion'),
            BooleanField::new('concepto')
        ];
    }
}
