<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Agent;
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
