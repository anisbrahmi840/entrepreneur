<?php

namespace App\Form;

use App\Entity\Entrepreneur;
use App\Entity\Temoignage;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TemoignageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir titre de la video'])
                ],
                'label' => 'Titre'
            ])
            ->add('url', TextType::class,[
                'required' => false,
                'constraints' => [
                    new NotBlank(["message" => "Saisir url de la video"])
                ],
                'attr' => [
                    'placeholder' => "Coller Url de la video youtube"
                ]
            ])
            ->add('entrepreneur', EntityType::class, [
                'class' => Entrepreneur::class,
                'choice_label' => 'getFullName'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Temoignage::class,
        ]);
    }
}
