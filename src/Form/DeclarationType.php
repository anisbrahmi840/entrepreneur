<?php

namespace App\Form;

use App\Entity\Declaration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotNull;

class DeclarationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chiffre', NumberType::class, [
                'label' => 'Chiffre d\'affaire',
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Déclarer votre chiffre d\'affaire']),
                ],
            ])
            ->add('cotisation', NumberType::class, [
                'disabled' => true,
            ])
            ->add('date_ex', DateType::class, [
                'label' => "Date exigibilité",
                'disabled' => true,
            ])
            ->add('penalite', NumberType::class, [
                'label' => 'Pénalité (jour retard * 10 DT)',
                'disabled' => true,
            ])
            ->add('totalapayer', NumberType::class, [
                'disabled' => true,
                'label' => "Totale à payer (costisation + pénalité)"
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
