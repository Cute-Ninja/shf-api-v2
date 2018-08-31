<?php

namespace App\Form\Type\Workout;

use App\Entity\Workout\Exercise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractWorkoutStepType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ('POST' === $options['method']) {
            $builder->add('position', TextType::class)
                    ->add('estimatedDuration', IntegerType::class)
                    ->add('exercise', EntityType::class, ['class' => Exercise::class]);
        }
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}