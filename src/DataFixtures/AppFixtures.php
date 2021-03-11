<?php

namespace App\DataFixtures;

use App\Entity\Entrepreneur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

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
        for($i=1; $i<=10; $i++){
            $entrepreneur = new Entrepreneur();
            $entrepreneur
                ->setNom($faker->name)
                ->setPrenom($faker->lastName)
                ->setEmail($faker->email)
                ->setCin($faker->biasedNumberBetween($min = 8, $max = 8))
                ->setGenre($faker->randomElement($array = array('femme', 'homme')))
                ->setDatenais(new \DateTime())
                ->setPaynais('Tunisie')
                ->setTel($faker->biasedNumberBetween($min = 8, $max = 8))
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
            $manager->persist($entrepreneur);
        }

        $manager->flush();
    }
}
