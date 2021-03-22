<?php

namespace App\Form;

use App\Entity\Entrepreneur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EntrepreneurEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            'constraints' => [
                new NotBlank(['message' => 'Saisir votre genre']),
            ],
        ])
        ->add('datenais', DateType::class, [
            'required' => false,
            'label' => 'Date de naissance',
            'widget' => 'single_text',             
            'constraints' => [
                new NotNull(['message' => 'Saisir votre date de naissance']),
                new Date(['message' => "Saisir votre date de naissance"]),
            ],
        ])
        ->add('villenais', ChoiceType::class, [
            'required' => false,
            'label' => 'Ville de naissance',
            'choices' => [
              'Ariana'  =>'Ariana',
               'Béja' =>'Béja',
               'Ben Arous'=>'Ben Arous',
               'Bizerte' =>'Bizerte',
               'Gabès'=>'Gabès',
               'Gafsa' =>'Gafsa',
               'Jendouba'=>'Jendouba',
               'Kairouan' =>'Kairouan',
               'Kasserine' =>'Kasserine',
               'Kébili' => 'Kébili',
               'Kef' =>'Kef',
               'Mahdia' =>'Mahdia',
               'Manouba' =>'Manouba',
               'Médenine' =>'Médenine',
               'Monastir' =>'Monastir',
               'Nabeul' =>'Nabeul',
               'Sfax' =>'Sfax',
               'Sidi Bouzid' =>'Sidi Bouzid',
               'Siliana' =>'Siliana',
               'Sousse' =>'Sousse',
               'Tataouine' =>'Tataouine',
               'Tozeur' => 'Tozeur',
               'Tunis' => 'Tunis',
               'Zaghouan' => 'Zaghouan'
            ],
            'constraints' => [
                new NotBlank(['message' => 'Saisir votre ville']),
            ],
        ])
        ->add('dateexpcin', DateType::class, [
            'required' => false,
            'label' => 'Date de création',
            'widget' => 'single_text',
            'constraints' => [
                new NotNull(['message' => 'Saisir votre date de naissance']),
                new Date(['message' => "Saisir votre date de naissance"]),
            ],
        ])
        ->add('tel', IntegerType::class, [
            'required' => false,
            'label' => 'Téléphone',
            'constraints' => [
                new NotBlank(['message' => 'Saisir votre téléphone']),
                new Length(['min' => 8,'minMessage' => "mot de passe minimum 8 caractères",                    
                            'max' => 8,'maxMessage' => "mot de passe maximum 8 caractères",
                            'exactMessage' => "le mot de passe doit être de 8 caractères"]),
            ],
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
