<?php

namespace App\Form\Type;

use App\Entity\Workout\WorkoutDistanceStep;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutDistanceStepType extends AbstractWorkoutStepType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WorkoutDistanceStep::class
            ]
        );
    }
}