<?php

namespace App\Form;

use App\Entity\ClassGroup;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClassGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('year')
            ->add('students', EntityType::class, [
                'class' => Student::class,
                'choice_label' => fn($student) => strtoupper($student->getLastName()) . ', ' . $student->getFirstName(),
                'label' => 'Students:',
                'multiple' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassGroup::class,
        ]);
    }
}
