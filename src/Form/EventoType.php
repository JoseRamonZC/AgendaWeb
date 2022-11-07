<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('periodicidad', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('background_color', ColorType::class)
            ->add('text_color', ColorType::class)
            ->add('categoria', ChoiceType::class, [
                'choices' => [
                    'Importante' => 'im',
                    'No importante' => 'nim',
                ],
            ])
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Familiar' => 'fa',
                    'Trbajo' => 'tr',
                    'Personal' => 'pe',
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
