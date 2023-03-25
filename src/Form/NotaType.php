<?php

namespace App\Form;

use App\Entity\Nota;
use App\Entity\Perido;
use App\Entity\Periodo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombre', ChoiceType::class, array(
            'label' => 'Tipo',
            'choices' => [
                'Formativa' => 'Formativa',
                'Sumativa' => 'Sumativa'
            ],
            'attr' => [
                'class' => 'field-state',
                'required' => true,
            ]
        ))
            ->add('porcentaje')
            ->add('concepto')
            ->add('periodo', EntityType::class, array(
                'label' => 'Periodo',
                'class' => \App\Entity\Periodo::class,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nota::class,
        ]);
    }
}
