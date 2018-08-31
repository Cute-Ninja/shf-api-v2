<?php

namespace App\Form\Type;

use App\Entity\Workout\ReferenceWorkout;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferenceWorkoutType extends AbstractWorkoutType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => ReferenceWorkout::class
            ]
        );
    }
}