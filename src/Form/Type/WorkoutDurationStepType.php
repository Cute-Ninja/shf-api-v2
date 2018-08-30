<?php

namespace App\Form\Type;

use App\Entity\WorkoutDurationStep;
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