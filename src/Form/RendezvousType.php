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
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('daterendezvous', DateTimeType::class, [
                'label' => 'Date de rendez-vous',
                'date_widget' => 'single_text',
                'hours' => ['8','9','10','11','13','14','15','16',],
                'minutes' => ['00', '30'],
                'required' => false,
                'placeholder' => [
                    'hour' => 'hh', 'minute' => 'mm',
                ],
                'constraints' => [
                    new NotNull(['message' => 'Saisir votre date de naissance']),
                    new DateTime(['message' => "Saisir votre date de naissance"]),
                    new GreaterThan('now', 'message'),
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
