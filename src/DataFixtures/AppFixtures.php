<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Agent;
use App\Entity\Entrepreneur;
use App\Entity\Facture;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        for($i=0; $i<=10; $i++){
            $entrepreneur = new Entrepreneur();
            $entrepreneur
                ->setNom($faker->name)
                ->setPrenom($faker->lastName)
                ->setEmail($faker->email)
                ->setCin($faker->biasedNumberBetween($min = 10000000, $max = 99999999))
                ->setGenre($faker->randomElement($array = array('femme', 'homme')))
                ->setDatenais(new \DateTime())
                ->setPaynais('Tunisie')
                ->setTel($faker->biasedNumberBetween($min = 10000000, $max = 99999999))
                ->setDateexpcin(new \DateTime())
                ->setVillenais($faker->randomElement($array = array('Ariana',
                                                                    'Béja',
                                                                    'Ben Arous',
                                                                    'Bizerte',
                                                                    'Gabès',
                                                                    'Gafsa',
                                                                    'Jendouba',
                                                                    'Kairouan',
                                                                    'Kasserine',
                                                                    'Kébili',
                                                                    'Kef',
                                                                    'Mahdia',
                                                                    'Manouba',
                                                                    'Médenine',
                                                                    'Monastir',
                                                                    'Nabeul',
                                                                    'Sfax',
                                                                    'Sidi Bouzid',
                                                                    'Siliana',
                                                                    'Sousse',
                                                                    'Tataouine',
                                                                    'Tozeur',
                                                                    'Tunis',
                                                                    'Zaghouan'
                                                                    )))
                ->setEtat(false)
                ->setPassword($this->encoder->encodePassword($entrepreneur, 'test'))
                ;
                $nbT = 0;
                for($j=0; $j<=10; $j++){
                    $facture = new Facture();
                    $facture
                        ->setClient($faker->name." ".$faker->lastName)
                        ->setDateFact(new \DateTime('now'))
                        ->setMf($faker->ean13)
                        ->setTva(7)
                        ->setEntrepreneur($entrepreneur)
                        ;

                        for($k=0; $k<=$faker->biasedNumberBetween($min = 10, $max = 20); $k++){
                            $produit = new Produit();
                            $produit
                                ->setNom($faker->word)
                                ->setNb($faker->biasedNumberBetween($min = 1, $max = 10))
                                ->setPrixUnitaire(round($faker->randomFloat(), 3))
                                ->setPrixTotal($produit->getPrixUnitaire() * $produit->getNb())
                                ;
                            $nbT+=$produit->getPrixTotal();
                            $manager->persist($produit);
                            $facture->addProduit($produit);                
                        }
                    $facture
                        ->setPrixTTC($nbT)
                        ->setPrixHT(($nbT*100)/(100 + $facture->getTva()))
                    ;

                    $manager->persist($facture);
                }           

            $manager->persist($entrepreneur);
        }

        // admin fixture
        $admin = new Admin();
        $admin->setNom('Anis')
            ->setPrenom('Brahmi')
            ->setCin($faker->biasedNumberBetween($min = 10000000, $max = 99999999))
            ->setEmail('admin@gmail.com')
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            ;
        $manager->persist($admin);

        // agent fixture
        $agent = new Agent();
        $agent->setNom($faker->name)
            ->setPrenom($faker->lastName)
            ->setCin($faker->biasedNumberBetween($min = 10000000, $max = 99999999))
            ->setEmail('agent@gmail.com')
            ->setPassword($this->encoder->encodePassword($agent, 'agent'))
            ;
        $manager->persist($agent);

        $manager->flush();
    }
}
