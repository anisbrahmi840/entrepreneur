<?php

namespace App\Form;

use App\Entity\Rendezvous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('daterendezvous', DateTimeType::class, [
                'widget' => 'single_text',
                'time_label' => 'Starts On',
                'input_format' => 'Y/m/Y H',
                'hours' => ['08','09','10','11','13','14','15','16'],
                'minutes' => ['00','30'],
                'input' => 'datetime',
            ])
            ->add('objet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
}
