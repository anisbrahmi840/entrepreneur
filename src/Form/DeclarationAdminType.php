<?php

namespace App\Form;

use App\Entity\Declaration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DeclarationAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_cr', DateType::class, [
                'label' => "Date de déclaration de trimestre",
            ])
            ->add('date_ex', DateType::class, [
                'label' => "Date exigibilité",
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
