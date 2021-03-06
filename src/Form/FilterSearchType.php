<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class FilterSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false, 
                'attr' => [
                    'placeholder' => 'Nom, prenom, réf'
                ]
            ])
            ->add('dateStart', DateType::class, [
                'required' => false, 
                'label' => 'Date debut',
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateType::class, [
                'required' => false,
                'label' => 'Date fin',
                'widget' => 'single_text',
            ])
            ->add('etat', ChoiceType::class, [
                'required' => false,
                'label' => 'Etat de déclaration',
                'choices'  => [
                    'Tous' => null,
                    'Déclaré' => true,
                    'Non déclarer' => false,
                ],
            ])
            ->add('filter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
