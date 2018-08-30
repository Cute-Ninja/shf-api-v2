<?php

namespace App\Form\Type;

use App\Entity\WorkoutRepsStep;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutRepsStepType extends AbstractWorkoutStepType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => WorkoutRepsStep::class
            ]
        );
    }
}