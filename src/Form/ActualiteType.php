<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir un title']),
                ],
            ])  
            ->add('description', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir une description']),
                ],
            ]) 
            ->add('image', UrlType::class,[
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir un URL']),
                ],
                'attr' => [
                    'placeholder' => 'Coller url de l\'image '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
