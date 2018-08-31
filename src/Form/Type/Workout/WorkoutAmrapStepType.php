<?php

namespace App\Form\Type\Workout;

use App\Entity\Workout\WorkoutAmrapStep;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutAmrapStepType extends AbstractWorkoutStepType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WorkoutAmrapStep::class
            ]
        );
    }
}