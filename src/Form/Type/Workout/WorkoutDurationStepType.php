<?php

namespace App\Form\Type\Workout;

use App\Entity\Workout\WorkoutDurationStep;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutDurationStepType extends AbstractWorkoutStepType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WorkoutDurationStep::class
            ]
        );
    }
}