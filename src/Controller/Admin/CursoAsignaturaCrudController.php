<?php

namespace App\Controller\Admin;

use App\Entity\CursoAsignatura;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class CursoAsignaturaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CursoAsignatura::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [];

        if($pageName == 'index'){
            $fields[] = AssociationField::new('curso');
            $fields[] = AssociationField::new('asignatura');
            $fields[] = AssociationField::new('profesor');
            // $fields[] = CollectionField::new('alumnos');
            $fields[] = CollectionField::new('notas', 'Notas');
        }

        if($pageName == 'edit' || $pageName == 'new'){
            $fields [] = AssociationField::new('curso');
            $fields [] = AssociationField::new('asignatura');
            $fields [] = AssociationField::new('profesor');
            // $fields [] = AssociationField::new('alumnos');
            $fields [] = CollectionField::new('notas', 'Notas')
            ->setEntryType(\App\Form\NotaType::class);            
        }

        return $fields;
    }
}
