<?php

namespace App\Form;

use App\Entity\Declaration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotNull;

class DeclarationAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_cr', DateType::class, [
                'required' => false,
                'label' => "Date de déclaration de trimestre",
                'widget' => 'single_text',
                'constraints' => [
                    new Date(['message' => 'saisir une date']),
                    new NotNull(['message' => 'saisir une date'])
                ]
            ])
            ->add('date_ex', DateType::class, [
                'required' => false,
                'label' => "Date exigibilité",
                'widget' => 'single_text',
                'constraints' => [
                    new Date(['message' => 'Saisir une date']),
                    new NotNull(['message' => 'saisir une date'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Declaration::class,
        ]);
    }
}
