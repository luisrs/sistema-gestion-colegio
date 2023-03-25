<?php

namespace App\Controller\Admin;

use App\Entity\Curso;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CursoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Curso::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [];

        if($pageName == 'index'){
            $fields [] = TextField::new('nombre');
            $fields [] = AssociationField::new('alumnos');
            $fields [] = AssociationField::new('cursoAsignaturas');
            // $fields [] = DateTimeField::new('fechaCreacion');
        }
        
        if($pageName == 'edit' || $pageName == 'new'){
            $fields [] = TextField::new('nombre');
            // $fields [] = AssociationField::new('cursoAsignaturas');
            $fields [] = CollectionField::new('alumnos');
            // $fields [] = DateTimeField::new('fechaCreacion');
        }

        return $fields;
    }
}
