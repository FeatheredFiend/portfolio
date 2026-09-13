<?php

namespace App\Form;

use App\Entity\EducationCourse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Course name'])
            ->add('grade', TextType::class, ['required' => false])
            ->add('githubUrl', UrlType::class, ['required' => false, 'label' => 'GitHub link'])
            ->add('domainUrl', UrlType::class, ['required' => false, 'label' => 'Live/domain link'])
            ->add('otherUrl', UrlType::class, ['required' => false, 'label' => 'Other link'])
            ->add('position', IntegerType::class, ['help' => 'Lower numbers show first.'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => EducationCourse::class]);
    }
}
