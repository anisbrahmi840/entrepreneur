<?php

namespace App\Form;

use App\Entity\Rendezvous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RendezvousAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etat')
            ->add('observation', ChoiceType::class,[
                'required' => false,
                'choices'  => [
                    'Confirmé' => 'Confirmé',
                    'Refusé' => 'Refusé',
                    'Refusé - Date invalide' => 'Refusé - Date invalide'

                ],
                'constraints' => [
                    new NotBlank(['message' => 'Saisir votre genre']),
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
