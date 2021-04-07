<?php

namespace App\DataFixtures;

use App\Entity\Activite;
use App\Entity\Admin;
use App\Entity\Agent;
use App\Entity\Declaration;
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
                        ->setType($faker->randomElement($array = array ('facture','devis')))
                    ;
                    if ($facture->getType() == 'facture') {
                        $facture->setRef(uniqid('Fac-'));
                    }else{
                        $facture->setRef(uniqid('Dev-'));
                    }

                    $manager->persist($facture);
                }           

            $manager->persist($entrepreneur);
            $declaration1 = new Declaration();
            $declaration1
                ->setEntrepreneur($entrepreneur)
                ->setDateCr(new \DateTime('yesterday'))
                ->setDateEx(date_add(new \DateTime('yesterday'), date_interval_create_from_date_string('14 days')))
                ->setRef(uniqid('Dec-'))
                ;
            $manager->persist($declaration1);

            for ($d=0; $d <= 10; $d++) { 
                $declaration = new Declaration();
                if((bool) mt_rand(0, 1)){
                    $declaration
                    ->setEntrepreneur($entrepreneur)
                    ->setChiffre($faker->randomFloat())
                    ->setDateDec($faker->dateTime())
                    ->setDateEx($faker->dateTime())
                    ->setDateCr($faker->dateTime())
                    ->setPenalite($faker->randomFloat())
                    ->setCotisation($faker->randomFloat())
                    ->setEtat(true)
                    ->setTotalapayer($declaration->getPenalite()+$declaration->getCotisation())
                    ->setRef(uniqid('Dec-'))
                    ;
                }else{
                    $declaration
                    ->setEntrepreneur($entrepreneur)
                    ->setDateEx($faker->dateTime())
                    ->setDateCr($faker->dateTime())
                    ->setRef(uniqid('Dec-'))
                    ;
                }                
                $manager->persist($declaration);
            }
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

        //secteur
        $acitvite = new Activite();
        $activite2 = new Activite();
        $activite3= new Activite();
        $activite4= new Activite();
        $activite5 = new Activite();
        
        $acitvite
            ->setNom("Secteur de l'industrie")
            ->setTaux(0.5)
            ;
        $activite2
            ->setNom("Secteur de l'agriculture")
            ->setTaux(0.5)
            ;
        $activite3
            ->setNom("Secteur du commerce")
            ->setTaux(0.5)
            ;
        $activite4
            ->setNom("Secteur des services")
            ->setTaux(0.5)
            ;
        $activite5
            ->setNom("Secteur de l’artisanat ou des métiers")
            ->setTaux(0.5)
            ;
            $manager->persist($acitvite);
            $manager->persist($activite2);
            $manager->persist($activite3);
            $manager->persist($activite4);
            $manager->persist($activite5);
            // agent fixture
        for ($i=0; $i < 20; $i++) { 
            $agent = new Agent();
            $agent->setNom($faker->name)
                ->setPrenom($faker->lastName)
                ->setCin($faker->biasedNumberBetween($min = 10000000, $max = 99999999))
                ->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($agent, 'agent'))
                ;
            $manager->persist($agent);
        }

        $manager->flush();
    }
}
