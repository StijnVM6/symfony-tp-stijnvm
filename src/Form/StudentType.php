<?php

namespace App\Form;

use App\Entity\ClassGroup;
use App\Entity\Project;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('dateOfBirth', null, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('classGroup', EntityType::class, [
                'class' => ClassGroup::class,
                'choice_label' => 'name',
                'label' => 'Class group:',
            ])
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'subject',
                'multiple' => true,
                'label' => 'Projects:',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
