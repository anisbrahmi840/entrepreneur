<?php

namespace App\Form;

use App\Entity\Produit;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir un produit']),
                ],
            ])
            ->add('nb', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Nombre'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir un nombre']),
                ],
            ])
            ->add('prixUnitaire', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Prix unitaire'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir le prix']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
