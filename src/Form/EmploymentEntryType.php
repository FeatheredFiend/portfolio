<?php

namespace App\Form;

use App\Entity\EmploymentEntry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploymentEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, ['widget' => 'single_text'])
            ->add('endDate', DateType::class, ['widget' => 'single_text', 'required' => false, 'help' => 'Leave blank for "current".'])
            ->add('companyName', TextType::class)
            ->add('companyTitle', TextType::class, ['label' => 'Job title'])
            ->add('description', TextareaType::class, ['attr' => ['rows' => 6]])
            ->add('position', IntegerType::class, ['help' => 'Lower numbers show first.'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => EmploymentEntry::class]);
    }
}
