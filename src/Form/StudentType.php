<?php

namespace App\Form;

use App\Entity\ClassGroup;
use App\Entity\Project;
use App\Entity\Student;
use PhpParser\Node\Stmt\Label;
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
            ])
            ->add('classGroup', EntityType::class, [
                'class' => ClassGroup::class,
                'choice_label' => 'id',
            ])
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Add new student'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
