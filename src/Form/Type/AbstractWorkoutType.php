<?php

namespace App\Form\Type;

use Faker\Provider\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AbstractWorkoutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class)
                ->add('source', TextType::class);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}