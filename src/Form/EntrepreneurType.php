<?php

namespace App\Form;

use App\Entity\Entrepreneur;
use Locale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntrepreneurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [                
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir votre Email']),
                ],
            ])
            ->add('password', PasswordType::class, [            
                'required' => true,
                'constraints' => [
                    new Length(['min' => 6, 'minMessage' => "mot de passe minimum 6 caractères"]),
                ],
            ])
            ->add('nom', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir votre nom']),
                ],
            ])
            ->add('prenom', TextType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir votre prenom']),
                ],
            ])
            ->add('cin', IntegerType::class, [                
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Saisir votre mot de passe']),
                    new Length(['min' => 8,'minMessage' => "mot de passe minimum 8 caractères"]),
                ],
            ])
            ->add('genre', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Femme' => 'femme',
                    'Homme' => 'homme'
                ],
            ])
            ->add('datenais', DateType::class, [
                'required' => false,
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ])
            ->add('villenais', TextType::class, [
                'required' => false,
                'label' => 'Ville de naissance'
            ])
            ->add('paynais', CountryType::class, [
                'required' => false,
                'label' => 'Pays de naissance',
                'preferred_choices' => array('TN')
            ])
            ->add('dateexpcin', DateType::class, [
                'required' => false,
                'label' => 'Date de expiration',
                'widget' => 'single_text'])
            ->add('tel', IntegerType::class, [
                'required' => false,
                'label' => 'Téléphone'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entrepreneur::class,
        ]);
    }
}
