<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Categorie;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => 'Adresse de travail',
                'constraints' => [
                    new NotNull(['message' => "Saisir l'adresse de travail"])
                ]
            ])
            ->add('codepostale', IntegerType::class, [
                'required' => false,
                'label' => 'Code postale',
                'constraints' => [
                    new NotNull(['message' => "Saisir le code postale"])
                ]
            ])
            ->add('domicile', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'style' => "height : 80%; margin-left:-30%"
                ]
            ])
            ->add('activite', EntityType::class, [
                'class' => Activite::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
