<?php

namespace App\Controller\Admin;

use App\Entity\Profesor;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfesorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profesor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            TextField::new('apellidos'),
            TextField::new('telefono'),
            TextField::new('rut'),
            TextField::new('email'),
            TextField::new('direccion'),
            TextField::new('direccion'),
            DateTimeField::new('fechaCreacion'),
            DateTimeField::new('fechaNacimiento'),
            // CollectionField::new('cursos')
        ];
    }
}
