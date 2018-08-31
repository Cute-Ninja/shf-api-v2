<?php

namespace App\Form\Type\Workout;

use App\Entity\Workout\PersonalWorkout;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalWorkoutType extends AbstractWorkoutType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'scheduledDate',
            DateType::class,
            ['required' => false, 'widget' => 'single_text']
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => PersonalWorkout::class
            ]
        );
    }
}