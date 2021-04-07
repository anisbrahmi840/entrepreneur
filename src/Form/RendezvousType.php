<?php

namespace App\Form;

use App\Entity\Rendezvous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('daterendezvous', DateTimeType::class, [
                'widget' => 'single_text',
                'time_label' => 'Starts On',
                'required' => false,
                'constraints' => [
                    new NotNull(['message' => 'Saisir votre date de naissance']),
                    new DateTime(['message' => "Saisir votre date de naissance"]),
                ],
            ])
            ->add('objet', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => "Saisir votre objet"]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
}
