<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ->add('dia', DateTimeType::class)
            ->add('periodicidad')
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
