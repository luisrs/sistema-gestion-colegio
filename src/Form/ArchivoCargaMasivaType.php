<?php

namespace App\Form;

use App\Entity\ArchivoCargaMasiva;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArchivoCargaMasivaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('curso', EntityType::class, array(
                'label' => 'Curso',
                'class' => \App\Entity\Curso::class,
            ))
            ->add('path', FileType::class, [
                'label' => 'Archivo Conciliación (Xlsx file)',
    
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
    
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        // 'mimeTypes' => [
                        //     'application/xlsx',
                        //     'application/pdf',
                        //     'application/x-pdf',
                        // ],
                        // 'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('Procesar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArchivoCargaMasiva::class,
        ]);
    }
}
