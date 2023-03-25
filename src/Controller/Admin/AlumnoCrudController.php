<?php

namespace App\Controller\Admin;

use App\Entity\Alumno;
use App\Entity\Usuario;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;


class AlumnoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alumno::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            // TextField::new('apellidos'),
            TextField::new('telefono'),
            TextField::new('rut'),
            AssociationField::new('curso'),
            DateField::new('fechaNacimiento')
        ];
    }
}
