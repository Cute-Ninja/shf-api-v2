<?php

namespace App\Form\Type;

use App\Entity\Workout\WorkoutRestStep;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutRestStepType extends AbstractWorkoutStepType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WorkoutRestStep::class
            ]
        );
    }
}