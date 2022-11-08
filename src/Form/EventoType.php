<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('descripcion', TextAreaType::class)
            ->add('dia', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('periodicidad', DateIntervalType::class, [
                'widget'      => 'integer', // render a text field for each part
                // 'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you
            
                // customize which text boxes are shown
                'with_years'  => false,
                'with_months' => false,
                'with_days'   => true,
            ])
            ->add('background_color', ColorType::class)
            ->add('text_color', ColorType::class)
            ->add('categoria', ChoiceType::class, [
                'choices' => [
                    'Importante' => 'Importante',
                    'No importante' => 'No importante',
                ],
            ])
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Familiar' => 'Familiar',
                    'Trabajo' => 'Trabajo',
                    'Personal' => 'Personal',
                ]
            ],)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
