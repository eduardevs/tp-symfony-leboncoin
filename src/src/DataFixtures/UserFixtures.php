<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserFixtures extends Fixture
{

    /**
     * @var Generator
     */
    private Generator $faker ;

    private static $userRoles = [
        'SELLER_ADMIN',
        'SELLER_BASIC',
        'SHOPPER_BASIC',
    ];


    public function __construct() 
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstname($this->faker->firstName());
            $user->setLastname($this->faker->lastName());
            $user->setEmail($this->faker->email()) ;
            $user->setAddress($this->faker->address());
            $user->setCity($this->faker->city());
            $user->setPassword('password') ;
            $user->setRoles(self::$userRoles);
            $manager->persist($user);
        }
 
        $manager->flush();
    }
}