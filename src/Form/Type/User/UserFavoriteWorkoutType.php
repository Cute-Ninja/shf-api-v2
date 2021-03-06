<?php

namespace App\Form\Type\User;

use App\Entity\Workout\AbstractWorkout;
use App\Entity\User\User;
use App\Entity\User\UserFavoriteWorkout;
use App\Entity\Workout\ReferenceWorkout;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFavoriteWorkoutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('user', EntityType::class, ['class' => User::class])
                ->add('workout', EntityType::class, ['class' => ReferenceWorkout::class]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => UserFavoriteWorkout::class,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}