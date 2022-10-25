<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Image;
use App\Entity\Question;
use App\Entity\Response;
use App\Factory\UserFactory;
use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
use App\Factory\ImageFactory;

class AppFixtures extends Fixture
{

    // /**
    //  * @var Generator
    //  */
    
    // private Generator $faker;

    // public function __construct(){
    //     $this->faker=Factory::create("fr_FR");
    // }

    public function load(ObjectManager $manager): void
    {
        
        UserFactory::createMany(10);
        CategoryFactory::createMany(7);
        PostFactory::createMany(10, function(){
            return ['userId' => UserFactory::random()];
        });
        ImageFactory::createMany(15, function(){
            return ['postId' => PostFactory::random()];
        });
        PostFactory::all(function(){
            return ['images' => ImageFactory::random()];
        });
        PostFactory::all(function(){
            return ['category' => CategoryFactory::random()];
        });
        
    }
}
